<h1>OAuth Banana Eater</h1>
<h4>Retrieving token</h4>
<?php

$BANANA_BASICAUTH = 
    "http://localhost:8080/banana_oauth_monkey.php"
    . "?appname=monkeysite";
$username = "adam";
$password = "mom";

$request = array(
    "http" => array(
        "header" => array(
            "Content-Type: application/json",
            "Authorization: Basic " .
                base64_encode ($username . ":" . $password)
        ),
        "method" => "GET",
        "protocol_version" => 1.1,
        
    )
);

$context = stream_context_create($request);
$data = file_get_contents($BANANA_BASICAUTH, false, $context);

$object = json_decode($data);

//print_r($data);

?>
<h4>Send token <?=$object->token?> to monkeysite</h4>
<?php

$MONKEYSITE_OAUTH_URL = 
    "http://localhost:8081/monkeysite_oauth.php";

$request = array(
    "http" => array(
        "header" => array(
            "Content-Type: application/json",
            "Authorization: Basic " .
                base64_encode ($object->app_monkey_id . ":" . $object->token)
        ),
        "method" => "GET",
        "protocol_version" => 1.1
    )
);

$context = stream_context_create($request);
$data = file_get_contents($MONKEYSITE_OAUTH_URL, false, $context);

$object = json_decode($data);

//echo $data;

echo 'I just got ' . $object->bananas 
    . ' bananas from an api, using ' . $object->security
    . ' security';


