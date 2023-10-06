<?php
$serverinimi=""; 
$kasutajanimi="";
$parool="";
$andmebaas="";
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
