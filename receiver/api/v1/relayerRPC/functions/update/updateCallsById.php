
<?php 

include_once 'relayerRPCHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update calls by id inside a row in the databse.
* \details  Defines a new calls in the database of relayerRPC stored in the database, which is searched by id.
* \param    $id The field of the relayerRPC table that I want to use to search.
* \param    $calls The value in relayerRPC table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateCallsById($id, $calls) {
    debug ('i am in updateIdByCalls');

    $information = new relayerRPC();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_calls($calls);
        $success['response'] = $information->updateCallsById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['calls'] == $calls) {
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
    