<?php

header('Content-Type: application/json');

if(isset($_SERVER['PHP_AUTH_USER']) 
        && isset($_GET['apikey'])) {

    require_once 'db.php';

    $sql = "SELECT * FROM app WHERE app_id = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($_GET['apikey'] == $result['apikey']) {

        $sql = "SELECT * FROM app_monkey 
                    WHERE app_monkey_id = :app_monkey_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':app_monkey_id', $_SERVER['PHP_AUTH_USER']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($result['token']) 
            && $result['token'] == $_SERVER['PHP_AUTH_PW']) { 

            $bananas = array();
            $bananas['bananas'] = Rand(1, 100);
            $bananas['security'] = "oauth";

            $json_bananas = json_encode($bananas, JSON_PRETTY_PRINT);
            echo $json_bananas;

        } else {

            $error['error'] = "wrong app_monkey_id or token in oauth!";
            $error['result'] = $result;
            
            $json = json_encode ($error);
            echo $json;
        
        }
    } else {

        $error['error'] = "wrong apikey in oauth";
        $error['result'] = $result;
        
        $json = json_encode ($error);
        echo $json;
    
    }
} else {

    $error['error'] = "basicauth failed";
    $error['result'] = $result;
    
    $json = json_encode ($error);
    echo $json;

}