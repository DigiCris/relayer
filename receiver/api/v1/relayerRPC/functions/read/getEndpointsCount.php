<?php
include_once 'relayerRPCHandler.php';


function getEndpointsCount()
{
    $rpc = new relayerRPC();
    $success['response'] = $rpc->readEndpointsCount();

    if($success['response']){
        $success['success'] = true;
        $success['msg'] = 'relayerRPCs fetched';
    } else {
        $success['success'] = false;
        $success['msg'] = 'We could not fetch the relayerRPCs count';
    }

    return $success;
}