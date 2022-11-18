<?php

header('Content-Type: application/json');

if(isset($_SERVER['PHP_AUTH_USER'])) {

    require_once 'db.php';

    $sql = "SELECT * FROM monkey WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $_SERVER['PHP_AUTH_USER']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($result['password']) 
        && $result['password'] == $_SERVER['PHP_AUTH_PW']) { 

        $token = uniqid();
        $sql = "UPDATE app_monkey SET token = :token 
                    WHERE monkey_id = :monkey_id
                    AND app_id = 
                    (SELECT app_id FROM app 
                        WHERE app_name = :app_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':monkey_id', $result['monkey_id']);
        $stmt->bindParam(':app_name', $_GET['appname']);
        $stmt->execute();

        $sql = "SELECT * FROM app_monkey 
                    WHERE monkey_id = :monkey_id
                    AND app_id = 
                    (SELECT app_id FROM app 
                        WHERE app_name = :app_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':monkey_id', $result['monkey_id']);
        $stmt->bindParam(':app_name', $_GET['appname']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $bananas = array();
        //$bananas['bananas'] = Rand(1, 100);
        //$bananas['security'] = "basicauth";
        $bananas['token'] = $token;
        $bananas['app_monkey_id'] = $result['app_monkey_id'];

        $json_bananas = json_encode($bananas, JSON_PRETTY_PRINT);
        echo $json_bananas;

    } else {

        $error['error'] = "wrong username or password!";
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