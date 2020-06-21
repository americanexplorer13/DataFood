<?php

$DBuser = $_POST['DBuser'];
$DBpass = $_POST['DBpass'];
$ModuleProjectID = $_POST['ModuleProjectID'];
$IsHandleSetInCenter = $_POST['IsHandleSetInCenter'];

include('update_project.php');

try {
$pdo = new PDO('mysql:host=127.0.0.1;dbname=u162837001_modul', $DBuser, $DBpass);

$sql = "DELETE FROM Module WHERE ModuleProjectID = ?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$ModuleProjectID]);

$sql = "DELETE FROM ModulePrice WHERE ModuleProjectID = ?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$ModuleProjectID]);

} catch (\PDOException $e) {
throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>