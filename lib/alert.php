<?php
$alertData = [
    "type" => "error",
    "message" => ""
];

function setAlert($message, $type = "success") {
    global $alertData;
    $alertData["type"] = $type;
    $alertData["message"] = $message;
}

function resetAlert() {
    global $alertData;
    $alertData["type"] = "success";
    $alertData["message"] = "";
}

$alert_type = $_GET["alertType"];
$alert_message = $_GET["alertMessage"];
if (!empty($alert_type) && !empty($alert_message)) {
    $message = urldecode($alert_message);
    setAlert($message, $alert_type);
}