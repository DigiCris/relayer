<?php

include_once 'relayerRPCHandler.php';

/*!
* \brief        Update all row information.
* \details      Update the information of relayerRPC table, searching it by id.
* \param      $id       (INT)    Identifier of the relayerRPC to update.  1 unique id for each rpc
* \param      $endpoint     (VARCHAR)  endpoint to update. url for the RPC
* \param      $calls     (INT)  calls to update. how many times we call it
* \param      $frecuency     (INT)  frecuency to update. frecuency of call. the higher, less frecuently called
* \param      $order     (INT)  order to update. value to choose who's next (adding each time frecuency)
* \param      $miss     (INT)  miss to update. statistics for this endpoints
* \param      $consecutiveMiss     (INT)  consecutiveMiss to update. To know if it is not working properly
* \param      $dateReported     (DATE)  dateReported to update. last time we reported this endpoint is not working
* \return      $success['response'] (array) An array with the updated fields of the relayerRPC.
     ** ['id']        (INT)   autoincremental .
     ** ['endpoint']        (VARCHAR)   .
     ** ['calls']        (INT)   .
     ** ['frecuency']        (INT)   .
     ** ['order']        (INT)   .
     ** ['miss']        (INT)   .
     ** ['consecutiveMiss']        (INT)   .
     ** ['dateReported']        (DATE)   .
* \return      $success['success'] (bool) Returns true if the relayerRPC was updated, false if not.
* \return      $success['msg'] (string) Returns a message explaining the status of the execution.
    * \return •    'relayerRPC updated' -> When the execution was succesful, the relayerRPC has been updated.
    * \return •    'We could not update. Try again later.' -> When the update failed, it could be because it couldn't connect to the database.
    * \return •    'We could not find the id you are trying to update.' -> When the relayerRPC's field id does not exist or it is not found in the database.
*/

function updateAllById($id, $endpoint, $calls, $frecuency, $order, $miss, $consecutiveMiss, $dateReported) {
    $register = new relayerRPC();

    $success['response'] = $register->readId($id);

    if($success['response']['id'] == $id) {
        
        $register->set_id($id);
        $register->set_endpoint($endpoint);
        $register->set_calls($calls);
        $register->set_frecuency($frecuency);
        $register->set_order($order);
        $register->set_miss($miss);
        $register->set_consecutiveMiss($consecutiveMiss);
        $register->set_dateReported($dateReported);

        $success['response'] = $register->updateAllById($id);
        $success['response'] = $register->readId($id);
        if($success['response']['dateReported'] == $dateReported and $success['response']['id'] == $id) {
            // I prepare the inserted data (encrypted) to show
            $data = array (
               'id' => $id,
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
            $success['msg'] = 'relayerRPC updated';
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
    