
<?php

include_once 'requestLogsHandler.php';
debug('soy archivo setAll.php <br>');
/*!
* \brief      Create a new requestLogs row.
* \details    Insert a new requestLogs an it's information in the database. Some fields might encrypt.
*\param      $id (INT)  1 unique id for each request
*\param      $request (VARCHAR) request and signature to relay
*\param      $txHash (VARCHAR) Hash of the transaction
*\param      $status (VARCHAR) error:code / pending/ success / canceled
*\param      $timestamp (DATE) when was tx sent
*\param      $from (VARCHAR) who signed the tx
*\param      $nonce (INT) nonce to keep track of execution
*\param      $emailSent (INT) error informed or not?
*\param      $retry (INT) How many reties to send to rpc 
* \return $success['response'] (array) An array with the established requestLogs fields.
** ['id'] (INT) The established id.
** ['request'] (VARCHAR) The established request.
** ['txHash'] (VARCHAR) The established txHash.
** ['status'] (VARCHAR) The established status.
** ['timestamp'] (DATE) The established timestamp.
** ['from'] (VARCHAR) The established from.
** ['nonce'] (INT) The established nonce.
** ['emailSent'] (INT) The established emailSent.
** ['retry'] (INT) The established retry.
* \return $success['success'] (bool) Returns true if the new requestLogs row was inserted, false if not.
* \return $success['msg'] (string) Returns a message explaining the status of the execution.
** \return • 'requestLogs uploaded' -> When the execution was succesful, the new requestLogs row was uploaded in the database.
** \return • 'This requestLogs could not be uploaded. Try again later.' -> When the insert failed, it could be because it couldn't connect to the database.
*/
function setAll($id=null, $request=null, $txHash=null, $status=null, $timestamp=null, $from=null, $nonce=null, $emailSent=null, $retry=null) {
    debug('entre a la funcion setAll() <br>');
    $register = new requestLogs();
    debug('sali de crear instancia requestLogs <br>');
    
        $register->set_id($id);
        $register->set_request($request);
        $register->set_txHash($txHash);
        $register->set_status($status);
        $register->set_timestamp($timestamp);
        $register->set_from($from);
        $register->set_nonce($nonce);
        $register->set_emailSent($emailSent);
        $register->set_retry($retry);
        debug('prepare todo lo que quiero setear <br>');
        $success['response'] = $register->insert();
        debug('salí dya de la función de insertar <br>');
        if($success['response'] == false) {
            debug('no pudo hacerse <br>');
            $success['success'] = false;
            $success['msg'] = 'This requestLogs could not be uploaded. Try again later.';
        }else {
            // I prepare the inserted data (encrypted) to show
            debug('voy a tomar todos los valores que fueron devueltos en las variables de la instacia <br>');
            $data = array ( 
              'id' => $register->get_id(),
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
            $success['msg'] = 'requestLogs uploaded';
        }
        debug('estoy por hacer el return <br>');
    return $success;
}

?>
