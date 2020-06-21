<?php

$DBuser = $_POST['DBuser'];
$DBpass = $_POST['DBpass'];

$ModuleID = $_POST['ModuleID'];
$PrefabID = $_POST['PrefabID'];
$ModuleProjectID = $_POST['ModuleProjectID'];
$CategoryID = $_POST['CategoryID'];
$DefaultWidthIndex= $_POST['DefaultWidthIndex'];
$IsAngle = $_POST['IsAngle'];
$ModuleName = $_POST['ModuleName'];
$PositionNumber = $_POST['PositionNumber'];
$WidthCurrentIndex = $_POST['WidthCurrentIndex'];
$WallTypeID= $_POST['WallTypeID'];
$BaseMaterialID = $_POST['BaseMaterialID'];
$BottomMatirialID = $_POST['BottomMatirialID'];
$IsFullHeight = $_POST['IsFullHeight'];
$IsHalfModule = $_POST['IsHalfModule'];
$IsSetUnderModule = $_POST['IsSetUnderModule'];
$IsUpperModule = $_POST['IsUpperModule'];
$IsWall = $_POST['IsWall'];
$LeftObjectModuleID = $_POST['LeftObjectModuleID'];
$ModuleNextAboveModuleID = $_POST['ModuleNextAboveModuleID'];
$RightObjectModuleID = $_POST['RightObjectModuleID'];
$BottomObjectModuleID = $_POST['BottomObjectModuleID'];
$TopMatirialID = $_POST['TopMatirialID'];
$ZeroPointID = $_POST['ZeroPointID'];
$TransformPositionX = $_POST['TransformPositionX'];
$TransformPositionY = $_POST['TransformPositionY'];
$TransformPositionZ = $_POST['TransformPositionZ'];

$TransformRotationX = $_POST['TransformRotationX'];
$TransformRotationY = $_POST['TransformRotationY'];
$TransformRotationZ = $_POST['TransformRotationZ'];
$TransformRotationW = $_POST['TransformRotationW'];

try {
$pdo = new PDO('mysql:host=127.0.0.1;dbname=u162837001_modul', $DBuser, $DBpass);

$sql = "UPDATE Module SET PrefabID=?, ModuleProjectID=?, CategoryID=?, DefaultWidthIndex=?, IsAngle=?, ModuleName=?, PositionNumber=?, WidthCurrentIndex=?, WallTypeID=?, BaseMaterialID=?, BottomMatirialID=?, IsFullHeight=?, IsHalfModule=?, IsSetUnderModule=?, IsUpperModule=?, IsWall=?, LeftObjectModuleID=?, ModuleNextAboveModuleID=?, RightObjectModuleID=?, BottomObjectModuleID=?, TopMatirialID=?, ZeroPointID=?, TransformPositionX=?, TransformPositionY=?, TransformPositionZ=?, TransformRotationX=?, TransformRotationY=?, TransformRotationZ=?, TransformRotationW=? WHERE ModuleID = ?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$PrefabID, $ModuleProjectID, $CategoryID, $DefaultWidthIndex, $IsAngle, $ModuleName, $PositionNumber, $WidthCurrentIndex, $WallTypeID, $BaseMaterialID, $BottomMatirialID, $IsFullHeight, $IsHalfModule, $IsSetUnderModule, $IsUpperModule, $IsWall, $LeftObjectModuleID, $ModuleNextAboveModuleID, $RightObjectModuleID, $BottomObjectModuleID, $TopMatirialID, $ZeroPointID, $TransformPositionX, $TransformPositionY, $TransformPositionZ, $TransformRotationX, $TransformRotationY, $TransformRotationZ, $TransformRotationW, $ModuleID]);

} catch (\PDOException $e) {
throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>