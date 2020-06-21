<?php

$DBuser = $_POST['DBuser'];
$DBpass = $_POST['DBpass'];
$MaterialID = $_POST['MaterialID'];
$ModuleProjectID = $_POST['ModuleProjectID'];
$IsHandleSetInCenter = $_POST['IsHandleSetInCenter'];
$IsHandleBronxeType = $_POST['IsHandleBronxeType'];
$ProjectName = $_POST['ProjectName'];

$sinkLong = $_POST['sinkLong'];
$sinkWidth = $_POST['sinkWidth'];
$sinkAlign = $_POST['sinkAlign'];
$margin = $_POST['margin'];
$sinkShape = $_POST['sinkShape'];
$sinkDash = $_POST['sinkDash'];
$leftMarginSinkDash = $_POST['leftMarginSinkDash'];
$rightMarginSinkDash = $_POST['rightMarginSinkDash'];
$seriaID = $_POST['seriaID'];

try {
$pdo = new PDO('mysql:host=127.0.0.1;dbname=u162837001_modul', $DBuser, $DBpass);

$sql = "INSERT INTO Project (ProjectName, ProjectDateCreate, MaterialID, IsHandleSetInCenter, IsHandleBronxeType, sinkLong, sinkWidth, sinkAlign, margin, sinkShape, sinkDash, leftMarginSinkDash, rightMarginSinkDash, SeriaID) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt= $pdo->prepare($sql);
$stmt->execute([$ProjectName,getdate(),$MaterialID,$IsHandleSetInCenter,$IsHandleBronxeType,$sinkLong, $sinkWidth, $sinkAlign, $margin, $sinkShape, $sinkDash, $leftMarginSinkDash, $rightMarginSinkDash, $seriaID]);
$id = $pdo->lastInsertId();
echo $id;

} catch (\PDOException $e) {
throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>