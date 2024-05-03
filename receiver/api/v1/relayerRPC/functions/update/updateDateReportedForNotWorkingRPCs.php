<?php

include_once 'relayerRPCHandler.php';

function updateDateReportedForNotWorkingRPCs($consecutiveMissQuantity, $hourTime)
{
    $rpc = new relayerRPC();
    $updated = $rpc->updateDateReportedForNotWorkingRPCs($consecutiveMissQuantity, $hourTime);
    if(!$updated){
        return ['success' => false, 'msg' => 'We cant update right now. Try again later'];
    } else {
        return ['success' => true, 'msg' => 'dateReported for not working RPCs updated'];
    }
}