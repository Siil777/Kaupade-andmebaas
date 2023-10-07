<?php
require ('conf.php');
global $yhendus;

//soterib nimetuse gruppinimi ja hinna jargi ja teeb otsingut tabelist sisestatud teksti järgi
function kysiKaupadeAndmed($sorttulp="nimetus", $otsisona=""){
    global $yhendus;
    $lubatudtulbad=array("nimetus", "grupinimi", "hind");
    if(!in_array($sorttulp, $lubatudtulbad)){
        return "lubamatu tulp";
    }
    $otsisona=addslashes(stripslashes($otsisona));
    $kask=$yhendus->prepare("SELECT kaubad.id, nimetus, grupinimi, hind  FROM kaubad, kaubagrupid 
 WHERE kaubad.kaubagrupi_id=kaubagrupid.id 
 AND (nimetus LIKE '%$otsisona%' OR grupinimi LIKE '%$otsisona%')  ORDER BY $sorttulp");
    //echo $yhendus->error;
    $kask->bind_result($id, $nimetus, $grupinimi, $hind);
    $kask->execute();
    $hoidla=array();
    while($kask->fetch()){
        $kaup=new stdClass();
        $kaup->id=$id;
        $kaup->nimetus=htmlspecialchars($nimetus);
        $kaup->grupinimi=htmlspecialchars($grupinimi);
        $kaup->hind=$hind;
        array_push($hoidla, $kaup);
    }
    return $hoidla;
}
//teeb nimetusest drop list
function looRippMenyy($sqllause, $valikunimi){
    global $yhendus;
    $kask=$yhendus->prepare($sqllause);
    $kask->bind_result($id, $sisu);
    $kask->execute();
    $tulemus="<select name='$valikunimi'>";
    while($kask->fetch()){
        $tulemus.="<option value='$id'>$sisu</option>";
    }
    $tulemus.="</select>";
    return $tulemus;
}
//lisab andmetabeli uus kaubagrupp
function lisaGrupp($grupinimi){
    global $yhendus;

    if (empty($grupinimi)) {
        echo '<script>alert("Sisesta grupp!")</script>';
        return;
    }

    // Check if the group name already exists
    $existingGroup = $yhendus->prepare("SELECT grupinimi FROM kaubagrupid WHERE grupinimi = ?");
    $existingGroup->bind_param("s", $grupinimi);
    $existingGroup->execute();
    $existingGroup->store_result();

    // If the group name already exists, display an alert and return
    if ($existingGroup->num_rows > 0) {
        echo '<script>alert("Selline grupp on juba olemas!")</script>';
        return;
    }

    // If the group name does not exist, insert it into the database
    $insertCommand = $yhendus->prepare("INSERT INTO kaubagrupid (grupinimi) VALUES (?)");
    $insertCommand->bind_param("s", $grupinimi);
    $insertCommand->execute();
}

// lisab uue kauba, kontrollides, kas materjal eksisteerib juba teistes gruppides
function lisaKaup($nimetus, $kaubagrupi_id, $hind) {
    global $yhendus;

    // Check if the form is submitted
    if (isset($_REQUEST["kaubalisamine"])) {

        // Check if inputs are empty
        if (empty($nimetus) || empty($kaubagrupi_id) || empty($hind)) {
            echo '<script>alert("Sisesta andmed!")</script>';
            return;
        }

        // Check if the data already exists in any group
        $existingDataCheck = $yhendus->prepare("SELECT COUNT(*) FROM kaubad WHERE nimetus = ?");
        $existingDataCheck->bind_param("s", $nimetus);
        $existingDataCheck->execute();
        $existingDataCheck->bind_result($count);
        $existingDataCheck->fetch();
        $existingDataCheck->close();

        if ($count > 0) {
            echo '<script>alert("Need andmed on juba baasis olemas!")</script>';
            return;
        }

        // Data does not exist, proceed with insertion
        $insertQuery = $yhendus->prepare("INSERT INTO kaubad (nimetus, kaubagrupi_id, hind) VALUES (?, ?, ?)");
        $insertQuery->bind_param("sdi", $nimetus, $kaubagrupi_id, $hind);
        $insertQuery->execute();
        $insertQuery->close();
    }
}

//kustuta kaup tabelist
function kustutaKaup($kauba_id){

    global $yhendus;

    $kask=$yhendus->prepare("DELETE FROM kaubad WHERE id=?");

 $kask->bind_param("i", $kauba_id);

 $kask->execute();

 }
//update kaup
function muudaKaup($kauba_id, $nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE kaubad SET nimetus=?, kaubagrupi_id=?, hind=?  WHERE id=?");
    $kask->bind_param("sidi", $nimetus, $kaubagrupi_id, $hind, $kauba_id);  $kask->execute();
}




?>
<?php

?>



