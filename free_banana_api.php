<?php

    header('Content-type: application/json');

    $bananas = array();
    $bananas['bananas'] = Rand(1, 100);
    $bananas['security'] = "none!";

    $json_bananas = json_encode($bananas, JSON_PRETTY_PRINT);
    echo $json_bananas;