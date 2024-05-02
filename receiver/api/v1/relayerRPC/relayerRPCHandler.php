<?php

    include_once '../configuracion.php';
    
/*!
 * \brief      Handler for relayerRPC.
 * \details    It has every function to interact with the relayerRPC in the database (Create, read, update, delete)
 * \param      $id       (INT)    1 unique id for each rpc
 * \param      $endpoint       (VARCHAR)   url for the RPC
 * \param      $calls       (INT)   how many times we call it
 * \param      $frecuency       (INT)   frecuency of call. the higher, less frecuently called
 * \param      $orderVal       (INT)   value to choose who's next (adding each time frecuency)
 * \param      $miss       (INT)   statistics for this endpoints
 * \param      $consecutiveMiss       (INT)   To know if it is not working properly
 * \param      $dateReported       (DATE)   last time we reported this endpoint is not working
 */
class relayerRPC
{
    
/*!
* \brief    PDO instance for the database
*/
    private $base;


    /*!
* \brief    (INT) 1 unique id for each rpc
*/
    private $id;

/*!
* \brief    (VARCHAR)url for the RPC
*/
    private $endpoint;

/*!
* \brief    (INT)how many times we call it
*/
    private $calls;

/*!
* \brief    (INT)frecuency of call. the higher, less frecuently called
*/
    private $frecuency;

/*!
* \brief    (INT)value to choose who's next (adding each time frecuency)
*/
    private $orderVal;

/*!
* \brief    (INT)statistics for this endpoints
*/
    private $miss;

/*!
* \brief    (INT)To know if it is not working properly
*/
    private $consecutiveMiss;

/*!
* \brief    (DATE)last time we reported this endpoint is not working
*/
    private $dateReported;


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
* \brief    Sets endpoint for the caller instance.
* \details  The value received as a param is added to the endpoint property of the instance of this class.
* \param $var    (VARCHAR) endpoint I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_endpoint($var) {
        $success=true;
        $this->endpoint=$var;
        return $success;
    }



/*!
* \brief    Sets calls for the caller instance.
* \details  The value received as a param is added to the calls property of the instance of this class.
* \param $var    (INT) calls I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_calls($var) {
        $success=true;
        $this->calls=$var;
        return $success;
    }



/*!
* \brief    Sets frecuency for the caller instance.
* \details  The value received as a param is added to the frecuency property of the instance of this class.
* \param $var    (INT) frecuency I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_frecuency($var) {
        $success=true;
        $this->frecuency=$var;
        return $success;
    }



/*!
* \brief    Sets orderVal for the caller instance.
* \details  The value received as a param is added to the orderVal property of the instance of this class.
* \param $var    (INT) orderVal I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_order($var) {
        $success=true;
        $this->orderVal=$var;
        return $success;
    }



/*!
* \brief    Sets miss for the caller instance.
* \details  The value received as a param is added to the miss property of the instance of this class.
* \param $var    (INT) miss I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_miss($var) {
        $success=true;
        $this->miss=$var;
        return $success;
    }



/*!
* \brief    Sets consecutiveMiss for the caller instance.
* \details  The value received as a param is added to the consecutiveMiss property of the instance of this class.
* \param $var    (INT) consecutiveMiss I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_consecutiveMiss($var) {
        $success=true;
        $this->consecutiveMiss=$var;
        return $success;
    }



/*!
* \brief    Sets dateReported for the caller instance.
* \details  The value received as a param is added to the dateReported property of the instance of this class.
* \param $var    (DATE) dateReported I want to set.
* \return   $success  (bool) returns true if this function is executed and false/undefined if it's not.
*/
    public function set_dateReported($var) {
        $success=true;
        $this->dateReported=$var;
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
* \brief    Gets endpoint for the caller instance.
* \details  The endpoint property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->endpoint  (VARCHAR) returns the endpoint already set in the instance of this class.
*/
    public function get_endpoint() {
        return($this->endpoint);
    }



/*!
* \brief    Gets calls for the caller instance.
* \details  The calls property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->calls  (INT) returns the calls already set in the instance of this class.
*/
    public function get_calls() {
        return($this->calls);
    }



/*!
* \brief    Gets frecuency for the caller instance.
* \details  The frecuency property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->frecuency  (INT) returns the frecuency already set in the instance of this class.
*/
    public function get_frecuency() {
        return($this->frecuency);
    }



/*!
* \brief    Gets orderVal for the caller instance.
* \details  The orderVal property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->orderVal  (INT) returns the orderVal already set in the instance of this class.
*/
    public function get_order() {
        return($this->orderVal);
    }



/*!
* \brief    Gets miss for the caller instance.
* \details  The miss property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->miss  (INT) returns the miss already set in the instance of this class.
*/
    public function get_miss() {
        return($this->miss);
    }



/*!
* \brief    Gets consecutiveMiss for the caller instance.
* \details  The consecutiveMiss property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->consecutiveMiss  (INT) returns the consecutiveMiss already set in the instance of this class.
*/
    public function get_consecutiveMiss() {
        return($this->consecutiveMiss);
    }



/*!
* \brief    Gets dateReported for the caller instance.
* \details  The dateReported property of the instance in this class is returned.
* \param    (void) none param needed.
* \return   $this->dateReported  (DATE) returns the dateReported already set in the instance of this class.
*/
    public function get_dateReported() {
        return($this->dateReported);
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
        $query='insert into relayerRPC (id,endpoint,calls,frecuency,orderVal,miss,consecutiveMiss,dateReported) values (?,?,?,?,?,?,?,?)';
        debug('$query armada<br>');
        $result= $this->base->prepare($query);
        debug('prepare query<br>');
        
       $this->id =       htmlentities(addslashes($this->id));
       $this->endpoint =       htmlentities(addslashes($this->endpoint));
       $this->calls =       htmlentities(addslashes($this->calls));
       $this->frecuency =       htmlentities(addslashes($this->frecuency));
       $this->orderVal =       htmlentities(addslashes($this->orderVal));
       $this->miss =       htmlentities(addslashes($this->miss));
       $this->consecutiveMiss =       htmlentities(addslashes($this->consecutiveMiss));
       $this->dateReported =       htmlentities(addslashes($this->dateReported));

       debug('setie todos los valores de clase<br>');

        $success = $result->execute(array($this->id,$this->endpoint,$this->calls,$this->frecuency,$this->orderVal,$this->miss,$this->consecutiveMiss,$this->dateReported)); 
        debug('termine de ejecutar<br>');
        $result ->closeCursor();
        $this->id = $this->base->lastInsertId();
        debug('tome el id del ultimo elemento insertado<br>');
        $result ->closeCursor();
        debug('antes de volver de insert()<br>');
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
        $query='update relayerRPC set endpoint=?, calls=?, frecuency=?, orderVal=?, miss=?, consecutiveMiss=?, dateReported=? where id=?';
        $result= $this->base->prepare($query);

       $this->endpoint =       htmlentities(addslashes($this->endpoint));
       $this->calls =       htmlentities(addslashes($this->calls));
       $this->frecuency =       htmlentities(addslashes($this->frecuency));
       $this->orderVal =       htmlentities(addslashes($this->orderVal));
       $this->miss =       htmlentities(addslashes($this->miss));
       $this->consecutiveMiss =       htmlentities(addslashes($this->consecutiveMiss));
       $this->dateReported =       htmlentities(addslashes($this->dateReported));

        $success = $result->execute(array($this->endpoint,$this->calls,$this->frecuency,$this->orderVal,$this->miss,$this->consecutiveMiss,$this->dateReported, $this->id)); 

        $result ->closeCursor();
            
        // I send success to handle mistakes
        return $success;
    
    }
    


/*!
* \brief    Update endpoint by id.
* \details  Using PDO, htmlentities and addslashes, we update the endpoint contained in the instance of the callee class.
* \param $id    identifier of the table we want to change endpoint.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateEndpointById($id) {
        //SQL query for updating
        $query='update relayerRPC set endpoint=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->endpoint =          htmlentities(addslashes($this->endpoint));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->endpoint, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update calls by id.
* \details  Using PDO, htmlentities and addslashes, we update the calls contained in the instance of the callee class.
* \param $id    identifier of the table we want to change calls.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateCallsById($id) {
        //SQL query for updating
        $query='update relayerRPC set calls= calls + ? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->calls =          htmlentities(addslashes($this->calls));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->calls, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update frecuency by id.
* \details  Using PDO, htmlentities and addslashes, we update the frecuency contained in the instance of the callee class.
* \param $id    identifier of the table we want to change frecuency.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateFrecuencyById($id) {
        //SQL query for updating
        $query='update relayerRPC set frecuency=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->frecuency =          htmlentities(addslashes($this->frecuency));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->frecuency, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update orderVal by id.
* \details  Using PDO, htmlentities and addslashes, we update the orderVal contained in the instance of the callee class.
* \param $id    identifier of the table we want to change orderVal.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateOrderById($id) {
        //SQL query for updating
        $query='update relayerRPC set orderVal=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->orderVal =          htmlentities(addslashes($this->orderVal));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->orderVal, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update miss by id.
* \details  Using PDO, htmlentities and addslashes, we update the miss contained in the instance of the callee class.
* \param $id    identifier of the table we want to change miss.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateMissById($id) {
        //SQL query for updating
        $query='update relayerRPC set miss= miss + ? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->miss =          htmlentities(addslashes($this->miss));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->miss, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update consecutiveMiss by id.
* \details  Using PDO, htmlentities and addslashes, we update the consecutiveMiss contained in the instance of the callee class.
* \param $id    identifier of the table we want to change consecutiveMiss.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateConsecutiveMissById($id) {
        //SQL query for updating
        $query='update relayerRPC set consecutiveMiss=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->consecutiveMiss =          htmlentities(addslashes($this->consecutiveMiss));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->consecutiveMiss, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Update dateReported by id.
* \details  Using PDO, htmlentities and addslashes, we update the dateReported contained in the instance of the callee class.
* \param $id    identifier of the table we want to change dateReported.
* \return   $success  (bool) true if it has updated the value, false in any other case.
*/
    public function updateDateReportedById($id) {
        //SQL query for updating
        $query='update relayerRPC set dateReported=? where id=?'; 

        $resultado= $this->base->prepare($query);
        $this->dateReported =          htmlentities(addslashes($this->dateReported));
        $this->id =                   htmlentities(addslashes($id));
        
        $success = $resultado->execute(array($this->dateReported, $this->id));
        $resultado ->closeCursor();

        // I send success to handle mistakes
        return $success;
    }
    


/*!
* \brief    Gets all the rows from the database 
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readAll() {
        $query='select * from relayerRPC where 1';
        $result= $this->base->prepare($query);
        
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where id equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    id.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readId($id) {
        $query='select * from relayerRPC where id=:id';
        $result= $this->base->prepare($query);
        
        $id=htmlentities(addslashes($id));
        $result->BindValue(':id',$id);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where endpoint equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    endpoint.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readEndpoint($endpoint) {
        $query='select * from relayerRPC where endpoint=:endpoint';
        $result= $this->base->prepare($query);
        
        $endpoint=htmlentities(addslashes($endpoint));
        $result->BindValue(':endpoint',$endpoint);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where calls equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    calls.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readCalls($calls) {
        $query='select * from relayerRPC where calls=:calls';
        $result= $this->base->prepare($query);
        
        $calls=htmlentities(addslashes($calls));
        $result->BindValue(':calls',$calls);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where frecuency equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    frecuency.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readFrecuency($frecuency) {
        $query='select * from relayerRPC where frecuency=:frecuency';
        $result= $this->base->prepare($query);
        
        $frecuency=htmlentities(addslashes($frecuency));
        $result->BindValue(':frecuency',$frecuency);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where orderVal equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    orderVal.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readOrder($orderVal) {
        $query='select * from relayerRPC where orderVal=:orderVal';
        $result= $this->base->prepare($query);
        
        $orderVal=htmlentities(addslashes($orderVal));
        $result->BindValue(':orderVal',$orderVal);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where miss equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    miss.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readMiss($miss) {
        $query='select * from relayerRPC where miss=:miss';
        $result= $this->base->prepare($query);
        
        $miss=htmlentities(addslashes($miss));
        $result->BindValue(':miss',$miss);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where consecutiveMiss equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    consecutiveMiss.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readConsecutiveMiss($consecutiveMiss) {
        $query='select * from relayerRPC where consecutiveMiss=:consecutiveMiss';
        $result= $this->base->prepare($query);
        
        $consecutiveMiss=htmlentities(addslashes($consecutiveMiss));
        $result->BindValue(':consecutiveMiss',$consecutiveMiss);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }


/*!
* \brief    Gets all the rows from the database where dateReported equals the param sent
* \details  By sql query using PDO, we get all the results of the database and send them as an array.
* \param    dateReported.
* \return   $row  (array) all pairs of -id-endpoint-calls-frecuency-orderVal-miss-consecutiveMiss-dateReported in the database.
*/    
    public function readDateReported($dateReported) {
        $query='select * from relayerRPC where dateReported=:dateReported';
        $result= $this->base->prepare($query);
        
        $dateReported=htmlentities(addslashes($dateReported));
        $result->BindValue(':dateReported',$dateReported);
            
        $result->execute();
        $row=$result->fetchAll(PDO::FETCH_ASSOC);
        $result ->closeCursor();
        if(!empty($row)) {
            foreach($row as $news => &$relayerRPC) {
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }

        return $row;
    }

    // TODO: Documentar
    // Lee el RPC con el menor orderval
    public function readByLowerOrderVal()
    {
        $query = 'SELECT * FROM relayerRPC ORDER BY orderVal ASC LIMIT 1';
        $result = $this->base->prepare($query);
        $result->execute();
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        if(!empty($row)){
            foreach($row as $items => &$relayerRPC){
                $relayerRPC['id'] = stripslashes(html_entity_decode($relayerRPC['id'])); 
                $relayerRPC['endpoint'] = stripslashes(html_entity_decode($relayerRPC['endpoint'])); 
                $relayerRPC['calls'] = stripslashes(html_entity_decode($relayerRPC['calls'])); 
                $relayerRPC['frecuency'] = stripslashes(html_entity_decode($relayerRPC['frecuency'])); 
                $relayerRPC['orderVal'] = stripslashes(html_entity_decode($relayerRPC['orderVal'])); 
                $relayerRPC['miss'] = stripslashes(html_entity_decode($relayerRPC['miss'])); 
                $relayerRPC['consecutiveMiss'] = stripslashes(html_entity_decode($relayerRPC['consecutiveMiss'])); 
                $relayerRPC['dateReported'] = stripslashes(html_entity_decode($relayerRPC['dateReported'])); 
            }
        }
        return $row;
    }

    // Devuelve la cantidad de endpoints que hay, para sacar el modulo en changeRPC
    public function readEndpointsCount()
    {
        $query = 'SELECT COUNT(*) AS quantity FROM relayerRPC';
        $result = $this->base->prepare($query);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();

        return $row['quantity'];
    }



/*!
* \brief    Deletes all rows in the database
* \details  By sql query using PDO, we delete all.
* \param all    Identifier of what we want to erase from the database.
* \return   $success  (bool) true if it has deleted the row, false in any other case.
*/
    public function deleteAll() {
        $query='delete from relayerRPC where 1';
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
        $query='delete from relayerRPC where id=:id';
        $result= $this->base->prepare($query);
        $id=htmlentities(addslashes($id));
        $result->BindValue(':id',$id);

        $success = $result->execute();
        $result ->closeCursor();
        return $success;
    }



/*!
* \brief    Deletes rows in the database by endpoint
* \details  By sql query using PDO, we delete all the results where the endpoint matches.
* \param endpoint    Identifier of what we want to erase from the database.
* \return   $success  (bool) true if it has deleted the row, false in any other case.
*/
    public function deleteByEndpoint($endpoint) {
        $query='delete from relayerRPC where endpoint=:endpoint';
        $result= $this->base->prepare($query);
        $endpoint=htmlentities(addslashes($endpoint));
        $result->BindValue(':endpoint',$endpoint);

        $success = $result->execute();
        $result ->closeCursor();
        return $success;
    }





    
}

?>