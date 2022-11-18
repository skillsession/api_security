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

        $bananas = array();
        $bananas['bananas'] = Rand(1, 100);
        $bananas['security'] = "basicauth";

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