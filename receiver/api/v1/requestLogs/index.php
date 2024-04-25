
    <?php

    include_once '../configuracion.php';
    include_once '../lib.php';

    debug('I am requestLogs <br>');
    setPostWhenMissing();
    debug($_POST);

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
*    'getAll' -> Read all requestLogs
*    'getById' -> Read requestLogs by id.
*    'getByRequest' -> Read requestLogs by request.
*    'getByTxHash' -> Read requestLogs by txHash.
*    'getByStatus' -> Read requestLogs by status.
*    'getByTimestamp' -> Read requestLogs by timestamp.
*    'getByFrom' -> Read requestLogs by from.
*    'getByNonce' -> Read requestLogs by nonce.
*    'getByEmailSent' -> Read requestLogs by emailSent.
*    'getByRetry' -> Read requestLogs by retry.
* \param $get['id'] searching variable of the requestLogs table to read (in method getById).
* \param $get['request'] searching variable of the requestLogs table to read (in method getByRequest).
* \param $get['txHash'] searching variable of the requestLogs table to read (in method getByTxHash).
* \param $get['status'] searching variable of the requestLogs table to read (in method getByStatus).
* \param $get['timestamp'] searching variable of the requestLogs table to read (in method getByTimestamp).
* \param $get['from'] searching variable of the requestLogs table to read (in method getByFrom).
* \param $get['nonce'] searching variable of the requestLogs table to read (in method getByNonce).
* \param $get['emailSent'] searching variable of the requestLogs table to read (in method getByEmailSent).
* \param $get['retry'] searching variable of the requestLogs table to read (in method getByRetry).
* \return $result['response'] (array) An array with the requested information of requestLogs table.
    * ['id'] (INT)  1 unique id for each request (Special carachteristic => autoincremental ).
    * ['request'] (VARCHAR) request and signature to relay (Special carachteristic => ).
    * ['txHash'] (VARCHAR) Hash of the transaction (Special carachteristic => ).
    * ['status'] (VARCHAR) error:code / pending/ success / canceled (Special carachteristic => ).
    * ['timestamp'] (DATE) when was tx sent (Special carachteristic => ).
    * ['from'] (VARCHAR) who signed the tx (Special carachteristic => ).
    * ['nonce'] (INT) nonce to keep track of execution (Special carachteristic => ).
    * ['emailSent'] (INT) error informed or not? (Special carachteristic => ).
    * ['retry'] (INT) How many reties to send to rpc (Special carachteristic => ).
