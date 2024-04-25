
<?php 

include_once 'requestLogsHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update retry by txHash inside a row in the databse.
* \details  Defines a new retry in the database of requestLogs stored in the database, which is searched by txHash.
* \param    $txHash The field of the requestLogs table that I want to use to search.
* \param    $retry The value in requestLogs table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateRetryByTxHash($txHash, $retry) {
    debug ('i am in updateTxHashByRetry');

    $information = new requestLogs();
    $success['response'] = $information->readTxHash($txHash);
    $success['response'] = $success['response'][0];

    if($success['response']['txHash'] == $txHash) {
        $information->set_retry($retry);
        $success['response'] = $information->updateRetryByTxHash($txHash);
        $success['response'] = $information->readTxHash($txHash);
        $success['response'] = $success['response'][0];
        if($success['response']['retry'] == $retry) {
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
    