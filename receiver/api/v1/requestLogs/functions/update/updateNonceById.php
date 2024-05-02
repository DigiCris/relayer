<?php

include_once 'requestLogsHandler.php';


function updateNonceById($id, $nonce)
{
    $request = new requestLogs();
    $exists = $request->readId($id);

    if(!$exists || empty($exists)){
        return [
            "success" => false,
            "msg" => 'This requestLog not exists'
        ];
    }

    $request->set_nonce($nonce);
    $updated = $request->updateNonceById($id);
    if(!$updated){
        return [
            "success" => false,
            "msg" => 'Error while updating requestLog nonce'
        ];
    }

    $equals = $request->readId($id);
    if($equals['response'][0]['nonce'] != $nonce){
        return [
            "success" => false,
            "msg" => 'We could not update. Try again later'
        ];
    } 

    return [
        "success" => true,
        "msg" => 'Nonce updated'
    ];
}