* \return $result['success'] (bool) Returns true if the request was succesful, false if not.
* \return $result['msg'] (string) Returns a message explaining the status of the execution.
*   'requestLogs fetched' -> When was able to read the fetched requestLogs.
*   'No id selected to read.' -> When id is missing (in method getById).
*   'No request selected to read.' -> When request is missing (in method getByRequest).
*   'No txHash selected to read.' -> When txHash is missing (in method getByTxHash).
*   'No status selected to read.' -> When status is missing (in method getByStatus).
*   'No timestamp selected to read.' -> When timestamp is missing (in method getByTimestamp).
*   'No from selected to read.' -> When from is missing (in method getByFrom).
*   'No nonce selected to read.' -> When nonce is missing (in method getByNonce).
*   'No emailSent selected to read.' -> When emailSent is missing (in method getByEmailSent).
*   'No retry selected to read.' -> When retry is missing (in method getByRetry).
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
            debug('<br>Escogio getById<br>');
            include_once './functions/read/getById.php';
            debug('<br>Inclui getById.php <br>');
            debug('ID = '.$get['id'].'<br>');
            if(!isset($get['id'])) {
                debug('Si hay ID no debe entrar aca <br>');
                $result['success'] = false;
                $result['msg'] = 'No id selected to read.';
                break;
            }
            debug('antes de llamar a la funcion getById()<br>');
            $result = getById($get['id']);
            debug('vuelve de la funcion getById()<br>');
            debug('getById');
            break;
            
        case 'getByRequest':
            include_once 'functions/read/getByRequest.php';
            if(!isset($get['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request selected to read.';
                break;
            }
            $result = getByRequest($get['request']);
            debug('getByRequest');
            break;
            
        case 'getByTxHash':
            include_once 'functions/read/getByTxHash.php';
            if(!isset($get['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash selected to read.';
                break;
            }
            $result = getByTxHash($get['txHash']);
            debug('getByTxHash');
            break;
            
        case 'getByStatus':
            include_once 'functions/read/getByStatus.php';
            if(!isset($get['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status selected to read.';
                break;
            }
            $result = getByStatus($get['status']);
            debug('getByStatus');
            break;
            
        case 'getByTimestamp':
            include_once 'functions/read/getByTimestamp.php';
            if(!isset($get['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp selected to read.';
                break;
            }
            $result = getByTimestamp($get['timestamp']);
            debug('getByTimestamp');
            break;
            
        case 'getByFrom':
            include_once 'functions/read/getByFrom.php';
            if(!isset($get['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from selected to read.';
                break;
            }
            $result = getByFrom($get['from']);
            debug('getByFrom');
            break;
            
        case 'getByNonce':
            include_once 'functions/read/getByNonce.php';
            if(!isset($get['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce selected to read.';
                break;
            }
            $result = getByNonce($get['nonce']);
            debug('getByNonce');
            break;
            
        case 'getByEmailSent':
            include_once 'functions/read/getByEmailSent.php';
            if(!isset($get['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent selected to read.';
                break;
            }
            $result = getByEmailSent($get['emailSent']);
            debug('getByEmailSent');
            break;
            
        case 'getByRetry':
            include_once 'functions/read/getByRetry.php';
            if(!isset($get['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry selected to read.';
                break;
            }
            $result = getByRetry($get['retry']);
            debug('getByRetry');
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
*    'setAll' -> Insert a new row in requestLogs
*    'deleteAll' -> delete all table in requestLogs
*    'deleteById' -> delete all that matches id in requestLogs
*    'deleteByRequest' -> delete all that matches request in requestLogs
*    'deleteByTxHash' -> delete all that matches txHash in requestLogs
*    'deleteByStatus' -> delete all that matches status in requestLogs
*    'deleteByTimestamp' -> delete all that matches timestamp in requestLogs
*    'deleteByFrom' -> delete all that matches from in requestLogs
*    'deleteByNonce' -> delete all that matches nonce in requestLogs
*    'deleteByEmailSent' -> delete all that matches emailSent in requestLogs
*    'deleteByRetry' -> delete all that matches retry in requestLogs
*    'updateAllById' -> Updates all that matches id in requestLogs
*    'updateAllByRequest' -> Updates all that matches request in requestLogs
*    'updateAllByTxHash' -> Updates all that matches txHash in requestLogs
*    'updateAllByStatus' -> Updates all that matches status in requestLogs
*    'updateAllByTimestamp' -> Updates all that matches timestamp in requestLogs
*    'updateAllByFrom' -> Updates all that matches from in requestLogs
*    'updateAllByNonce' -> Updates all that matches nonce in requestLogs
*    'updateAllByEmailSent' -> Updates all that matches emailSent in requestLogs
*    'updateAllByRetry' -> Updates all that matches retry in requestLogs
*    'updateRequestById' -> Updates request that matches id in requestLogs
*    'updateRequestByTxHash' -> Updates request that matches txHash in requestLogs
*    'updateRequestByStatus' -> Updates request that matches status in requestLogs
*    'updateRequestByTimestamp' -> Updates request that matches timestamp in requestLogs
*    'updateRequestByFrom' -> Updates request that matches from in requestLogs
*    'updateRequestByNonce' -> Updates request that matches nonce in requestLogs
*    'updateRequestByEmailSent' -> Updates request that matches emailSent in requestLogs
*    'updateRequestByRetry' -> Updates request that matches retry in requestLogs
*    'updateTxHashById' -> Updates txHash that matches id in requestLogs
*    'updateTxHashByRequest' -> Updates txHash that matches request in requestLogs
*    'updateTxHashByStatus' -> Updates txHash that matches status in requestLogs
*    'updateTxHashByTimestamp' -> Updates txHash that matches timestamp in requestLogs
*    'updateTxHashByFrom' -> Updates txHash that matches from in requestLogs
*    'updateTxHashByNonce' -> Updates txHash that matches nonce in requestLogs
*    'updateTxHashByEmailSent' -> Updates txHash that matches emailSent in requestLogs
*    'updateTxHashByRetry' -> Updates txHash that matches retry in requestLogs
*    'updateStatusById' -> Updates status that matches id in requestLogs
*    'updateStatusByRequest' -> Updates status that matches request in requestLogs
*    'updateStatusByTxHash' -> Updates status that matches txHash in requestLogs
*    'updateStatusByTimestamp' -> Updates status that matches timestamp in requestLogs
*    'updateStatusByFrom' -> Updates status that matches from in requestLogs
*    'updateStatusByNonce' -> Updates status that matches nonce in requestLogs
*    'updateStatusByEmailSent' -> Updates status that matches emailSent in requestLogs
*    'updateStatusByRetry' -> Updates status that matches retry in requestLogs
*    'updateTimestampById' -> Updates timestamp that matches id in requestLogs
*    'updateTimestampByRequest' -> Updates timestamp that matches request in requestLogs
*    'updateTimestampByTxHash' -> Updates timestamp that matches txHash in requestLogs
*    'updateTimestampByStatus' -> Updates timestamp that matches status in requestLogs
*    'updateTimestampByFrom' -> Updates timestamp that matches from in requestLogs
*    'updateTimestampByNonce' -> Updates timestamp that matches nonce in requestLogs
*    'updateTimestampByEmailSent' -> Updates timestamp that matches emailSent in requestLogs
*    'updateTimestampByRetry' -> Updates timestamp that matches retry in requestLogs
*    'updateFromById' -> Updates from that matches id in requestLogs
*    'updateFromByRequest' -> Updates from that matches request in requestLogs
*    'updateFromByTxHash' -> Updates from that matches txHash in requestLogs
*    'updateFromByStatus' -> Updates from that matches status in requestLogs
*    'updateFromByTimestamp' -> Updates from that matches timestamp in requestLogs
*    'updateFromByNonce' -> Updates from that matches nonce in requestLogs
*    'updateFromByEmailSent' -> Updates from that matches emailSent in requestLogs
*    'updateFromByRetry' -> Updates from that matches retry in requestLogs
*    'updateNonceById' -> Updates nonce that matches id in requestLogs
*    'updateNonceByRequest' -> Updates nonce that matches request in requestLogs
*    'updateNonceByTxHash' -> Updates nonce that matches txHash in requestLogs
*    'updateNonceByStatus' -> Updates nonce that matches status in requestLogs
*    'updateNonceByTimestamp' -> Updates nonce that matches timestamp in requestLogs
*    'updateNonceByFrom' -> Updates nonce that matches from in requestLogs
*    'updateNonceByEmailSent' -> Updates nonce that matches emailSent in requestLogs
*    'updateNonceByRetry' -> Updates nonce that matches retry in requestLogs
*    'updateEmailSentById' -> Updates emailSent that matches id in requestLogs
*    'updateEmailSentByRequest' -> Updates emailSent that matches request in requestLogs
*    'updateEmailSentByTxHash' -> Updates emailSent that matches txHash in requestLogs
*    'updateEmailSentByStatus' -> Updates emailSent that matches status in requestLogs
*    'updateEmailSentByTimestamp' -> Updates emailSent that matches timestamp in requestLogs
*    'updateEmailSentByFrom' -> Updates emailSent that matches from in requestLogs
*    'updateEmailSentByNonce' -> Updates emailSent that matches nonce in requestLogs
*    'updateEmailSentByRetry' -> Updates emailSent that matches retry in requestLogs
*    'updateRetryById' -> Updates retry that matches id in requestLogs
*    'updateRetryByRequest' -> Updates retry that matches request in requestLogs
*    'updateRetryByTxHash' -> Updates retry that matches txHash in requestLogs
*    'updateRetryByStatus' -> Updates retry that matches status in requestLogs
*    'updateRetryByTimestamp' -> Updates retry that matches timestamp in requestLogs
*    'updateRetryByFrom' -> Updates retry that matches from in requestLogs
*    'updateRetryByNonce' -> Updates retry that matches nonce in requestLogs
*    'updateRetryByEmailSent' -> Updates retry that matches emailSent in requestLogs
* \param $post['id'] (INT)  1 unique id for each request
* \param $post['request'] (VARCHAR) request and signature to relay
* \param $post['txHash'] (VARCHAR) Hash of the transaction
* \param $post['status'] (VARCHAR) error:code / pending/ success / canceled
* \param $post['timestamp'] (DATE) when was tx sent
* \param $post['from'] (VARCHAR) who signed the tx
* \param $post['nonce'] (INT) nonce to keep track of execution
* \param $post['emailSent'] (INT) error informed or not?
* \param $post['retry'] (INT) How many reties to send to rpc
* \return $result['response'] (array) An array with the requested requestLogs information.
*    ['id'] (INT)  1 unique id for each request
*    ['request'] (VARCHAR) request and signature to relay
*    ['txHash'] (VARCHAR) Hash of the transaction
*    ['status'] (VARCHAR) error:code / pending/ success / canceled
*    ['timestamp'] (DATE) when was tx sent
*    ['from'] (VARCHAR) who signed the tx
*    ['nonce'] (INT) nonce to keep track of execution
*    ['emailSent'] (INT) error informed or not?
*    ['retry'] (INT) How many reties to send to rpc
* \return $result['success'] (bool) Returns true if the request was succesful, false if not.
* \return $result['msg'] (string) Returns a message explaining the status of the execution.
*   'requestLogs uploaded.' -> When the execution was successful, the requestLogs information was uploaded in the database.
*   'This requestLogs could not be uploaded. Try again later.' -> When the call fails, it could be because it couldn't connect to the database. 
*   'This requestLogs row is already in the database.' -> When trying to insert something that already exists inside the database.
*   'Updated' -> When the updateing execution was successful, the requestLogs information was updated in the database.
*   'We couldn't update. Try again later' -> When the update fails, it could be because it couldn't connect to the database. 
*   'We couldn't find what you are trying to update.' -> When the information of requestLogs you want to update does not exist or it is not found in the database.
*   'requestLogs row deleted' -> When was able to delete the fetched requestLogs row/rows.
*   'It was not possible to erase the requestLogs. Try again later' -> When it fails to eliminate the requestLogs row/rows.
*   'ThisrequestLogs row did not exist.' -> When the requestLogs row was not found or did not exist.
*   'No id/request/txHash/status/timestamp/from/nonce/emailSent/retry/ to set.' -> When one of the required parameters is missing.
*   'No selection to delete.' -> When $post['selection'] is missing (in method deleteBySelection).
*   'No selection to update.' -> When $post['selection'] is missing (in method update...BySelection).
*   'No valid case selected' -> When a method that does not exist is selected (in the default of the switch). 
*/  
function postFunctions($post) {
    switch ($post['method']) {
        
        case 'setAll':
            debug('I am inside the post method setAll <br>');
            include_once 'functions/write/setAll.php';
            debug('ya sali de incluir el archivo con la funcion setAll() <br>');
            $result = setAll($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            debug('ya volvi de llamar a la funcion setAll <br>');
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
        
        case 'deleteByRequest':
            debug('I am inside the post method deleteByRequest <br>');
            include_once 'functions/delete/deleteByRequest.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to delete.';
                break;
            }
            $result = deleteByRequest($post['request']);
            break;
        
        case 'deleteByTxHash':
            debug('I am inside the post method deleteByTxHash <br>');
            include_once 'functions/delete/deleteByTxHash.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to delete.';
                break;
            }
            $result = deleteByTxHash($post['txHash']);
            break;
        
        case 'deleteByStatus':
            debug('I am inside the post method deleteByStatus <br>');
            include_once 'functions/delete/deleteByStatus.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to delete.';
                break;
            }
            $result = deleteByStatus($post['status']);
            break;
        
        case 'deleteByTimestamp':
            debug('I am inside the post method deleteByTimestamp <br>');
            include_once 'functions/delete/deleteByTimestamp.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to delete.';
                break;
            }
            $result = deleteByTimestamp($post['timestamp']);
            break;
        
        case 'deleteByFrom':
            debug('I am inside the post method deleteByFrom <br>');
            include_once 'functions/delete/deleteByFrom.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to delete.';
                break;
            }
            $result = deleteByFrom($post['from']);
            break;
        
        case 'deleteByNonce':
            debug('I am inside the post method deleteByNonce <br>');
            include_once 'functions/delete/deleteByNonce.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to delete.';
                break;
            }
            $result = deleteByNonce($post['nonce']);
            break;
        
        case 'deleteByEmailSent':
            debug('I am inside the post method deleteByEmailSent <br>');
            include_once 'functions/delete/deleteByEmailSent.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to delete.';
                break;
            }
            $result = deleteByEmailSent($post['emailSent']);
            break;
        
        case 'deleteByRetry':
            debug('I am inside the post method deleteByRetry <br>');
            include_once 'functions/delete/deleteByRetry.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to delete.';
                break;
            }
            $result = deleteByRetry($post['retry']);
            break;
        
        case 'updateAllById':
            debug('I am inside the post method updateAllById <br>');
            include_once 'functions/update/updateAllById.php';
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateAllById($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByRequest':
            debug('I am inside the post method updateAllByRequest <br>');
            include_once 'functions/update/updateAllByRequest.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateAllByRequest($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByTxHash':
            debug('I am inside the post method updateAllByTxHash <br>');
            include_once 'functions/update/updateAllByTxHash.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateAllByTxHash($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByStatus':
            debug('I am inside the post method updateAllByStatus <br>');
            include_once 'functions/update/updateAllByStatus.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateAllByStatus($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByTimestamp':
            debug('I am inside the post method updateAllByTimestamp <br>');
            include_once 'functions/update/updateAllByTimestamp.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateAllByTimestamp($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByFrom':
            debug('I am inside the post method updateAllByFrom <br>');
            include_once 'functions/update/updateAllByFrom.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateAllByFrom($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByNonce':
            debug('I am inside the post method updateAllByNonce <br>');
            include_once 'functions/update/updateAllByNonce.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateAllByNonce($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByEmailSent':
            debug('I am inside the post method updateAllByEmailSent <br>');
            include_once 'functions/update/updateAllByEmailSent.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateAllByEmailSent($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateAllByRetry':
            debug('I am inside the post method updateAllByRetry <br>');
            include_once 'functions/update/updateAllByRetry.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateAllByRetry($post['id'], $post['request'], $post['txHash'], $post['status'], $post['timestamp'], $post['from'], $post['nonce'], $post['emailSent'], $post['retry']);
            break;
        
        case 'updateRequestById':
            debug('I am inside the post method updateRequestById <br>');
            include_once 'functions/update/updateRequestById.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateRequestById($post['id'],$post['request']);
            break;
        
        case 'updateRequestByTxHash':
            debug('I am inside the post method updateRequestByTxHash <br>');
            include_once 'functions/update/updateRequestByTxHash.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateRequestByTxHash($post['txHash'],$post['request']);
            break;
        
        case 'updateRequestByStatus':
            debug('I am inside the post method updateRequestByStatus <br>');
            include_once 'functions/update/updateRequestByStatus.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateRequestByStatus($post['status'],$post['request']);
            break;
        
        case 'updateRequestByTimestamp':
            debug('I am inside the post method updateRequestByTimestamp <br>');
            include_once 'functions/update/updateRequestByTimestamp.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateRequestByTimestamp($post['timestamp'],$post['request']);
            break;
        
        case 'updateRequestByFrom':
            debug('I am inside the post method updateRequestByFrom <br>');
            include_once 'functions/update/updateRequestByFrom.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateRequestByFrom($post['from'],$post['request']);
            break;
        
        case 'updateRequestByNonce':
            debug('I am inside the post method updateRequestByNonce <br>');
            include_once 'functions/update/updateRequestByNonce.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateRequestByNonce($post['nonce'],$post['request']);
            break;
        
        case 'updateRequestByEmailSent':
            debug('I am inside the post method updateRequestByEmailSent <br>');
            include_once 'functions/update/updateRequestByEmailSent.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateRequestByEmailSent($post['emailSent'],$post['request']);
            break;
        
        case 'updateRequestByRetry':
            debug('I am inside the post method updateRequestByRetry <br>');
            include_once 'functions/update/updateRequestByRetry.php';
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateRequestByRetry($post['retry'],$post['request']);
            break;
        
        case 'updateTxHashById':
            debug('I am inside the post method updateTxHashById <br>');
            include_once 'functions/update/updateTxHashById.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateTxHashById($post['id'],$post['txHash']);
            break;
        
        case 'updateTxHashByRequest':
            debug('I am inside the post method updateTxHashByRequest <br>');
            include_once 'functions/update/updateTxHashByRequest.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateTxHashByRequest($post['request'],$post['txHash']);
            break;
        
        case 'updateTxHashByStatus':
            debug('I am inside the post method updateTxHashByStatus <br>');
            include_once 'functions/update/updateTxHashByStatus.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateTxHashByStatus($post['status'],$post['txHash']);
            break;
        
        case 'updateTxHashByTimestamp':
            debug('I am inside the post method updateTxHashByTimestamp <br>');
            include_once 'functions/update/updateTxHashByTimestamp.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateTxHashByTimestamp($post['timestamp'],$post['txHash']);
            break;
        
        case 'updateTxHashByFrom':
            debug('I am inside the post method updateTxHashByFrom <br>');
            include_once 'functions/update/updateTxHashByFrom.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateTxHashByFrom($post['from'],$post['txHash']);
            break;
        
        case 'updateTxHashByNonce':
            debug('I am inside the post method updateTxHashByNonce <br>');
            include_once 'functions/update/updateTxHashByNonce.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateTxHashByNonce($post['nonce'],$post['txHash']);
            break;
        
        case 'updateTxHashByEmailSent':
            debug('I am inside the post method updateTxHashByEmailSent <br>');
            include_once 'functions/update/updateTxHashByEmailSent.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateTxHashByEmailSent($post['emailSent'],$post['txHash']);
            break;
        
        case 'updateTxHashByRetry':
            debug('I am inside the post method updateTxHashByRetry <br>');
            include_once 'functions/update/updateTxHashByRetry.php';
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateTxHashByRetry($post['retry'],$post['txHash']);
            break;
        
        case 'updateStatusById':
            debug('I am inside the post method updateStatusById <br>');
            include_once 'functions/update/updateStatusById.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateStatusById($post['id'],$post['status']);
            break;
        
        case 'updateStatusByRequest':
            debug('I am inside the post method updateStatusByRequest <br>');
            include_once 'functions/update/updateStatusByRequest.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateStatusByRequest($post['request'],$post['status']);
            break;
        
        case 'updateStatusByTxHash':
            debug('I am inside the post method updateStatusByTxHash <br>');
            include_once 'functions/update/updateStatusByTxHash.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateStatusByTxHash($post['txHash'],$post['status']);
            break;
        
        case 'updateStatusByTimestamp':
            debug('I am inside the post method updateStatusByTimestamp <br>');
            include_once 'functions/update/updateStatusByTimestamp.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateStatusByTimestamp($post['timestamp'],$post['status']);
            break;
        
        case 'updateStatusByFrom':
            debug('I am inside the post method updateStatusByFrom <br>');
            include_once 'functions/update/updateStatusByFrom.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateStatusByFrom($post['from'],$post['status']);
            break;
        
        case 'updateStatusByNonce':
            debug('I am inside the post method updateStatusByNonce <br>');
            include_once 'functions/update/updateStatusByNonce.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateStatusByNonce($post['nonce'],$post['status']);
            break;
        
        case 'updateStatusByEmailSent':
            debug('I am inside the post method updateStatusByEmailSent <br>');
            include_once 'functions/update/updateStatusByEmailSent.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateStatusByEmailSent($post['emailSent'],$post['status']);
            break;
        
        case 'updateStatusByRetry':
            debug('I am inside the post method updateStatusByRetry <br>');
            include_once 'functions/update/updateStatusByRetry.php';
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateStatusByRetry($post['retry'],$post['status']);
            break;
        
        case 'updateTimestampById':
            debug('I am inside the post method updateTimestampById <br>');
            include_once 'functions/update/updateTimestampById.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateTimestampById($post['id'],$post['timestamp']);
            break;
        
        case 'updateTimestampByRequest':
            debug('I am inside the post method updateTimestampByRequest <br>');
            include_once 'functions/update/updateTimestampByRequest.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateTimestampByRequest($post['request'],$post['timestamp']);
            break;
        
        case 'updateTimestampByTxHash':
            debug('I am inside the post method updateTimestampByTxHash <br>');
            include_once 'functions/update/updateTimestampByTxHash.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateTimestampByTxHash($post['txHash'],$post['timestamp']);
            break;
        
        case 'updateTimestampByStatus':
            debug('I am inside the post method updateTimestampByStatus <br>');
            include_once 'functions/update/updateTimestampByStatus.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateTimestampByStatus($post['status'],$post['timestamp']);
            break;
        
        case 'updateTimestampByFrom':
            debug('I am inside the post method updateTimestampByFrom <br>');
            include_once 'functions/update/updateTimestampByFrom.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateTimestampByFrom($post['from'],$post['timestamp']);
            break;
        
        case 'updateTimestampByNonce':
            debug('I am inside the post method updateTimestampByNonce <br>');
            include_once 'functions/update/updateTimestampByNonce.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateTimestampByNonce($post['nonce'],$post['timestamp']);
            break;
        
        case 'updateTimestampByEmailSent':
            debug('I am inside the post method updateTimestampByEmailSent <br>');
            include_once 'functions/update/updateTimestampByEmailSent.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateTimestampByEmailSent($post['emailSent'],$post['timestamp']);
            break;
        
        case 'updateTimestampByRetry':
            debug('I am inside the post method updateTimestampByRetry <br>');
            include_once 'functions/update/updateTimestampByRetry.php';
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateTimestampByRetry($post['retry'],$post['timestamp']);
            break;
        
        case 'updateFromById':
            debug('I am inside the post method updateFromById <br>');
            include_once 'functions/update/updateFromById.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateFromById($post['id'],$post['from']);
            break;
        
        case 'updateFromByRequest':
            debug('I am inside the post method updateFromByRequest <br>');
            include_once 'functions/update/updateFromByRequest.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateFromByRequest($post['request'],$post['from']);
            break;
        
        case 'updateFromByTxHash':
            debug('I am inside the post method updateFromByTxHash <br>');
            include_once 'functions/update/updateFromByTxHash.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateFromByTxHash($post['txHash'],$post['from']);
            break;
        
        case 'updateFromByStatus':
            debug('I am inside the post method updateFromByStatus <br>');
            include_once 'functions/update/updateFromByStatus.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateFromByStatus($post['status'],$post['from']);
            break;
        
        case 'updateFromByTimestamp':
            debug('I am inside the post method updateFromByTimestamp <br>');
            include_once 'functions/update/updateFromByTimestamp.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateFromByTimestamp($post['timestamp'],$post['from']);
            break;
        
        case 'updateFromByNonce':
            debug('I am inside the post method updateFromByNonce <br>');
            include_once 'functions/update/updateFromByNonce.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateFromByNonce($post['nonce'],$post['from']);
            break;
        
        case 'updateFromByEmailSent':
            debug('I am inside the post method updateFromByEmailSent <br>');
            include_once 'functions/update/updateFromByEmailSent.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateFromByEmailSent($post['emailSent'],$post['from']);
            break;
        
        case 'updateFromByRetry':
            debug('I am inside the post method updateFromByRetry <br>');
            include_once 'functions/update/updateFromByRetry.php';
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateFromByRetry($post['retry'],$post['from']);
            break;
        
        case 'updateNonceById':
            debug('I am inside the post method updateNonceById <br>');
            include_once 'functions/update/updateNonceById.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateNonceById($post['id'],$post['nonce']);
            break;
        
        case 'updateNonceByRequest':
            debug('I am inside the post method updateNonceByRequest <br>');
            include_once 'functions/update/updateNonceByRequest.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateNonceByRequest($post['request'],$post['nonce']);
            break;
        
        case 'updateNonceByTxHash':
            debug('I am inside the post method updateNonceByTxHash <br>');
            include_once 'functions/update/updateNonceByTxHash.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateNonceByTxHash($post['txHash'],$post['nonce']);
            break;
        
        case 'updateNonceByStatus':
            debug('I am inside the post method updateNonceByStatus <br>');
            include_once 'functions/update/updateNonceByStatus.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateNonceByStatus($post['status'],$post['nonce']);
            break;
        
        case 'updateNonceByTimestamp':
            debug('I am inside the post method updateNonceByTimestamp <br>');
            include_once 'functions/update/updateNonceByTimestamp.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateNonceByTimestamp($post['timestamp'],$post['nonce']);
            break;
        
        case 'updateNonceByFrom':
            debug('I am inside the post method updateNonceByFrom <br>');
            include_once 'functions/update/updateNonceByFrom.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateNonceByFrom($post['from'],$post['nonce']);
            break;
        
        case 'updateNonceByEmailSent':
            debug('I am inside the post method updateNonceByEmailSent <br>');
            include_once 'functions/update/updateNonceByEmailSent.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateNonceByEmailSent($post['emailSent'],$post['nonce']);
            break;
        
        case 'updateNonceByRetry':
            debug('I am inside the post method updateNonceByRetry <br>');
            include_once 'functions/update/updateNonceByRetry.php';
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateNonceByRetry($post['retry'],$post['nonce']);
            break;
        
        case 'updateEmailSentById':
            debug('I am inside the post method updateEmailSentById <br>');
            include_once 'functions/update/updateEmailSentById.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateEmailSentById($post['id'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByRequest':
            debug('I am inside the post method updateEmailSentByRequest <br>');
            include_once 'functions/update/updateEmailSentByRequest.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateEmailSentByRequest($post['request'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByTxHash':
            debug('I am inside the post method updateEmailSentByTxHash <br>');
            include_once 'functions/update/updateEmailSentByTxHash.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateEmailSentByTxHash($post['txHash'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByStatus':
            debug('I am inside the post method updateEmailSentByStatus <br>');
            include_once 'functions/update/updateEmailSentByStatus.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateEmailSentByStatus($post['status'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByTimestamp':
            debug('I am inside the post method updateEmailSentByTimestamp <br>');
            include_once 'functions/update/updateEmailSentByTimestamp.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateEmailSentByTimestamp($post['timestamp'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByFrom':
            debug('I am inside the post method updateEmailSentByFrom <br>');
            include_once 'functions/update/updateEmailSentByFrom.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateEmailSentByFrom($post['from'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByNonce':
            debug('I am inside the post method updateEmailSentByNonce <br>');
            include_once 'functions/update/updateEmailSentByNonce.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateEmailSentByNonce($post['nonce'],$post['emailSent']);
            break;
        
        case 'updateEmailSentByRetry':
            debug('I am inside the post method updateEmailSentByRetry <br>');
            include_once 'functions/update/updateEmailSentByRetry.php';
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            $result = updateEmailSentByRetry($post['retry'],$post['emailSent']);
            break;
        
        case 'updateRetryById':
            debug('I am inside the post method updateRetryById <br>');
            include_once 'functions/update/updateRetryById.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['id'])) {
                $result['success'] = false;
                $result['msg'] = 'No id to update.';
                break;
            }
            $result = updateRetryById($post['id'],$post['retry']);
            break;
        
        case 'updateRetryByRequest':
            debug('I am inside the post method updateRetryByRequest <br>');
            include_once 'functions/update/updateRetryByRequest.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['request'])) {
                $result['success'] = false;
                $result['msg'] = 'No request to update.';
                break;
            }
            $result = updateRetryByRequest($post['request'],$post['retry']);
            break;
        
        case 'updateRetryByTxHash':
            debug('I am inside the post method updateRetryByTxHash <br>');
            include_once 'functions/update/updateRetryByTxHash.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['txHash'])) {
                $result['success'] = false;
                $result['msg'] = 'No txHash to update.';
                break;
            }
            $result = updateRetryByTxHash($post['txHash'],$post['retry']);
            break;
        
        case 'updateRetryByStatus':
            debug('I am inside the post method updateRetryByStatus <br>');
            include_once 'functions/update/updateRetryByStatus.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['status'])) {
                $result['success'] = false;
                $result['msg'] = 'No status to update.';
                break;
            }
            $result = updateRetryByStatus($post['status'],$post['retry']);
            break;
        
        case 'updateRetryByTimestamp':
            debug('I am inside the post method updateRetryByTimestamp <br>');
            include_once 'functions/update/updateRetryByTimestamp.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['timestamp'])) {
                $result['success'] = false;
                $result['msg'] = 'No timestamp to update.';
                break;
            }
            $result = updateRetryByTimestamp($post['timestamp'],$post['retry']);
            break;
        
        case 'updateRetryByFrom':
            debug('I am inside the post method updateRetryByFrom <br>');
            include_once 'functions/update/updateRetryByFrom.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['from'])) {
                $result['success'] = false;
                $result['msg'] = 'No from to update.';
                break;
            }
            $result = updateRetryByFrom($post['from'],$post['retry']);
            break;
        
        case 'updateRetryByNonce':
            debug('I am inside the post method updateRetryByNonce <br>');
            include_once 'functions/update/updateRetryByNonce.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['nonce'])) {
                $result['success'] = false;
                $result['msg'] = 'No nonce to update.';
                break;
            }
            $result = updateRetryByNonce($post['nonce'],$post['retry']);
            break;
        
        case 'updateRetryByEmailSent':
            debug('I am inside the post method updateRetryByEmailSent <br>');
            include_once 'functions/update/updateRetryByEmailSent.php';
            if(!isset($post['retry'])) {
                $result['success'] = false;
                $result['msg'] = 'No retry to update.';
                break;
            }
            if(!isset($post['emailSent'])) {
                $result['success'] = false;
                $result['msg'] = 'No emailSent to update.';
                break;
            }
            $result = updateRetryByEmailSent($post['emailSent'],$post['retry']);
            break;
        
        default:
            $result['success']=false;
            $result['msg']='No valid case selected';
            break;
    }
    return $result;
}

?>
    