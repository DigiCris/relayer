
<?php 

include_once 'requestLogsHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update emailSent by id inside a row in the databse.
* \details  Defines a new emailSent in the database of requestLogs stored in the database, which is searched by id.
* \param    $id The field of the requestLogs table that I want to use to search.
* \param    $emailSent The value in requestLogs table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateEmailSentById($id, $emailSent) {
    debug ('i am in updateIdByEmailSent');

    $information = new requestLogs();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_emailSent($emailSent);
        $success['response'] = $information->updateEmailSentById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['emailSent'] == $emailSent) {
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
    