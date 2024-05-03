
<?php 

include_once 'relayerRPCHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update consecutiveMiss by id inside a row in the databse.
* \details  Defines a new consecutiveMiss in the database of relayerRPC stored in the database, which is searched by id.
* \param    $id The field of the relayerRPC table that I want to use to search.
* \param    $consecutiveMiss The value in relayerRPC table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateConsecutiveMissById($id, $consecutiveMiss) {
    debug ('i am in updateIdByConsecutiveMiss');

    $information = new relayerRPC();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];
    $expectedConsecutiveMiss = $success['response']['consecutiveMiss'] + $consecutiveMiss; 

    if($success['response']['id'] == $id) {
        $information->set_consecutiveMiss($consecutiveMiss);
        $success['response'] = $information->updateConsecutiveMissById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['consecutiveMiss'] == $expectedConsecutiveMiss) {
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
    