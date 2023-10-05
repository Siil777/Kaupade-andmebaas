<?php
 require("abifunktsioonid.php");
 if(isSet($_REQUEST["sort"])){
 $kaubad=kysiKaupadeAndmed($_REQUEST["sort"]);
 } else {
 $kaubad=kysiKaupadeAndmed();
 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 <title>Kaupade leht</title>
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />  </head>
 <body>
 <h1>Kaubade leht</h1>
 <table>
 <tr>
     <th><a href="sortimine.php?sort=nimetus">Nimetus</a></th>
     <th><a href="sortimine.php?sort=grupinimi">Kaubagrupp</a></th>
     <th><a href="sortimine.php?sort=hind">Hind</a></th>
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