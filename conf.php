<?php
$serverinimi="localhost"; //d70420.mysql.zonevs.eu
$kasutajanimi="pavelivanov";
$parool="123456";
$andmebaas="pavelivanov";
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaas);
$yhendus->set_charset('UTF8');