
<?php 

include_once 'requestLogsHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update txHash by id inside a row in the databse.
* \details  Defines a new txHash in the database of requestLogs stored in the database, which is searched by id.
* \param    $id The field of the requestLogs table that I want to use to search.
* \param    $txHash The value in requestLogs table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateTxHashById($id, $txHash) {
    debug ('i am in updateIdByTxHash');

    $information = new requestLogs();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_txHash($txHash);
        $success['response'] = $information->updateTxHashById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['txHash'] == $txHash) {
            $success['success'] = true;
            $success['msg'] = 'Updated.';
        }else {
            $success['success'] = false;
            $success['msg'] = 'We could not update. Try again later.'; 
        }
    }
    else {
        $success['success'] = false;
        $success['msg'] = 'We could not find the id you are trying to update.';
    }

    return $success;
}

?>    
    