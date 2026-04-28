<?php

include('bdd/bdd.php');
include('model/coach/coachModel.php');

$coach = new Coach($bdd);
$coachById = $coach->selectById($_GET['id_coach']); // ou $_POST selon ton appel

?>