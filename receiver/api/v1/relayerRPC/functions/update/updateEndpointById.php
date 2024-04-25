
<?php 

include_once 'relayerRPCHandler.php';

debug ('i am updateLink.php <br>');

/*!
* \brief    Update endpoint by id inside a row in the databse.
* \details  Defines a new endpoint in the database of relayerRPC stored in the database, which is searched by id.
* \param    $id The field of the relayerRPC table that I want to use to search.
* \param    $endpoint The value in relayerRPC table that I want to update.
* \return   $success  (array) Returns an array with different success states.
*/

function updateEndpointById($id, $endpoint) {
    debug ('i am in updateIdByEndpoint');

    $information = new relayerRPC();
    $success['response'] = $information->readId($id);
    $success['response'] = $success['response'][0];

    if($success['response']['id'] == $id) {
        $information->set_endpoint($endpoint);
        $success['response'] = $information->updateEndpointById($id);
        $success['response'] = $information->readId($id);
        $success['response'] = $success['response'][0];
        if($success['response']['endpoint'] == $endpoint) {
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
    