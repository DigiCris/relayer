
<?php 

include_once 'requestLogsHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update retry by id inside a row in the databse.
* \details  Defines a new retry in the database of requestLogs stored in the database, which is searched by id.
* \param    $id The field of the requestLogs table that I want to use to search.
* \param    $retry The value in requestLogs table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateRetryById($id, $retry) {
    debug ('i am in updateIdByRetry');

    $information = new requestLogs();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];
    $expectedRetries = $success['response']['retry'] + $retry;

    if($success['response']['id'] == $id) {
        $information->set_retry($retry);
        $success['response'] = $information->updateRetryById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['retry'] == $expectedRetries) {
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
    