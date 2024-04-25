
<?php

include_once 'relayerRPCHandler.php';
debug('archivo setAll.php incluido <br>');
/*!
* \brief      Create a new relayerRPC row.
* \details    Insert a new relayerRPC an it's information in the database. Some fields might encrypt.
*\param      $id (INT)  1 unique id for each rpc
*\param      $endpoint (VARCHAR) url for the RPC
*\param      $calls (INT) how many times we call it
*\param      $frecuency (INT) frecuency of call. the higher, less frecuently called
*\param      $order (INT) value to choose who's next (adding each time frecuency)
*\param      $miss (INT) statistics for this endpoints
*\param      $consecutiveMiss (INT) To know if it is not working properly
*\param      $dateReported (DATE) last time we reported this endpoint is not working 
* \return $success['response'] (array) An array with the established relayerRPC fields.
** ['id'] (INT) The established id.
** ['endpoint'] (VARCHAR) The established endpoint.
** ['calls'] (INT) The established calls.
** ['frecuency'] (INT) The established frecuency.
** ['order'] (INT) The established order.
** ['miss'] (INT) The established miss.
** ['consecutiveMiss'] (INT) The established consecutiveMiss.
** ['dateReported'] (DATE) The established dateReported.
* \return $success['success'] (bool) Returns true if the new relayerRPC row was inserted, false if not.
* \return $success['msg'] (string) Returns a message explaining the status of the execution.
** \return • 'relayerRPC uploaded' -> When the execution was succesful, the new relayerRPC row was uploaded in the database.
** \return • 'This relayerRPC could not be uploaded. Try again later.' -> When the insert failed, it could be because it couldn't connect to the database.
*/
function setAll($id=null, $endpoint=null, $calls=null, $frecuency=null, $order=null, $miss=null, $consecutiveMiss=null, $dateReported=null) {
    debug('entre a la funcion setAll() <br>');
    $register = new relayerRPC();
    debug('ya cree instancia relayerRPC <br>');
    
        $register->set_id($id);
        $register->set_endpoint($endpoint);
        $register->set_calls($calls);
        $register->set_frecuency($frecuency);
        $register->set_order($order);
        $register->set_miss($miss);
        $register->set_consecutiveMiss($consecutiveMiss);
        $register->set_dateReported($dateReported);
        debug('setie todos los valores <br>');
        $success['response'] = $register->insert();
        debug('volví de insertar <br>');
        if($success['response'] == false) {
            $success['success'] = false;
            $success['msg'] = 'This relayerRPC could not be uploaded. Try again later.';
        }else {
            // I prepare the inserted data (encrypted) to show
            $data = array ( 
              'id' => $register->get_id(),
              'endpoint' => $register->get_endpoint(),
              'calls' => $register->get_calls(),
              'frecuency' => $register->get_frecuency(),
              'order' => $register->get_order(),
              'miss' => $register->get_miss(),
              'consecutiveMiss' => $register->get_consecutiveMiss(),
              'dateReported' => $register->get_dateReported()
            );
            $success['response'] = $data;
            $success['success'] = true;
            $success['msg'] = 'relayerRPC uploaded';
        }
    
    return $success;
}

?>
