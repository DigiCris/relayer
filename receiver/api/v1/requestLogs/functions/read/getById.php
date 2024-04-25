
<?php

include_once 'requestLogsHandler.php';
/*!
* \brief       Read all that matches id in requestLogs
* \details     Search in the database requestLogs that matches id and returns them in an array.
* \param       (INT) id searching table by matching it.
* \return     $success['response'][N] (array) Returns the requestLogss, where 'N' that indicates the position of the array to which the information about each requestLogs belongs.
     ** ['id']       (INT)    1 unique id for each request
     ** ['request']       (VARCHAR)   request and signature to relay
     ** ['txHash']       (VARCHAR)   Hash of the transaction
     ** ['status']       (VARCHAR)   error:code / pending/ success / canceled
     ** ['timestamp']       (DATE)   when was tx sent
     ** ['from']       (VARCHAR)   who signed the tx
     ** ['nonce']       (INT)   nonce to keep track of execution
     ** ['emailSent']       (INT)   error informed or not?
     ** ['retry']       (INT)   How many reties to send to rpc
* \return      $success['success'] (bool) Returns true if the request was succesful, false if not.
* \return      $success['msg'] (string) Returns a message explaining the status of the execution.
* * \return • 'requestLogss fetched.' -> When was able to read all the requestLogss in the database.
* * \return • 'We could not fetch the requestLogss.' -> When there are no requestLogss loaded in the database or it could not be connected to it.
*/
function getById($id) {
    debug('entre a la funcion getById()<br>');
    $register = new requestLogs();
    debug('ya volvi de crear instancia<br>');
    $success['response'] = $register->readId($id);
    debug('ya volvi de leer documento<br>');

    if($success['response']) {
        debug('hubo success<br>');
        $success['success'] = true;
        $success['msg'] = 'requestLogss fetched.';
    }else {
        debug('fue un fail<br>');
        $success['success'] = false;
        $success['msg'] = 'We could not fetch the requestLogss.';
    }
    debug('a punto de retornar<br>');
    return $success;
}
    
?>
    