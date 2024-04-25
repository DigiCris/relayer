
<?php 

include_once 'requestLogsHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update status by id inside a row in the databse.
* \details  Defines a new status in the database of requestLogs stored in the database, which is searched by id.
* \param    $id The field of the requestLogs table that I want to use to search.
* \param    $status The value in requestLogs table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateStatusById($id, $status) {
    debug ('i am in updateIdByStatus');

    $information = new requestLogs();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_status($status);
        $success['response'] = $information->updateStatusById($id);
        $success['response'] = $information->readId($id);
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
        $success['msg'] = 'We could not find the id you are trying to update.';
    }

    return $success;
}

?>    
    