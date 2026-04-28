<?php

include('bdd/bdd.php');
include('model/client/clientModel.php');

$client = new Client($bdd);
$clientById = $client->selectById($_GET['id_client']); 

?>