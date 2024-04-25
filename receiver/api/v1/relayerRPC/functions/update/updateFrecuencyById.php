
<?php 

include_once 'relayerRPCHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update frecuency by id inside a row in the databse.
* \details  Defines a new frecuency in the database of relayerRPC stored in the database, which is searched by id.
* \param    $id The field of the relayerRPC table that I want to use to search.
* \param    $frecuency The value in relayerRPC table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateFrecuencyById($id, $frecuency) {
    debug ('i am in updateIdByFrecuency');

    $information = new relayerRPC();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_frecuency($frecuency);
        $success['response'] = $information->updateFrecuencyById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['frecuency'] == $frecuency) {
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
    