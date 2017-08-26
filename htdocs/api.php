<?php

$output = array(
    'processtime' => time()
);
foreach ($_POST AS $key => $value) {
    $output[$key] = $value;
}

header('Content-Type: application/json; Charset=UTF-8');
print json_encode($output);
