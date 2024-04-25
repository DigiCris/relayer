
<?php

include_once 'requestLogsHandler.php';

/*!
* \brief       Deletes all requestLogs table
* \details     Search in the database all requestLogs and delete it if it exists.
* \param       (void) No param required.
* \return    $success['response'] (bool) Returns true if the row/rows was/were deleted, false if not.
* \return    $success['success'] (bool) Returns true if the request was succesful, false if not.
* \return    $success['msg'] (string) Returns a message explaining the status of the execution.
** \return • 'requestLogs deleted.' -> When was able to delete the requestLogs row/rows.
** \return • 'It was not possible to erase the requestLogs row/rows requested. Try again later.' -> When it fails to delete the row.
** \return • 'This requestLogs did not exist.' -> When the requestLogs all was not found or did not exist. 
*/
function deleteAll() {
    $register = new requestLogs();
    $exists = $register->readAll();

    if(count($exists) > 0) {
        $success['response'] = $register->deleteAll();
        $exists = $register->readAll();
        if(count($exists) > 0) {
            $success['success'] = false;
            $success['msg'] = 'It was not possible to erase the requestLogs row/rows requested. Try again later.';
        }else {
            $success['success'] = true;
            $success['msg'] = 'requestLogs deleted.';
        }
    }else {
        $success['success'] = false;
        $success['msg'] = 'This requestLogs did not exists.';
    }
    return $success;
}
        
?>
    