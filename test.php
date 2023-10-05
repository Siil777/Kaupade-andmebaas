<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<?php
require('conf.php');
require('abifunktsioonid.php');

$sorttulp = "nimetus";
$otsisona = "";

if (isset($_REQUEST["sort"])) {
    $sorttulp = $_REQUEST["sort"];
}

if (isset($_REQUEST["otsisona"])) {
    $otsisona = $_REQUEST["otsisona"];
}

if (isset($_REQUEST["grupilisamine"])) {
    $uuegrupinimi = $_REQUEST["uuegrupinimi"];
    // Insert new group directly into the kaubagrupid table
    $query = "INSERT INTO kaubagrupid (grupinimi) VALUES (:grupinimi)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':grupinimi', $uuegrupinimi, PDO::PARAM_STR);
    $stmt->execute();
}

if (isset($_REQUEST["kaubalisamine"])) {
    $nimetus = $_REQUEST["nimetus"];
    $kaubagrupi_id = $_REQUEST["kaubagrupi_id"];
    $hind = $_REQUEST["hind"];
    // Insert new product directly into the kaubad table
    $query = "INSERT INTO kaubad (nimetus, kaubagrupi_id, hind) VALUES (:nimetus, :kaubagrupi_id, :hind)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nimetus', $nimetus, PDO::PARAM_STR);
    $stmt->bindParam(':kaubagrupi_id', $kaubagrupi_id, PDO::PARAM_INT);
    $stmt->bindParam(':hind', $hind, PDO::PARAM_STR);
    $stmt->execute();
}

if (isset($_REQUEST["kustutusid"])) {
    // Handle deletion if needed
}

if (isset($_REQUEST["muutmine"])) {
    // Handle modification if needed
}

$kaubad = kysiKaupadeAndmed($sorttulp, $otsisona);
?>
<form action="kaubahaldus.php" method="post">
    <h2>Kauba lisamine</h2>
    <dl>
        <dt>Nimetus:</dt>
        <dd><input type="text" name="nimetus" /></dd>
        <dt>Kaubagrupp:</dt>
        <dd>
            <?php
            echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id");
            ?>
        </dd>
        <dt>Hind:</dt>
        <dd><input type="text" name="hind" /></dd>
    </dl>
    <input type="submit" name="kaubalisamine" value="Lisa kaup" />
</form>
<h2>Grupi lisamine</h2>
<form action="kaubahaldus.php" method="post">
    <input type="text" name="uuegrupinimi" />
    <input type="submit" name="grupilisamine" value="Lisa grupp" />
</form>
<form action="?">
    <h2>Kaupade loetelu</h2>
    Otsi: <input type="text" name="otsisona" />
    <br>
    <input type="submit" value="Otsi" />
    <br>
    <table>
        <tr>
            <th><a href="kaubahaldus.php?sort=haldus">Haldus</a></th>
            <th><a href="kaubahaldus.php?sort=nimetus">Nimetus</a></th>
            <th><a href="kaubahaldus.php?sort=kaubagrupp">Kaubagrupp</a></th>
            <th><a href="kaubahaldus.php?sort=hind">Hind</a></th>
        </tr>
        <?php foreach ($kaubad as $kaup): ?>
            <tr>
                <?php if (isset($_REQUEST["muutmisid"]) && intval($_REQUEST["muutmisid"]) == $kaup->id): ?>
                    <td>
                        <input type="submit" name="muutmine" value="Muuda" />
                        <input type="submit" name="katkestus" value="Katkesta" />
                        <input type="hidden" name="muudetudid" value="<?= $kaup->id ?>" />
                    </td>
                    <td><input type="text" name="nimetus" value="<?= $kaup->nimetus ?>" /></td>
                    <td><?php echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id"); ?></td>
                    <td><input type="text" name="hind" value="<?= $kaup->hind ?>" /></td>
                <?php else: ?>
                    <td>
                        <a href="kaubahaldus.php?kustutusid=<?= $kaup->id ?>" onclick="return confirm('Kas ikka soovid kustutada?')">x</a>
                        <a href="kaubahaldus.php?muutmisid=<?= $kaup->id ?>">m</a>
                    </td>
                    <td><?= $kaup->nimetus ?></td>
                    <td><?= $kaup->grupinimi ?></td>
                    <td><?= $kaup->hind ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    </table>
</form>
</body>
</html>
