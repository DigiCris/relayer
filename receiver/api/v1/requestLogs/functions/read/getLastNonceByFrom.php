<?php

include_once 'requestLogsHandler.php';

function getLastNonceByFrom($from)
{
    $logs = new requestLogs();
    $logs->set_from($from);
    $success['response'] = $logs->readLastNonceByFrom();

    if($success['response'] !== null){
        $success['success'] = true;
        $success['msg'] = 'last nonce fetched.';
    } else {
        $success['success'] = false;
        $success['msg'] = 'We could not fetch the last nonce for this from';
    }

    return $success;
}