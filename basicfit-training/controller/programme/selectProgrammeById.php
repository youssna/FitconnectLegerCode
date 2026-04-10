<?php

include('bdd/bdd.php');
include('model/programme/programmeModel.php');

$programme = new Programme($bdd);
$programmeById = $programme->selectById($_GET['id_programme']);

?>