<?php
require("abifunktsioonid.php");
$kaubad=kysiKaupadeAndmed();
?>
<!DOCTYPE html">
<html lang="et">
<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />  </head>
<body>
<table>
    <tr>
        <th>Nimetus</th>
        <th>Kaubagrupp</th>
        <th>Hind</th>
    </tr>
    <?php foreach($kaubad as $kaup): ?>
        <tr>
            <td><?=$kaup->nimetus ?></td>
            <td><?=$kaup->grupinimi ?></td>
            <td><?=$kaup->hind ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        margin: auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>