
<?php 

include_once 'relayerRPCHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update miss by id inside a row in the databse.
* \details  Defines a new miss in the database of relayerRPC stored in the database, which is searched by id.
* \param    $id The field of the relayerRPC table that I want to use to search.
* \param    $miss The value in relayerRPC table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateMissById($id, $miss) {
    debug ('i am in updateIdByMiss');

    $information = new relayerRPC();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_miss($miss);
        $success['response'] = $information->updateMissById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['miss'] == $miss) {
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
    