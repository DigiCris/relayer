<?php

include_once 'requestLogsHandler.php';

/*!
* \brief        Update all row information.
* \details      Update the information of requestLogs table, searching it by id.
* \param      $id       (INT)    Identifier of the requestLogs to update.  1 unique id for each request
* \param      $request     (VARCHAR)  request to update. request and signature to relay
* \param      $txHash     (VARCHAR)  txHash to update. Hash of the transaction
* \param      $status     (VARCHAR)  status to update. error:code / pending/ success / canceled
* \param      $timestamp     (DATE)  timestamp to update. when was tx sent
* \param      $from     (VARCHAR)  from to update. who signed the tx
* \param      $nonce     (INT)  nonce to update. nonce to keep track of execution
* \param      $emailSent     (INT)  emailSent to update. error informed or not?
* \param      $retry     (INT)  retry to update. How many reties to send to rpc
* \return      $success['response'] (array) An array with the updated fields of the requestLogs.
     ** ['id']        (INT)   autoincremental .
     ** ['request']        (VARCHAR)   .
     ** ['txHash']        (VARCHAR)   .
     ** ['status']        (VARCHAR)   .
     ** ['timestamp']        (DATE)   .
     ** ['from']        (VARCHAR)   .
     ** ['nonce']        (INT)   .
     ** ['emailSent']        (INT)   .
     ** ['retry']        (INT)   .
* \return      $success['success'] (bool) Returns true if the requestLogs was updated, false if not.
* \return      $success['msg'] (string) Returns a message explaining the status of the execution.
    * \return •    'requestLogs updated' -> When the execution was succesful, the requestLogs has been updated.
    * \return •    'We could not update. Try again later.' -> When the update failed, it could be because it couldn't connect to the database.
    * \return •    'We could not find the id you are trying to update.' -> When the requestLogs's field id does not exist or it is not found in the database.
*/

function updateAllById($id, $request, $txHash, $status, $timestamp, $from, $nonce, $emailSent, $retry) {
    $register = new requestLogs();

    $success['response'] = $register->readId($id);

    if($success['response']['id'] == $id) {
        
        $register->set_id($id);
        $register->set_request($request);
        $register->set_txHash($txHash);
        $register->set_status($status);
        $register->set_timestamp($timestamp);
        $register->set_from($from);
        $register->set_nonce($nonce);
        $register->set_emailSent($emailSent);
        $register->set_retry($retry);

        $success['response'] = $register->updateAllById($id);
        $success['response'] = $register->readId($id);
        if($success['response']['request'] == $request and $success['response']['id'] == $id) {
            // I prepare the inserted data (encrypted) to show
            $data = array (
               'id' => $id,
               'request' => $register->get_request(),
               'txHash' => $register->get_txHash(),
               'status' => $register->get_status(),
               'timestamp' => $register->get_timestamp(),
               'from' => $register->get_from(),
               'nonce' => $register->get_nonce(),
               'emailSent' => $register->get_emailSent(),
               'retry' => $register->get_retry()
            );
            $success['response'] = $data;
            $success['success'] = true;
            $success['msg'] = 'requestLogs updated';
        }else {
            $success['success'] = false;
            $success['msg'] = 'We could not update. Try again later.';
        }
    }else {
        $success['success'] = false;
        $success['msg'] = 'We could not find the id you are trying to update.';
    }
    return $success;
}
    
?>    
    