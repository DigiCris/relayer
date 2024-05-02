<?php

    include_once '../configuracion.php';
    
/*!
 * \brief      Handler for requestLogs.
 * \details    It has every function to interact with the requestLogs in the database (Create, read, update, delete)
 * \param      $id       (INT)    1 unique id for each request
 * \param      $request       (VARCHAR)   request and signature to relay
 * \param      $txHash       (VARCHAR)   Hash of the transaction
 * \param      $status       (VARCHAR)   error:code / pending/ success / canceled
 * \param      $timestamp       (DATE)   when was tx sent
 * \param      $from       (VARCHAR)   who signed the tx
 * \param      $nonce       (INT)   nonce to keep track of execution
 * \param      $emailSent       (INT)   error informed or not?
 * \param      $retry       (INT)   How many reties to send to rpc
 */
class requestLogs
{
    
/*!
* \brief    PDO instance for the database
*/
    private $base;


    /*!
* \brief    (INT) 1 unique id for each request
*/
    private $id;

/*!
* \brief    (VARCHAR)request and signature to relay
*/
    private $request;

/*!
* \brief    (VARCHAR)Hash of the transaction
*/
    private $txHash;

/*!
* \brief    (VARCHAR)error:code / pending/ success / canceled
*/
    private $status;

/*!
* \brief    (DATE)when was tx sent
*/
    private $timestamp;

/*!
* \brief    (VARCHAR)who signed the tx
*/
    private $from;

/*!
* \brief    (INT)nonce to keep track of execution
*/
    private $nonce;

/*!
* \brief    (INT)error informed or not?
*/
    private $emailSent;

/*!
* \brief    (INT)How many reties to send to rpc
*/
    private $retry;


/*!
* \brief    Sets id for the caller instance.
* \details  The value received as a param is added to the id property of the instance of this class.
* \param $var    (INT) id I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_id($var) {
        $success=true;
        $this->id=$var;
        return $success;
    }



/*!
* \brief    Sets request for the caller instance.
* \details  The value received as a param is added to the request property of the instance of this class.
* \param $var    (VARCHAR) request I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_request($var) {
        $success=true;
        $this->request=$var;
        return $success;
    }



/*!
* \brief    Sets txHash for the caller instance.
* \details  The value received as a param is added to the txHash property of the instance of this class.
* \param $var    (VARCHAR) txHash I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_txHash($var) {
        $success=true;
        $this->txHash=$var;
        return $success;
    }



/*!
* \brief    Sets status for the caller instance.
* \details  The value received as a param is added to the status property of the instance of this class.
* \param $var    (VARCHAR) status I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_status($var) {
        $success=true;
        $this->status=$var;
        return $success;
    }



/*!
* \brief    Sets timestamp for the caller instance.
* \details  The value received as a param is added to the timestamp property of the instance of this class.
* \param $var    (DATE) timestamp I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_timestamp($var) {
        $success=true;
        $this->timestamp=$var;
        return $success;
    }



/*!
* \brief    Sets from for the caller instance.
* \details  The value received as a param is added to the from property of the instance of this class.
* \param $var    (VARCHAR) from I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_from($var) {
        $success=true;
        $this->from=$var;
        return $success;
    }



/*!
* \brief    Sets nonce for the caller instance.
* \details  The value received as a param is added to the nonce property of the instance of this class.
* \param $var    (INT) nonce I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_nonce($var) {
        $success=true;
        $this->nonce=$var;
        return $success;
    }



/*!
* \brief    Sets emailSent for the caller instance.
* \details  The value received as a param is added to the emailSent property of the instance of this class.
* \param $var    (INT) emailSent I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_emailSent($var) {
        $success=true;
        $this->emailSent=$var;
        return $success;
    }



/*!
* \brief    Sets retry for the caller instance.
* \details  The value received as a param is added to the retry property of the instance of this class.
* \param $var    (INT) retry I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_retry($var) {
        $success=true;
        $this->retry=$var;
        return $success;
    }



/*!
* \brief    Gets id for the caller instance.
* \details  The id property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->id  (INT) returns the id already set in the instance of this class.
*/
    public function get_id() {
        return($this->id);
    }



/*!
* \brief    Gets request for the caller instance.
* \details  The request property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->request  (VARCHAR) returns the request already set in the instance of this class.
*/
    public function get_request() {
        return($this->request);
    }



/*!
* \brief    Gets txHash for the caller instance.
* \details  The txHash property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->txHash  (VARCHAR) returns the txHash already set in the instance of this class.
*/
    public function get_txHash() {
        return($this->txHash);
    }



/*!
* \brief    Gets status for the caller instance.
* \details  The status property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->status  (VARCHAR) returns the status already set in the instance of this class.
*/
    public function get_status() {
        return($this->status);
    }



/*!
* \brief    Gets timestamp for the caller instance.
* \details  The timestamp property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->timestamp  (DATE) returns the timestamp already set in the instance of this class.
*/
    public function get_timestamp() {
        return($this->timestamp);
    }



/*!
* \brief    Gets from for the caller instance.
* \details  The from property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->from  (VARCHAR) returns the from already set in the instance of this class.
*/
    public function get_from() {
        return($this->from);
    }



/*!
* \brief    Gets nonce for the caller instance.
* \details  The nonce property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->nonce  (INT) returns the nonce already set in the instance of this class.
*/
    public function get_nonce() {
        return($this->nonce);
    }



/*!
* \brief    Gets emailSent for the caller instance.
* \details  The emailSent property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->emailSent  (INT) returns the emailSent already set in the instance of this class.
*/
    public function get_emailSent() {
        return($this->emailSent);
    }



/*!
* \brief    Gets retry for the caller instance.
* \details  The retry property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->retry  (INT) returns the retry already set in the instance of this class.
*/
    public function get_retry() {
        return($this->retry);
    }



/*!
* \brief    Constructor function.
* \details  Turns on the Database and connect it.
* \param    (void) non param needed.
* \return   error  (void) Nothing is return really but if there is an error a message will be printed
*/
    public function __construct() {
        try
        {
            $this->base = new PDO('mysql:host=localhost; dbname='.DBNAME,DBUSER,DBPASSWD);
            $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->base->exec('SET CHARACTER SET utf8');
        }
        catch (Exception $e) 
        {
            $success['success'] = false;
            $success['msg'] = $e->getMessage();
            echo json_encode($success);
        }
    }



/*!
* \brief    Add new data to the table.
* \details  Using PDO, htmlentities and addslashes, we insert the data contained in the instance of the callee class.
* \param    (void) non param needed.
* \return   $success  (bool) true if it has added the value, false in any other case.
*/
    public function insert() {
        //SQL query for insertion of the data saved in this instance
        debug('entre a la funcion insert<br>');
        $query = 'INSERT INTO requestLogs (id, request, txHash, `status`, `timestamp`, `from`, nonce, emailSent, retry) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $result= $this->base->prepare($query);

       $this->id =       htmlentities(addslashes($this->id));
       $this->request =       htmlentities(addslashes($this->request));
       $this->txHash =       htmlentities(addslashes($this->txHash));
       $this->status =       htmlentities(addslashes($this->status));
       $this->timestamp =       htmlentities(addslashes($this->timestamp));
       $this->from =       htmlentities(addslashes($this->from));
       $this->nonce =       htmlentities(addslashes($this->nonce));
       $this->emailSent =       htmlentities(addslashes($this->emailSent));
       $this->retry =       htmlentities(addslashes($this->retry));

        $success = $result->execute(array($this->id, $this->request, $this->txHash, $this->status, $this->timestamp, $this->from, $this->nonce, $this->emailSent, $this->retry)); 
        $this->id = $this->base->lastInsertId();
        $result ->closeCursor();
        return $success;
    
    }
    


/*!
* \brief    Update all column features by id.
* \details  Using PDO, htmlentities and addslashes, we update the data contained in the instance of the callee class.
* \param $id    identifier used to find rows to change.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateAllById($Id) {
        //SQL query for updating
        $query='update requestLogs set request=?, txHash=?, status=?, timestamp=?, `from`=?, nonce=?, emailSent=?, retry=? where id=?';
        $result= $this->base->prepare($query);

       $this->request =       htmlentities(addslashes($this->request));
       $this->txHash =       htmlentities(addslashes($this->txHash));
       $this->status =       htmlentities(addslashes($this->status));
       $this->timestamp =       htmlentities(addslashes($this->timestamp));
       $this->from =       htmlentities(addslashes($this->from));
       $this->nonce =       htmlentities(addslashes($this->nonce));
       $this->emailSent =       htmlentities(addslashes($this->emailSent));
       $this->retry =       htmlentities(addslashes($this->retry));

        $success = $result->execute(array($this->request,$this->txHash,$this->status,$this->timestamp,$this->from,$this->nonce,$this->emailSent,$this->retry, $this->id)); 

        $result ->closeCursor();
            
        // I send success to handle mistakes
        return $success;
    
    }
    


/*!
* \brief    Update all column features by txHash.
* \details  Using PDO, htmlentities and addslashes, we update the data contained in the instance of the callee class.
* \param $txHash    identifier used to find rows to change.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateAllByTxHash($TxHash) {
        //SQL query for updating
        $query='update requestLogs set id=?, request=?, status=?, timestamp=?, `from`=?, nonce=?, emailSent=?, retry=? where txHash=?';
        $result= $this->base->prepare($query);

       $this->id =       htmlentities(addslashes($this->id));
       $this->request =       htmlentities(addslashes($this->request));
       $this->txHash =       htmlentities(addslashes($this->txHash));
       $this->status =       htmlentities(addslashes($this->status));
       $this->timestamp =       htmlentities(addslashes($this->timestamp));
       $this->from =       htmlentities(addslashes($this->from));
       $this->nonce =       htmlentities(addslashes($this->nonce));
       $this->emailSent =       htmlentities(addslashes($this->emailSent));
       $this->retry =       htmlentities(addslashes($this->retry));

        $success = $result->execute(array($this->id,$this->request,$this->status,$this->timestamp,$this->from,$this->nonce,$this->emailSent,$this->retry, $this->txHash)); 

        $result ->closeCursor();
            
        // I send success to handle mistakes
        return $success;
    
    }
    


/*!
* \brief    Update txHash by id.
* \details  Using PDO, htmlentities and addslashes, we update the txHash contained in the instance of the callee class.
* \param $id    identifier of the table we want to change txHash.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateTxHashById($id) {
        //SQL query for updating
        $query='update requestLogs set txHash=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->txHash =          htmlentities(addslashes($this->txHash));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->txHash, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update status by id.
* \details  Using PDO, htmlentities and addslashes, we update the status contained in the instance of the callee class.
* \param $id    identifier of the table we want to change status.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateStatusById($id) {
        //SQL query for updating
        $query='update requestLogs set status=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->status =          htmlentities(addslashes($this->status));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->status, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update status by txHash.
* \details  Using PDO, htmlentities and addslashes, we update the status contained in the instance of the callee class.
* \param $txHash    identifier of the table we want to change status.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateStatusByTxHash($txHash) {
        //SQL query for updating
        $query='update requestLogs set status=? where txHash=?'; 

        $resultado= $this->base->prepare($query);
        $this->status =          htmlentities(addslashes($this->status));
        $this->txHash =                   htmlentities(addslashes($txHash));
        
        $success = $resultado->execute(array($this->status, $this->txHash));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update emailSent by id.
* \details  Using PDO, htmlentities and addslashes, we update the emailSent contained in the instance of the callee class.
* \param $id    identifier of the table we want to change emailSent.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateEmailSentById($id) {
        //SQL query for updating
        $query='update requestLogs set emailSent=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->emailSent =          htmlentities(addslashes($this->emailSent));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->emailSent, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update emailSent by txHash.
* \details  Using PDO, htmlentities and addslashes, we update the emailSent contained in the instance of the callee class.
* \param $txHash    identifier of the table we want to change emailSent.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateEmailSentByTxHash($txHash) {
        //SQL query for updating
        $query='update requestLogs set emailSent=? where txHash=?'; 

        $resultado= $this->base->prepare($query);
        $this->emailSent =          htmlentities(addslashes($this->emailSent));
        $this->txHash =                   htmlentities(addslashes($txHash));
        
        $success = $resultado->execute(array($this->emailSent, $this->txHash));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update retry by id.
* \details  Using PDO, htmlentities and addslashes, we update the retry contained in the instance of the callee class.
* \param $id    identifier of the table we want to change retry.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateRetryById($id) {
        //SQL query for updating
        $query='update requestLogs set retry=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->retry =          htmlentities(addslashes($this->retry));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->retry, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update retry by txHash.
* \details  Using PDO, htmlentities and addslashes, we update the retry contained in the instance of the callee class.
* \param $txHash    identifier of the table we want to change retry.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateRetryByTxHash($txHash) {
        //SQL query for updating
        $query='update requestLogs set retry=? where txHash=?'; 

        $resultado= $this->base->prepare($query);
        $this->retry =          htmlentities(addslashes($this->retry));
        $this->txHash =                   htmlentities(addslashes($txHash));
        
        $success = $resultado->execute(array($this->retry, $this->txHash));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    

    public function updateNonceById($id)
    {
        $query = 'UPDATE requestLogs SET nonce = :nonce WHERE id = :id';
        $result = $this->base->prepare($query);
        $this->id = htmlentities(addslashes($id));
        $this->nonce = htmlentities(addslashes($this->nonce));

        $result->bindValue(':nonce', $this->nonce);
        $result->bindValue(':id', $id);

        $success = $result->execute();
        $result->closeCursor();

        return $success;
    }


/*!
* \brief    Gets all the rows from the database 
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readAll() {
        $query='select * from requestLogs where 1';
        $result= $this->base->prepare($query);
        
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where id equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    id.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readId($id) {
        $query='select * from requestLogs where id=:id';
        $result= $this->base->prepare($query);
        
        $id=htmlentities(addslashes($id));
        $result->BindValue(':id',$id);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where request equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    request.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readRequest($request) {
        $query='select * from requestLogs where request=:request';
        $result= $this->base->prepare($query);
        
        $request=htmlentities(addslashes($request));
        $result->BindValue(':request',$request);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where txHash equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    txHash.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readTxHash($txHash) {
        $query='select * from requestLogs where txHash=:txHash';
        $result= $this->base->prepare($query);
        
        $txHash=htmlentities(addslashes($txHash));
        $result->BindValue(':txHash',$txHash);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where status equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    status.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readStatus($status) {
        $query='select * from requestLogs where status=:status';
        $result= $this->base->prepare($query);
        
        $status=htmlentities(addslashes($status));
        $result->BindValue(':status',$status);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where timestamp equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    timestamp.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readTimestamp($timestamp) {
        $query='select * from requestLogs where timestamp=:timestamp';
        $result= $this->base->prepare($query);
        
        $timestamp=htmlentities(addslashes($timestamp));
        $result->BindValue(':timestamp',$timestamp);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


    public function readLastNonceByFrom()
    {
        $query = 'SELECT MAX(nonce) as maxNonce FROM requestLogs WHERE `from`=:from';
        $result = $this->base->prepare($query);

        $this->from = htmlentities(addslashes($this->from));
        $result->bindValue(':from', $this->from);

        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();

        return $row['maxNonce'];
    }

/*!
* \brief    Gets all the rows from the database where from equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    from.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readFrom($from) {
        $query='select * from requestLogs where `from`=:from';
        $result= $this->base->prepare($query);
        
        $from=htmlentities(addslashes($from));
        $result->BindValue(':from',$from);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where nonce equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    nonce.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readNonce($nonce) {
        $query='select * from requestLogs where nonce=:nonce';
        $result= $this->base->prepare($query);
        
        $nonce=htmlentities(addslashes($nonce));
        $result->BindValue(':nonce',$nonce);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where emailSent equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    emailSent.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readEmailSent($emailSent) {
        $query='select * from requestLogs where emailSent=:emailSent';
        $result= $this->base->prepare($query);
        
        $emailSent=htmlentities(addslashes($emailSent));
        $result->BindValue(':emailSent',$emailSent);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where retry equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    retry.
* \return   $row  (array) all pairs of -id-request-txHash-status-timestamp-from-nonce-emailSent-retry in the database.
*/    
    public function readRetry($retry) {
        $query='select * from requestLogs where retry=:retry';
        $result= $this->base->prepare($query);
        
        $retry=htmlentities(addslashes($retry));
        $result->BindValue(':retry',$retry);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$requestLogs) {
                $requestLogs['id'] = stripslashes(html_entity_decode($requestLogs['id'])); 
                $requestLogs['request'] = stripslashes(html_entity_decode($requestLogs['request'])); 
                $requestLogs['txHash'] = stripslashes(html_entity_decode($requestLogs['txHash'])); 
                $requestLogs['status'] = stripslashes(html_entity_decode($requestLogs['status'])); 
                $requestLogs['timestamp'] = stripslashes(html_entity_decode($requestLogs['timestamp'])); 
                $requestLogs['from'] = stripslashes(html_entity_decode($requestLogs['from'])); 
                $requestLogs['nonce'] = stripslashes(html_entity_decode($requestLogs['nonce'])); 
                $requestLogs['emailSent'] = stripslashes(html_entity_decode($requestLogs['emailSent'])); 
                $requestLogs['retry'] = stripslashes(html_entity_decode($requestLogs['retry'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Deletes all rows in the database
* \details  By sql query using PDO, we delete all.
* \param all    Identifier of what we want to erase from the database.
* \return   $success  (bool) true if it has deleted the row, false in any other case.
*/
    public function deleteAll() {
        $query='delete from requestLogs where 1';
        $result= $this->base->prepare($query);
        $success = $result->execute();
        $result ->closeCursor();
        return $success;
    }



/*!
* \brief    Deletes rows in the database by id
* \details  By sql query using PDO, we delete all the results where the id matches.
* \param id    Identifier of what we want to erase from the database.
* \return   $success  (bool) true if it has deleted the row, false in any other case.
*/
    public function deleteById($id) {
        $query='delete from requestLogs where id=:id';
        $result= $this->base->prepare($query);
        $id=htmlentities(addslashes($id));
        $result->BindValue(':id',$id);

        $success = $result->execute();
        $result ->closeCursor();
        return $success;
    }



/*!
* \brief    Deletes rows in the database by txHash
* \details  By sql query using PDO, we delete all the results where the txHash matches.
* \param txHash    Identifier of what we want to erase from the database.
* \return   $success  (bool) true if it has deleted the row, false in any other case.
*/
    public function deleteByTxHash($txHash) {
        $query='delete from requestLogs where txHash=:txHash';
        $result= $this->base->prepare($query);
        $txHash=htmlentities(addslashes($txHash));
        $result->BindValue(':txHash',$txHash);

        $success = $result->execute();
        $result ->closeCursor();
        return $success;
    }



/*!
 * \brief    Login verifier.
 * \details  Send from and txHash to the database and verify if the from exists. If so, check if the txHash matches. 
 * \param    $from The from to login.
 * \param    $txHash (string) The password of the user to login.
 * \return   False (bool) Returns false if the name does not exist or password does not match.
 * \return   $row (array) Returns the row if the password matches.
*/
    public function login($from, $txHash)
    {
        $query = 'select * from requestLogs where `from`=?';
        $result = $this->base->prepare($query);
        $result->execute(array($from));
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        if ($row) {
            $verifypass = password_verify($txHash, $row[0]['txHash']);
            if ($verifypass) {
                return $row[0];
            } else {
                return false;
            }
        }
        return $row;
    } 


    
}

?>