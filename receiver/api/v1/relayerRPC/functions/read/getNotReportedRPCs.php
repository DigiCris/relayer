<?php

include_once 'relayerRPCHandler.php';

function getNotReportedRPCs($consecutiveMissQuantity, $notReportedTime)
{
    $rpc = new relayerRPC();
    $response['response'] = $rpc->readNotReportedRPCs($consecutiveMissQuantity, $notReportedTime);

    if(empty($response['response'])){
        return ['success' => false, 'msg' => 'No faulty and unreported RPCs.'];
    } else {
        return ['response' => $response['response'], 'success' => true ,'msg' => 'RPCs were found to be flawed. Please send an email.'];
    }
}