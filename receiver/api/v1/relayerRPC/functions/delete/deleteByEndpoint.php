
<?php

include_once 'relayerRPCHandler.php';

/*!
* \brief       delete all that matches endpoint in relayerRPC
* \details     Search in the database relayerRPC that matches endpoint and delete it if it exists.
* \param       (VARCHAR) endpoint The identifier of the row/rows in the relayerRPC table to delete.
* \return    $success['response'] (bool) Returns true if the row/rows was/were deleted, false if not.
* \return    $success['success'] (bool) Returns true if the request was succesful, false if not.
* \return    $success['msg'] (string) Returns a message explaining the status of the execution.
** \return • 'relayerRPC deleted.' -> When was able to delete the relayerRPC row/rows.
** \return • 'It was not possible to erase the relayerRPC row/rows requested. Try again later.' -> When it fails to delete the row.
** \return • 'This relayerRPC did not exist.' -> When the relayerRPC endpoint was not found or did not exist. 
*/
function deleteByEndpoint($endpoint) {
    $register = new relayerRPC();
    $exists = $register->readEndpoint($endpoint);

    if(count($exists) > 0) {
        $success['response'] = $register->deleteByEndpoint($endpoint);
        $exists = $register->readEndpoint($endpoint);
        if(count($exists) > 0) {
            $success['success'] = false;
            $success['msg'] = 'It was not possible to erase the relayerRPC row/rows requested. Try again later.';
        }else {
            $success['success'] = true;
            $success['msg'] = 'relayerRPC deleted.';
        }
    }else {
        $success['success'] = false;
        $success['msg'] = 'This relayerRPC did not exists.';
    }
    return $success;
}
        
?>
    