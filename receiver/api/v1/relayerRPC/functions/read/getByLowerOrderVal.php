<?php
include_once 'relayerRPCHandler.php';

function getByLowerOrderVal()
{
    $rpc = new relayerRPC();
    $success['response'] = $rpc->readByLowerOrderVal();

    if($success['response']){
        $success['success'] = true;
        $success['msg'] = 'relayerRPC fetched';
    } else {
        $success['success'] = false;
        $success['msg'] = 'We could not fetch the relayerRPCs.';
    }

    return $success;
}