<?php

include_once 'relayerRPCHandler.php';

function resetConsecutiveMiss($id)
{
    $rpc = new relayerRPC();
    $exists = $rpc->readId($id);
    if(empty($exists)){
        return [
            'success' => false,
            'msg' => 'The id provided dont exists'
        ];
    }

    $reset = $rpc->resetConsecutiveMiss($id);
    if(!$reset){
        return [
            'success' => false,
            'msg' => 'We could not reset. Try again later'
        ];
    }

    $updated = $rpc->readId($id);
    if($updated[0]['consecutiveMiss'] == 0){
        return [
            'success' => true,
            'msg' => 'rpc consecutiveMiss has been reset'
        ];
    } else {
        return [
            'success' => false,
            'msg' => 'Error on the update'
        ];
    }
}