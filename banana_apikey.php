<?php

header('Content-type: application/json');

if(isset($_GET['apikey'])) {

    require_once 'db.php';

    $sql = "SELECT * FROM app WHERE app_id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($_GET['apikey'] == $result['apikey']) {

        $bananas = array();
        $bananas['bananas'] = Rand(1, 100);
        $bananas['security'] = "apikey";

        $json_bananas = json_encode($bananas, JSON_PRETTY_PRINT);
        echo $json_bananas;
    } else {

        $error['error'] = "wrong api key!";
        $error['result'] = $result;
        
        $json = json_encode ($error);
        echo $json;
    
    }

} else {

    $error['error'] = "api key error!";
    $error['result'] = $result;
    
    $json = json_encode ($error);
    echo $json;

}