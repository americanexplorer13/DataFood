<?php

function processMessage() {
    #$str1 = '{"fulfillmentMessages":[{"text": {"text":["30 июня 2020, в 10:00 доп:"]}}],"outputContexts": [';
    #$str2 = '{"name": "projects/project-id/agent/sessions/session-id/contexts/process","lifespanCount": 5,"parameters": {"param-name": "param-value"}}]}';
    $data1 = '{"fulfillmentMessages":[{"text": {"text":["Пожалуйста, укажите категорию, к которой относится ваш продукт: (мясо, салат, х/б изделие…)"]}}],"outputContexts": [{"name": "projects/project-id/agent/sessions/session-id/contexts/PK","lifespanCount": 5,"parameters": {"param-name": "param-value"}}]}';
    #$data1 = $str1 . $str2;
    sendMessage($data1);
}

function processMessage2() {
    $data1 = '{"fulfillmentMessages":[{"text": {"text":["Пожалуйста, введите описание продукта.
Не забудьте упомянуть срок годности!"]}}],"outputContexts": [{"name": "projects/project-id/agent/sessions/session-id/contexts/POP","lifespanCount": 5,"parameters": {"param-name": "param-value"}}]}';
    sendMessage($data1);
}
function processMessage3() {
    $data1 = '{"fulfillmentMessages":[{"text": {"text":["Пожалуйста, укажите контактную информацию, чтобы с вами связались! (телефон, почта)"]}}],"outputContexts": [{"name": "projects/project-id/agent/sessions/session-id/contexts/PKON","lifespanCount": 5,"parameters": {"param-name": "param-value"}}]}';
    sendMessage($data1);
}

function processMessage4() {
    $data1 = '{"fulfillmentMessages":[{"text": {"text":["Ожидайте, с вами свяжутся!"]}}]}';
    sendMessage($data1);
}



function sendMessage($parameters) {
    header('Content-Type: application/json');
    #$data = str_replace('\/','/',json_encode($parameters));
    #$data = json_encode($parameters);
    $data = $parameters;
    echo $data;
}

$json = file_get_contents('php://input');
$request = json_decode($json, true);
#$action = $request['result']['action'];
$address = null;
$id = null;
if(array_key_exists('adres', $request['queryResult']['parameters'])){
    $address = $request['queryResult']['parameters']['adres'];
}
$id = null;
if(array_key_exists('id', $request['queryResult']['parameters'])){
    $id = $request['queryResult']['parameters']['id'];
}
$kategpr = null;
if(array_key_exists('kategpr', $request['queryResult']['parameters'])){
    $kategpr = $request['queryResult']['parameters']['kategpr'];
}
$description = null;
if(array_key_exists('opisanie', $request['queryResult']['parameters'])){
    $description = $request['queryResult']['parameters']['opisanie'];
}

$contact = null;
if(array_key_exists('kontakt', $request['queryResult']['parameters'])){
    $contact = $request['queryResult']['parameters']['kontakt'];
}

$listContext = $request['queryResult']['outputContexts'];
#$intent = count($listContext);
$str = "";
$strAr = 'lifespanCount';
if(is_null($kategpr) 
    & is_null($description)
    & is_null($contact)){
    processMessage();
}else if (is_null($description)
        & is_null($contact)){
    processMessage2();
}else if(is_null($contact)){
    processMessage3();
}else{
    processMessage4();
}

#$intent1 = $listContext[0];
#$intent2 = $intent1['lifespanCount'];
#$intent2 = $intent1.['lifespanCount'];
#$intent2 = $intent1.['lifespanCount'];
#$param = $request["param1"];




?>