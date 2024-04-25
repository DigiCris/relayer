
<?php 

include_once 'requestLogsHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update status by txHash inside a row in the databse.
* \details  Defines a new status in the database of requestLogs stored in the database, which is searched by txHash.
* \param    $txHash The field of the requestLogs table that I want to use to search.
* \param    $status The value in requestLogs table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateStatusByTxHash($txHash, $status) {
    debug ('i am in updateTxHashByStatus');

    $information = new requestLogs();
    $success['response'] = $information->readTxHash($txHash);
    $success['response'] = $success['response'][0];

    if($success['response']['txHash'] == $txHash) {
        $information->set_status($status);
        $success['response'] = $information->updateStatusByTxHash($txHash);
        $success['response'] = $information->readTxHash($txHash);
        $success['response'] = $success['response'][0];
        if($success['response']['status'] == $status) {
            $success['success'] = true;
            $success['msg'] = 'Updated.';
        }else {
            $success['success'] = false;
            $success['msg'] = 'We could not update. Try again later.'; 
        }
    }
    else {
        $success['success'] = false;
        $success['msg'] = 'We could not find the txHash you are trying to update.';
    }

    return $success;
}

?>    
    