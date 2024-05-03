
    <?php

    include_once '../configuracion.php';
    include_once '../lib.php';

    debug('I am relayerRPC <br>');
    setPostWhenMissing();

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if(!isset($_POST['method'])) {
                $result['success']=false; // I write the error directly in the result
                $result['msg']='no post method especified';
            }else {
                $result = postFunctions($_POST);
            }
            $result=json_encode($result);
            echo $result;
            break;
        
        case 'GET':
            if(!isset($_GET['method'])) {
                $result['success']=false; // I write the error directly in the result
                $result['msg']='no get method especified';
            }else {
                $result = getFunctions($_GET);
            }
            $result=json_encode($result);
            echo $result;
            break;

        default:
            $result['success']=false;
            $result['msg']='Invalid REQUEST_METHOD (GET or POST)';
            $result = json_encode($result);
            echo $result;
            break;
    }
    
/*!
* \brief    Endpoints of the get method.
* \details  It has a switch that reads the get method, which connects to the corresponding endpoint.
* \param $get['method'] (string) Specifies the method that connects to the corresponding get endpoints.
*    'getAll' -> Read all relayerRPC
*    'getById' -> Read relayerRPC by id.
*    'getByEndpoint' -> Read relayerRPC by endpoint.
*    'getByCalls' -> Read relayerRPC by calls.
*    'getByFrecuency' -> Read relayerRPC by frecuency.
*    'getByOrder' -> Read relayerRPC by order.
*    'getByMiss' -> Read relayerRPC by miss.
*    'getByConsecutiveMiss' -> Read relayerRPC by consecutiveMiss.
*    'getByDateReported' -> Read relayerRPC by dateReported.
* \param $get['id'] searching variable of the relayerRPC table to read (in method getById).
* \param $get['endpoint'] searching variable of the relayerRPC table to read (in method getByEndpoint).
* \param $get['calls'] searching variable of the relayerRPC table to read (in method getByCalls).
* \param $get['frecuency'] searching variable of the relayerRPC table to read (in method getByFrecuency).
* \param $get['order'] searching variable of the relayerRPC table to read (in method getByOrder).
* \param $get['miss'] searching variable of the relayerRPC table to read (in method getByMiss).
* \param $get['consecutiveMiss'] searching variable of the relayerRPC table to read (in method getByConsecutiveMiss).
* \param $get['dateReported'] searching variable of the relayerRPC table to read (in method getByDateReported).
* \return $result['response'] (array) An array with the requested information of relayerRPC table.
    * ['id'] (INT)  1 unique id for each rpc (Special carachteristic => autoincremental ).
    * ['endpoint'] (VARCHAR) url for the RPC (Special carachteristic => ).
    * ['calls'] (INT) how many times we call it (Special carachteristic => ).
    * ['frecuency'] (INT) frecuency of call. the higher, less frecuently called (Special carachteristic => ).
    * ['order'] (INT) value to choose who's next (adding each time frecuency) (Special carachteristic => ).
    * ['miss'] (INT) statistics for this endpoints (Special carachteristic => ).
    * ['consecutiveMiss'] (INT) To know if it is not working properly (Special carachteristic => ).
    * ['dateReported'] (DATE) last time we reported this endpoint is not working (Special carachteristic => ).
* \return $result['success'] (bool) Returns true if the request was succesful, false if not.
* \return $result['msg'] (string) Returns a message explaining the status of the execution.
*   'relayerRPC fetched' -> When was able to read the fetched relayerRPC.
*   'No id selected to read.' -> When id is missing (in method getById).
*   'No endpoint selected to read.' -> When endpoint is missing (in method getByEndpoint).
*   'No calls selected to read.' -> When calls is missing (in method getByCalls).
*   'No frecuency selected to read.' -> When frecuency is missing (in method getByFrecuency).
*   'No order selected to read.' -> When order is missing (in method getByOrder).
*   'No miss selected to read.' -> When miss is missing (in method getByMiss).
*   'No consecutiveMiss selected to read.' -> When consecutiveMiss is missing (in method getByConsecutiveMiss).
*   'No dateReported selected to read.' -> When dateReported is missing (in method getByDateReported).
*   'No valid get case selected' -> When a method that does not exist is selected (in the default of the switch). 
*/
function getFunctions($get) {
    debug($get['method']);
    switch ($get['method']) {
        
        case 'getAll':
            include_once 'functions/read/getAll.php';
            $result = getAll();
            debug('getAll');
            break;
            
        case 'getById':
            include_once 'functions/read/getById.php';
            if(!isset($get['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id selected to read.';
                break;
            }
            $result = getById($get['id']);
            debug('getById');
            break;
            
        case 'getByEndpoint':
            include_once 'functions/read/getByEndpoint.php';
            if(!isset($get['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint selected to read.';
                break;
            }
            $result = getByEndpoint($get['endpoint']);
            debug('getByEndpoint');
            break;
            
        case 'getByCalls':
            include_once 'functions/read/getByCalls.php';
            if(!isset($get['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls selected to read.';
                break;
            }
            $result = getByCalls($get['calls']);
            debug('getByCalls');
            break;
            
        case 'getByFrecuency':
            include_once 'functions/read/getByFrecuency.php';
            if(!isset($get['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency selected to read.';
                break;
            }
            $result = getByFrecuency($get['frecuency']);
            debug('getByFrecuency');
            break;
            
        case 'getByOrder':
            include_once 'functions/read/getByOrder.php';
            if(!isset($get['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order selected to read.';
                break;
            }
            $result = getByOrder($get['order']);
            debug('getByOrder');
            break;
            
        case 'getByMiss':
            include_once 'functions/read/getByMiss.php';
            if(!isset($get['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss selected to read.';
                break;
            }
            $result = getByMiss($get['miss']);
            debug('getByMiss');
            break;
            
        case 'getByConsecutiveMiss':
            include_once 'functions/read/getByConsecutiveMiss.php';
            if(!isset($get['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss selected to read.';
                break;
            }
            $result = getByConsecutiveMiss($get['consecutiveMiss']);
            debug('getByConsecutiveMiss');
            break;
            
        case 'getByDateReported':
            include_once 'functions/read/getByDateReported.php';
            if(!isset($get['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported selected to read.';
                break;
            }
            $result = getByDateReported($get['dateReported']);
            debug('getByDateReported');
            break;

        case 'getByLowerOrderVal':
            include_once "functions/read/getByLowerOrderVal.php";
            $result = getByLowerOrderVal();
            debug('getByLowerOrderVal');
            break;

        case 'getEndpointsCount':
            include_once "functions/read/getEndpointsCount.php";
            $result = getEndpointsCount();
            debug('getEndpointsCount');
            break;

        case 'getNotReportedRPCs':
            if(!isset($get['consecutiveMissQuantity'])){
                $result = ['success' => false, 'msg' => 'No consecutiveMissQuantity provided'];
                break;
            }
            if(!isset($get['notReportedTime'])){
                $result = ['success' => false, 'msg' => 'No notReportedTime provided'];
                break;
            }
            include_once "functions/read/getNotReportedRPCs.php";
            $result = getNotReportedRPCs($get['consecutiveMissQuantity'], $get['notReportedTime']);
            break;
        default:
            $result['success']=false;
            $result['msg']='No valid get case selected';
            break;
    }
    return $result;
        
}
        

/*!
* \brief    Endpoints of the post method.
* \details  It has a switch that reads the post method, which connects to the corresponding endpoint (set, delete or update).
* \param $post['method'] (string) Specifies the method that connects to the corresponding post endpoints. 
*    'setAll' -> Insert a new row in relayerRPC
*    'deleteAll' -> delete all table in relayerRPC
*    'deleteById' -> delete all that matches id in relayerRPC
*    'deleteByEndpoint' -> delete all that matches endpoint in relayerRPC
*    'deleteByCalls' -> delete all that matches calls in relayerRPC
*    'deleteByFrecuency' -> delete all that matches frecuency in relayerRPC
*    'deleteByOrder' -> delete all that matches order in relayerRPC
*    'deleteByMiss' -> delete all that matches miss in relayerRPC
*    'deleteByConsecutiveMiss' -> delete all that matches consecutiveMiss in relayerRPC
*    'deleteByDateReported' -> delete all that matches dateReported in relayerRPC
*    'updateAllById' -> Updates all that matches id in relayerRPC
*    'updateAllByEndpoint' -> Updates all that matches endpoint in relayerRPC
*    'updateAllByCalls' -> Updates all that matches calls in relayerRPC
*    'updateAllByFrecuency' -> Updates all that matches frecuency in relayerRPC
*    'updateAllByOrder' -> Updates all that matches order in relayerRPC
*    'updateAllByMiss' -> Updates all that matches miss in relayerRPC
*    'updateAllByConsecutiveMiss' -> Updates all that matches consecutiveMiss in relayerRPC
*    'updateAllByDateReported' -> Updates all that matches dateReported in relayerRPC
*    'updateEndpointById' -> Updates endpoint that matches id in relayerRPC
*    'updateEndpointByCalls' -> Updates endpoint that matches calls in relayerRPC
*    'updateEndpointByFrecuency' -> Updates endpoint that matches frecuency in relayerRPC
*    'updateEndpointByOrder' -> Updates endpoint that matches order in relayerRPC
*    'updateEndpointByMiss' -> Updates endpoint that matches miss in relayerRPC
*    'updateEndpointByConsecutiveMiss' -> Updates endpoint that matches consecutiveMiss in relayerRPC
*    'updateEndpointByDateReported' -> Updates endpoint that matches dateReported in relayerRPC
*    'updateCallsById' -> Updates calls that matches id in relayerRPC
*    'updateCallsByEndpoint' -> Updates calls that matches endpoint in relayerRPC
*    'updateCallsByFrecuency' -> Updates calls that matches frecuency in relayerRPC
*    'updateCallsByOrder' -> Updates calls that matches order in relayerRPC
*    'updateCallsByMiss' -> Updates calls that matches miss in relayerRPC
*    'updateCallsByConsecutiveMiss' -> Updates calls that matches consecutiveMiss in relayerRPC
*    'updateCallsByDateReported' -> Updates calls that matches dateReported in relayerRPC
*    'updateFrecuencyById' -> Updates frecuency that matches id in relayerRPC
*    'updateFrecuencyByEndpoint' -> Updates frecuency that matches endpoint in relayerRPC
*    'updateFrecuencyByCalls' -> Updates frecuency that matches calls in relayerRPC
*    'updateFrecuencyByOrder' -> Updates frecuency that matches order in relayerRPC
*    'updateFrecuencyByMiss' -> Updates frecuency that matches miss in relayerRPC
*    'updateFrecuencyByConsecutiveMiss' -> Updates frecuency that matches consecutiveMiss in relayerRPC
*    'updateFrecuencyByDateReported' -> Updates frecuency that matches dateReported in relayerRPC
*    'updateOrderById' -> Updates order that matches id in relayerRPC
*    'updateOrderByEndpoint' -> Updates order that matches endpoint in relayerRPC
*    'updateOrderByCalls' -> Updates order that matches calls in relayerRPC
*    'updateOrderByFrecuency' -> Updates order that matches frecuency in relayerRPC
*    'updateOrderByMiss' -> Updates order that matches miss in relayerRPC
*    'updateOrderByConsecutiveMiss' -> Updates order that matches consecutiveMiss in relayerRPC
*    'updateOrderByDateReported' -> Updates order that matches dateReported in relayerRPC
*    'updateMissById' -> Updates miss that matches id in relayerRPC
*    'updateMissByEndpoint' -> Updates miss that matches endpoint in relayerRPC
*    'updateMissByCalls' -> Updates miss that matches calls in relayerRPC
*    'updateMissByFrecuency' -> Updates miss that matches frecuency in relayerRPC
*    'updateMissByOrder' -> Updates miss that matches order in relayerRPC
*    'updateMissByConsecutiveMiss' -> Updates miss that matches consecutiveMiss in relayerRPC
*    'updateMissByDateReported' -> Updates miss that matches dateReported in relayerRPC
*    'updateConsecutiveMissById' -> Updates consecutiveMiss that matches id in relayerRPC
*    'updateConsecutiveMissByEndpoint' -> Updates consecutiveMiss that matches endpoint in relayerRPC
*    'updateConsecutiveMissByCalls' -> Updates consecutiveMiss that matches calls in relayerRPC
*    'updateConsecutiveMissByFrecuency' -> Updates consecutiveMiss that matches frecuency in relayerRPC
*    'updateConsecutiveMissByOrder' -> Updates consecutiveMiss that matches order in relayerRPC
*    'updateConsecutiveMissByMiss' -> Updates consecutiveMiss that matches miss in relayerRPC
*    'updateConsecutiveMissByDateReported' -> Updates consecutiveMiss that matches dateReported in relayerRPC
*    'updateDateReportedById' -> Updates dateReported that matches id in relayerRPC
*    'updateDateReportedByEndpoint' -> Updates dateReported that matches endpoint in relayerRPC
*    'updateDateReportedByCalls' -> Updates dateReported that matches calls in relayerRPC
*    'updateDateReportedByFrecuency' -> Updates dateReported that matches frecuency in relayerRPC
*    'updateDateReportedByOrder' -> Updates dateReported that matches order in relayerRPC
*    'updateDateReportedByMiss' -> Updates dateReported that matches miss in relayerRPC
*    'updateDateReportedByConsecutiveMiss' -> Updates dateReported that matches consecutiveMiss in relayerRPC
* \param $post['id'] (INT)  1 unique id for each rpc
* \param $post['endpoint'] (VARCHAR) url for the RPC
* \param $post['calls'] (INT) how many times we call it
* \param $post['frecuency'] (INT) frecuency of call. the higher, less frecuently called
* \param $post['order'] (INT) value to choose who's next (adding each time frecuency)
* \param $post['miss'] (INT) statistics for this endpoints
* \param $post['consecutiveMiss'] (INT) To know if it is not working properly
* \param $post['dateReported'] (DATE) last time we reported this endpoint is not working
* \return $result['response'] (array) An array with the requested relayerRPC information.
*    ['id'] (INT)  1 unique id for each rpc
*    ['endpoint'] (VARCHAR) url for the RPC
*    ['calls'] (INT) how many times we call it
*    ['frecuency'] (INT) frecuency of call. the higher, less frecuently called
*    ['order'] (INT) value to choose who's next (adding each time frecuency)
*    ['miss'] (INT) statistics for this endpoints
*    ['consecutiveMiss'] (INT) To know if it is not working properly
*    ['dateReported'] (DATE) last time we reported this endpoint is not working
* \return $result['success'] (bool) Returns true if the request was succesful, false if not.
* \return $result['msg'] (string) Returns a message explaining the status of the execution.
*   'relayerRPC uploaded.' -> When the execution was successful, the relayerRPC information was uploaded in the database.
*   'This relayerRPC could not be uploaded. Try again later.' -> When the call fails, it could be because it couldn't connect to the database. 
*   'This relayerRPC row is already in the database.' -> When trying to insert something that already exists inside the database.
*   'Updated' -> When the updateing execution was successful, the relayerRPC information was updated in the database.
*   'We couldn't update. Try again later' -> When the update fails, it could be because it couldn't connect to the database. 
*   'We couldn't find what you are trying to update.' -> When the information of relayerRPC you want to update does not exist or it is not found in the database.
*   'relayerRPC row deleted' -> When was able to delete the fetched relayerRPC row/rows.
*   'It was not possible to erase the relayerRPC. Try again later' -> When it fails to eliminate the relayerRPC row/rows.
*   'ThisrelayerRPC row did not exist.' -> When the relayerRPC row was not found or did not exist.
*   'No id/endpoint/calls/frecuency/order/miss/consecutiveMiss/dateReported/ to set.' -> When one of the required parameters is missing.
*   'No selection to delete.' -> When $post['selection'] is missing (in method deleteBySelection).
*   'No selection to update.' -> When $post['selection'] is missing (in method update...BySelection).
*   'No valid case selected' -> When a method that does not exist is selected (in the default of the switch). 
*/  
function postFunctions($post) {
    switch ($post['method']) {
        
        case 'setAll':
            debug('I am inside the post method setAll <br>');
            include_once 'functions/write/setAll.php';
            debug('Termine de incluir el archivo <br>');
            $result = setAll($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            debug('volví despues de llamar a la funcion setAll()<br>');
            break;
        
        case 'deleteAll':
            debug('I am inside the post method deleteAll <br>');
            include_once 'functions/delete/deleteAll.php';
            $result = deleteAll();
            break;
        
        case 'deleteById':
            debug('I am inside the post method deleteById <br>');
            include_once 'functions/delete/deleteById.php';
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to delete.';
                break;
            }
            $result = deleteById($post['id']);
            break;
        
        case 'deleteByEndpoint':
            debug('I am inside the post method deleteByEndpoint <br>');
            include_once 'functions/delete/deleteByEndpoint.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to delete.';
                break;
            }
            $result = deleteByEndpoint($post['endpoint']);
            break;
        
        case 'deleteByCalls':
            debug('I am inside the post method deleteByCalls <br>');
            include_once 'functions/delete/deleteByCalls.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to delete.';
                break;
            }
            $result = deleteByCalls($post['calls']);
            break;
        
        case 'deleteByFrecuency':
            debug('I am inside the post method deleteByFrecuency <br>');
            include_once 'functions/delete/deleteByFrecuency.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to delete.';
                break;
            }
            $result = deleteByFrecuency($post['frecuency']);
            break;
        
        case 'deleteByOrder':
            debug('I am inside the post method deleteByOrder <br>');
            include_once 'functions/delete/deleteByOrder.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to delete.';
                break;
            }
            $result = deleteByOrder($post['order']);
            break;
        
        case 'deleteByMiss':
            debug('I am inside the post method deleteByMiss <br>');
            include_once 'functions/delete/deleteByMiss.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to delete.';
                break;
            }
            $result = deleteByMiss($post['miss']);
            break;
        
        case 'deleteByConsecutiveMiss':
            debug('I am inside the post method deleteByConsecutiveMiss <br>');
            include_once 'functions/delete/deleteByConsecutiveMiss.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to delete.';
                break;
            }
            $result = deleteByConsecutiveMiss($post['consecutiveMiss']);
            break;
        
        case 'deleteByDateReported':
            debug('I am inside the post method deleteByDateReported <br>');
            include_once 'functions/delete/deleteByDateReported.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to delete.';
                break;
            }
            $result = deleteByDateReported($post['dateReported']);
            break;
        
        case 'updateAllById':
            debug('I am inside the post method updateAllById <br>');
            include_once 'functions/update/updateAllById.php';
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateAllById($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByEndpoint':
            debug('I am inside the post method updateAllByEndpoint <br>');
            include_once 'functions/update/updateAllByEndpoint.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateAllByEndpoint($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByCalls':
            debug('I am inside the post method updateAllByCalls <br>');
            include_once 'functions/update/updateAllByCalls.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateAllByCalls($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByFrecuency':
            debug('I am inside the post method updateAllByFrecuency <br>');
            include_once 'functions/update/updateAllByFrecuency.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateAllByFrecuency($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByOrder':
            debug('I am inside the post method updateAllByOrder <br>');
            include_once 'functions/update/updateAllByOrder.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateAllByOrder($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByMiss':
            debug('I am inside the post method updateAllByMiss <br>');
            include_once 'functions/update/updateAllByMiss.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateAllByMiss($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByConsecutiveMiss':
            debug('I am inside the post method updateAllByConsecutiveMiss <br>');
            include_once 'functions/update/updateAllByConsecutiveMiss.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateAllByConsecutiveMiss($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateAllByDateReported':
            debug('I am inside the post method updateAllByDateReported <br>');
            include_once 'functions/update/updateAllByDateReported.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateAllByDateReported($post['id'], $post['endpoint'], $post['calls'], $post['frecuency'], $post['order'], $post['miss'], $post['consecutiveMiss'], $post['dateReported']);
            break;
        
        case 'updateEndpointById':
            debug('I am inside the post method updateEndpointById <br>');
            include_once 'functions/update/updateEndpointById.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateEndpointById($post['id'],$post['endpoint']);
            break;
        
        case 'updateEndpointByCalls':
            debug('I am inside the post method updateEndpointByCalls <br>');
            include_once 'functions/update/updateEndpointByCalls.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateEndpointByCalls($post['calls'],$post['endpoint']);
            break;
        
        case 'updateEndpointByFrecuency':
            debug('I am inside the post method updateEndpointByFrecuency <br>');
            include_once 'functions/update/updateEndpointByFrecuency.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateEndpointByFrecuency($post['frecuency'],$post['endpoint']);
            break;
        
        case 'updateEndpointByOrder':
            debug('I am inside the post method updateEndpointByOrder <br>');
            include_once 'functions/update/updateEndpointByOrder.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateEndpointByOrder($post['order'],$post['endpoint']);
            break;
        
        case 'updateEndpointByMiss':
            debug('I am inside the post method updateEndpointByMiss <br>');
            include_once 'functions/update/updateEndpointByMiss.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateEndpointByMiss($post['miss'],$post['endpoint']);
            break;
        
        case 'updateEndpointByConsecutiveMiss':
            debug('I am inside the post method updateEndpointByConsecutiveMiss <br>');
            include_once 'functions/update/updateEndpointByConsecutiveMiss.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateEndpointByConsecutiveMiss($post['consecutiveMiss'],$post['endpoint']);
            break;
        
        case 'updateEndpointByDateReported':
            debug('I am inside the post method updateEndpointByDateReported <br>');
            include_once 'functions/update/updateEndpointByDateReported.php';
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateEndpointByDateReported($post['dateReported'],$post['endpoint']);
            break;
        
        case 'updateCallsById':
            debug('I am inside the post method updateCallsById <br>');
            include_once 'functions/update/updateCallsById.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateCallsById($post['id'],$post['calls']);
            break;
        
        case 'updateCallsByEndpoint':
            debug('I am inside the post method updateCallsByEndpoint <br>');
            include_once 'functions/update/updateCallsByEndpoint.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateCallsByEndpoint($post['endpoint'],$post['calls']);
            break;
        
        case 'updateCallsByFrecuency':
            debug('I am inside the post method updateCallsByFrecuency <br>');
            include_once 'functions/update/updateCallsByFrecuency.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateCallsByFrecuency($post['frecuency'],$post['calls']);
            break;
        
        case 'updateCallsByOrder':
            debug('I am inside the post method updateCallsByOrder <br>');
            include_once 'functions/update/updateCallsByOrder.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateCallsByOrder($post['order'],$post['calls']);
            break;
        
        case 'updateCallsByMiss':
            debug('I am inside the post method updateCallsByMiss <br>');
            include_once 'functions/update/updateCallsByMiss.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateCallsByMiss($post['miss'],$post['calls']);
            break;
        
        case 'updateCallsByConsecutiveMiss':
            debug('I am inside the post method updateCallsByConsecutiveMiss <br>');
            include_once 'functions/update/updateCallsByConsecutiveMiss.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateCallsByConsecutiveMiss($post['consecutiveMiss'],$post['calls']);
            break;
        
        case 'updateCallsByDateReported':
            debug('I am inside the post method updateCallsByDateReported <br>');
            include_once 'functions/update/updateCallsByDateReported.php';
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateCallsByDateReported($post['dateReported'],$post['calls']);
            break;
        
        case 'updateFrecuencyById':
            debug('I am inside the post method updateFrecuencyById <br>');
            include_once 'functions/update/updateFrecuencyById.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateFrecuencyById($post['id'],$post['frecuency']);
            break;
        
        case 'updateFrecuencyByEndpoint':
            debug('I am inside the post method updateFrecuencyByEndpoint <br>');
            include_once 'functions/update/updateFrecuencyByEndpoint.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateFrecuencyByEndpoint($post['endpoint'],$post['frecuency']);
            break;
        
        case 'updateFrecuencyByCalls':
            debug('I am inside the post method updateFrecuencyByCalls <br>');
            include_once 'functions/update/updateFrecuencyByCalls.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateFrecuencyByCalls($post['calls'],$post['frecuency']);
            break;
        
        case 'updateFrecuencyByOrder':
            debug('I am inside the post method updateFrecuencyByOrder <br>');
            include_once 'functions/update/updateFrecuencyByOrder.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateFrecuencyByOrder($post['order'],$post['frecuency']);
            break;
        
        case 'updateFrecuencyByMiss':
            debug('I am inside the post method updateFrecuencyByMiss <br>');
            include_once 'functions/update/updateFrecuencyByMiss.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateFrecuencyByMiss($post['miss'],$post['frecuency']);
            break;
        
        case 'updateFrecuencyByConsecutiveMiss':
            debug('I am inside the post method updateFrecuencyByConsecutiveMiss <br>');
            include_once 'functions/update/updateFrecuencyByConsecutiveMiss.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateFrecuencyByConsecutiveMiss($post['consecutiveMiss'],$post['frecuency']);
            break;
        
        case 'updateFrecuencyByDateReported':
            debug('I am inside the post method updateFrecuencyByDateReported <br>');
            include_once 'functions/update/updateFrecuencyByDateReported.php';
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateFrecuencyByDateReported($post['dateReported'],$post['frecuency']);
            break;
        
        case 'updateOrderById':
            debug('I am inside the post method updateOrderById <br>');
            include_once 'functions/update/updateOrderById.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateOrderById($post['id'],$post['order']);
            break;
        
        case 'updateOrderByEndpoint':
            debug('I am inside the post method updateOrderByEndpoint <br>');
            include_once 'functions/update/updateOrderByEndpoint.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateOrderByEndpoint($post['endpoint'],$post['order']);
            break;
        
        case 'updateOrderByCalls':
            debug('I am inside the post method updateOrderByCalls <br>');
            include_once 'functions/update/updateOrderByCalls.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateOrderByCalls($post['calls'],$post['order']);
            break;
        
        case 'updateOrderByFrecuency':
            debug('I am inside the post method updateOrderByFrecuency <br>');
            include_once 'functions/update/updateOrderByFrecuency.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateOrderByFrecuency($post['frecuency'],$post['order']);
            break;
        
        case 'updateOrderByMiss':
            debug('I am inside the post method updateOrderByMiss <br>');
            include_once 'functions/update/updateOrderByMiss.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateOrderByMiss($post['miss'],$post['order']);
            break;
        
        case 'updateOrderByConsecutiveMiss':
            debug('I am inside the post method updateOrderByConsecutiveMiss <br>');
            include_once 'functions/update/updateOrderByConsecutiveMiss.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateOrderByConsecutiveMiss($post['consecutiveMiss'],$post['order']);
            break;
        
        case 'updateOrderByDateReported':
            debug('I am inside the post method updateOrderByDateReported <br>');
            include_once 'functions/update/updateOrderByDateReported.php';
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateOrderByDateReported($post['dateReported'],$post['order']);
            break;
        
        case 'updateMissById':
            debug('I am inside the post method updateMissById <br>');
            include_once 'functions/update/updateMissById.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateMissById($post['id'],$post['miss']);
            break;
        
        case 'updateMissByEndpoint':
            debug('I am inside the post method updateMissByEndpoint <br>');
            include_once 'functions/update/updateMissByEndpoint.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateMissByEndpoint($post['endpoint'],$post['miss']);
            break;
        
        case 'updateMissByCalls':
            debug('I am inside the post method updateMissByCalls <br>');
            include_once 'functions/update/updateMissByCalls.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateMissByCalls($post['calls'],$post['miss']);
            break;
        
        case 'updateMissByFrecuency':
            debug('I am inside the post method updateMissByFrecuency <br>');
            include_once 'functions/update/updateMissByFrecuency.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateMissByFrecuency($post['frecuency'],$post['miss']);
            break;
        
        case 'updateMissByOrder':
            debug('I am inside the post method updateMissByOrder <br>');
            include_once 'functions/update/updateMissByOrder.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateMissByOrder($post['order'],$post['miss']);
            break;
        
        case 'updateMissByConsecutiveMiss':
            debug('I am inside the post method updateMissByConsecutiveMiss <br>');
            include_once 'functions/update/updateMissByConsecutiveMiss.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateMissByConsecutiveMiss($post['consecutiveMiss'],$post['miss']);
            break;
        
        case 'updateMissByDateReported':
            debug('I am inside the post method updateMissByDateReported <br>');
            include_once 'functions/update/updateMissByDateReported.php';
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateMissByDateReported($post['dateReported'],$post['miss']);
            break;
        
        case 'updateConsecutiveMissById':
            debug('I am inside the post method updateConsecutiveMissById <br>');
            include_once 'functions/update/updateConsecutiveMissById.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateConsecutiveMissById($post['id'],$post['consecutiveMiss']);
            break;
        
        case 'updateConsecutiveMissByEndpoint':
            debug('I am inside the post method updateConsecutiveMissByEndpoint <br>');
            include_once 'functions/update/updateConsecutiveMissByEndpoint.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateConsecutiveMissByEndpoint($post['endpoint'],$post['consecutiveMiss']);
            break;
        
        case 'updateConsecutiveMissByCalls':
            debug('I am inside the post method updateConsecutiveMissByCalls <br>');
            include_once 'functions/update/updateConsecutiveMissByCalls.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateConsecutiveMissByCalls($post['calls'],$post['consecutiveMiss']);
            break;
        
        case 'updateConsecutiveMissByFrecuency':
            debug('I am inside the post method updateConsecutiveMissByFrecuency <br>');
            include_once 'functions/update/updateConsecutiveMissByFrecuency.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateConsecutiveMissByFrecuency($post['frecuency'],$post['consecutiveMiss']);
            break;
        
        case 'updateConsecutiveMissByOrder':
            debug('I am inside the post method updateConsecutiveMissByOrder <br>');
            include_once 'functions/update/updateConsecutiveMissByOrder.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateConsecutiveMissByOrder($post['order'],$post['consecutiveMiss']);
            break;
        
        case 'updateConsecutiveMissByMiss':
            debug('I am inside the post method updateConsecutiveMissByMiss <br>');
            include_once 'functions/update/updateConsecutiveMissByMiss.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateConsecutiveMissByMiss($post['miss'],$post['consecutiveMiss']);
            break;
        
        case 'updateConsecutiveMissByDateReported':
            debug('I am inside the post method updateConsecutiveMissByDateReported <br>');
            include_once 'functions/update/updateConsecutiveMissByDateReported.php';
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            $result = updateConsecutiveMissByDateReported($post['dateReported'],$post['consecutiveMiss']);
            break;
        
        case 'updateDateReportedById':
            debug('I am inside the post method updateDateReportedById <br>');
            include_once 'functions/update/updateDateReportedById.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateDateReportedById($post['id'],$post['dateReported']);
            break;
        
        case 'updateDateReportedByEndpoint':
            debug('I am inside the post method updateDateReportedByEndpoint <br>');
            include_once 'functions/update/updateDateReportedByEndpoint.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['endpoint'])) {
                $result['success'] = false;
                $result['msg'] = 'No endpoint to update.';
                break;
            }
            $result = updateDateReportedByEndpoint($post['endpoint'],$post['dateReported']);
            break;
        
        case 'updateDateReportedByCalls':
            debug('I am inside the post method updateDateReportedByCalls <br>');
            include_once 'functions/update/updateDateReportedByCalls.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['calls'])) {
                $result['success'] = false;
                $result['msg'] = 'No calls to update.';
                break;
            }
            $result = updateDateReportedByCalls($post['calls'],$post['dateReported']);
            break;
        
        case 'updateDateReportedByFrecuency':
            debug('I am inside the post method updateDateReportedByFrecuency <br>');
            include_once 'functions/update/updateDateReportedByFrecuency.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['frecuency'])) {
                $result['success'] = false;
                $result['msg'] = 'No frecuency to update.';
                break;
            }
            $result = updateDateReportedByFrecuency($post['frecuency'],$post['dateReported']);
            break;
        
        case 'updateDateReportedByOrder':
            debug('I am inside the post method updateDateReportedByOrder <br>');
            include_once 'functions/update/updateDateReportedByOrder.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['order'])) {
                $result['success'] = false;
                $result['msg'] = 'No order to update.';
                break;
            }
            $result = updateDateReportedByOrder($post['order'],$post['dateReported']);
            break;
        
        case 'updateDateReportedByMiss':
            debug('I am inside the post method updateDateReportedByMiss <br>');
            include_once 'functions/update/updateDateReportedByMiss.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['miss'])) {
                $result['success'] = false;
                $result['msg'] = 'No miss to update.';
                break;
            }
            $result = updateDateReportedByMiss($post['miss'],$post['dateReported']);
            break;
        
        case 'updateDateReportedByConsecutiveMiss':
            debug('I am inside the post method updateDateReportedByConsecutiveMiss <br>');
            include_once 'functions/update/updateDateReportedByConsecutiveMiss.php';
            if(!isset($post['dateReported'])) {
                $result['success'] = false;
                $result['msg'] = 'No dateReported to update.';
                break;
            }
            if(!isset($post['consecutiveMiss'])) {
                $result['success'] = false;
                $result['msg'] = 'No consecutiveMiss to update.';
                break;
            }
            $result = updateDateReportedByConsecutiveMiss($post['consecutiveMiss'],$post['dateReported']);
            break;

        case 'resetConsecutiveMissById':
            if(!isset($post['id'])){
                $result = [
                    'success' => false,
                    'msg' => 'No id provided'
                ];
                break;
            }
            include_once "functions/update/resetConsecutiveMiss.php";
            $result = resetConsecutiveMiss($post['id']);
            break;

        case 'updateDateReportedForNotWorkingRPCs':
            if(!isset($post['consecutiveMissQuantity'])){
                $result = ['success' => false, 'msg' => 'No consecutiveMissQuantity provided'];
                break;
            }
            if(!isset($post['notReportedTime'])){
                $result = ['success' => false, 'msg' => 'No notReportedTime provided'];
                break;
            }

            include_once "functions/update/updateDateReportedForNotWorkingRPCs.php";
            $result = updateDateReportedForNotWorkingRPCs($post['consecutiveMissQuantity'], $post['notReportedTime']);
            break;
        
        default:
            $result['success']=false;
            $result['msg']='No valid case selected';
            break;
    }
    return $result;
}

?>
    