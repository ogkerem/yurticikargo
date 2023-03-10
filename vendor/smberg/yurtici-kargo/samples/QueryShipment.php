<?php
require_once "vendor/autoload.php";

$request = new YurticiKargo\Request();
$request->setUser("YKTEST", "YK")->init("test");


$queryShipment = $request->queryShipment("0000113");

echo '<pre>';
print_r($queryShipment->getResultData());
echo '</pre>';