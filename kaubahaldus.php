<?php

require("abifunktsioonid.php");
session_start();
$sorttulp = "nimetus";
$otsisona = "";

if (isset($_REQUEST["sort"])) {
    $sorttulp = $_REQUEST["sort"];
}

if (isset($_REQUEST["otsisona"])) {
    $otsisona = $_REQUEST["otsisona"];
}

if(isSet($_REQUEST["grupilisamine"])){
    lisaGrupp($_REQUEST["uuegrupinimi"]);
    header("Location: kaubahaldus.php");
    exit();
}
if(isSet($_REQUEST["kaubalisamine"])){
    lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
    header("Location: kaubahaldus.php");
    exit();

}


if(isSet($_REQUEST["kustutusid"])){
    kustutaKaup($_REQUEST["kustutusid"]);
}
if(isSet($_REQUEST["muutmine"])){
    muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
        $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);

}

$kaubad=kysiKaupadeAndmed($sorttulp, $otsisona);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>
<body>
<h1 class="w3-panel w3-border-top w3-border-bottom w3-border-green"> kaupade andmebaas </h1>
<form action="kaubahaldus.php" class="w3-panel w3-border w3-round-xlarge">
    <h2>Kauba lisamine</h2>
    <dl>
        <dt>Nimetus:</dt>
        <dd><input class="w3-animate-input" type="text" name="nimetus" /></dd>
        <dt>Kaubagrupp:</dt>
        <dd>
            <?php
            echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id");
            ?>
        </dd>
        <dt>Hind:</dt>
        <dd><input class="w3-animate-input" type="text" name="hind" /></dd>
    </dl>
    <input type="submit" name="kaubalisamine" value="Lisa kaup" />

</form>


<form action="kaubahaldus.php" class="w3-panel w3-border w3-round-xlarge">
    <h2>Grupi lisamine</h2>
    <input type="text" name="uuegrupinimi" />
    <input type="submit" name="grupilisamine" value="Lisa grupp" />
</form>

<form action="?">

    <div class="w3-panel w3-border w3-round-xlarge">
        <h2>Kaupade loetelu</h2>
        Otsi: <input type="text" name="otsisona" />
        <br>
        <input type="submit" value="Otsi" />
    </div>
    <br>
    <table class="w3-table w3-striped w3-bordered">
        <tr>
            <th><a href="kaubahaldus.php?sort=haldus">Haldus</a></th>
            <th><a href="kaubahaldus.php?sort=nimetus">Nimetus</a></th>
            <th><a href="kaubahaldus.php?sort=grupinimi">Kaubagrupp</a></th>
            <th><a href="kaubahaldus.php?sort=hind">Hind</a></th>
            <th><a href="kaubahaldus.php?kustutusid=">Kustuta</a></th>
        </tr>


        <?php foreach($kaubad as $kaup): ?>

        <tr>
            <?php if (isset($_REQUEST["muutmisid"]) && intval($_REQUEST["muutmisid"]) == $kaup->id): ?>
                <td>
                    <form action="kaubahaldus.php" method="post">
                        <input type="submit" name="muutmine" value="Muuda" />
                        <input type="submit" name="katkestus" value="Katkesta" />
                        <input type="hidden" name="muudetudid" value="<?= $kaup->id ?>" />
                    </form>
                </td>
                <td><input type="text" name="nimetus" value="<?= $kaup->nimetus ?>" /></td>
                <td><?php echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", "kaubagrupi_id"); ?></td>
                <td><input type="text" name="hind" value="<?= $kaup->hind ?>" /></td>
            <?php else: ?>
                <td><a class="w3-btn w3-green" href="kaubahaldus.php?muutmisid=<?= $kaup->id ?>">Muuda</a></td>
                <td><?=$kaup->nimetus ?></td>
                <td><?=$kaup->grupinimi ?></td>
                <td><?=$kaup->hind ?></td>
            <?php endif; ?>
            <td>
                <a href="kaubahaldus.php?kustutusid=<?= $kaup->id ?>" class="w3-btn w3-red" onclick="return confirm('Kas ikka soovid kustutada?')"> Kustuta</a>
            </td>
        </tr>
    <?php endforeach; ?>

    </table>

</form>
</body>
</html>





<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
</style>

<style>
    form {
        max-width: 400px;
        margin: 0 auto;
    }

    h2 {
        background-color: #f2f2f2;
        padding: 10px;
        border-radius: 5px;
    }

    dl {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-gap: 10px;
        margin-bottom: 15px;
    }

    dt {
        font-weight: bold;
    }

    dd {
        margin: 0;
    }

    input[type="text"] {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>

<style>

    button {
        background-color: green;
        color: white;
        border: none;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }
</style>

<style>
    body {
        background-color: #fff;
        color: #333;
        font-size: 16px;
        font-family: sans-serif;
        line-height: 1.5;
        margin: 0;
        padding: 0;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background-image: url('img/1.jpg');
        background-repeat: no-repeat;
        background-size: cover;

        opacity: 0.1;
    }
</style>