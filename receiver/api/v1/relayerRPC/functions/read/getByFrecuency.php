
<?php

include_once 'relayerRPCHandler.php';
/*!
* \brief       Read all that matches frecuency in relayerRPC
* \details     Search in the database relayerRPC that matches frecuency and returns them in an array.
* \param       (INT) frecuency searching table by matching it.
* \return     $success['response'][N] (array) Returns the relayerRPCs, where 'N' that indicates the position of the array to which the information about each relayerRPC belongs.
     ** ['id']       (INT)    1 unique id for each rpc
     ** ['endpoint']       (VARCHAR)   url for the RPC
     ** ['calls']       (INT)   how many times we call it
     ** ['frecuency']       (INT)   frecuency of call. the higher, less frecuently called
     ** ['order']       (INT)   value to choose who's next (adding each time frecuency)
     ** ['miss']       (INT)   statistics for this endpoints
     ** ['consecutiveMiss']       (INT)   To know if it is not working properly
     ** ['dateReported']       (DATE)   last time we reported this endpoint is not working
* \return      $success['success'] (bool) Returns true if the request was succesful, false if not.
* \return      $success['msg'] (string) Returns a message explaining the status of the execution.
* * \return • 'relayerRPCs fetched.' -> When was able to read all the relayerRPCs in the database.
* * \return • 'We could not fetch the relayerRPCs.' -> When there are no relayerRPCs loaded in the database or it could not be connected to it.
*/
function getByFrecuency($frecuency) {
    $register = new relayerRPC();
    $success['response'] = $register->readFrecuency($frecuency);

    if($success['response']) {
        $success['success'] = true;
        $success['msg'] = 'relayerRPCs fetched.';
    }else {
        $success['success'] = false;
        $success['msg'] = 'We could not fetch the relayerRPCs.';
    }
    return $success;
}
    
?>
    