<?php 
    header('Content-Type: application/json');
    //C:\xampp\htdocs\RPCcomunyt\relayer\php2\vendor\drlecks\simple-web3-php\Core\SWeb3.php
    require_once 'vendor/autoload.php';
    use SWeb3\SWeb3;
    use SWeb3\Utils;
    use Web3\Contract;

    define('ENV', parse_ini_file('.env'));  // Cargo el .env con variables de entorno

/* TO DO
    3)verify y send adentro podrían hacer los retries o la logica para errores en los rpc
*/

    $sweb3 = -1;
    $nonce = -1; // se pone global para setearlo una sola vez y ahorrar llamados
    $id = -1 ;
    $urlId = -1;
    /*
    getRPC($urlId);
    exit;
    */
    initialize(); // inicializo el sistema
    relayTransaction(); // realizo el relay. Primero verifica que pueda hacerlo para no gastar gas y si puede lo hace


    function getNextUrlId() {
        return 1;
    }


    /* initialize() 
        Inicializa las variables globales sweb3, $nonce y setea el address y privateKey de la cuenta del
        relayer.
        */
        function initialize() {
        try {
            // Inicializar el objeto principal de SWeb3
            global $sweb3;
            global $nonce;  
            global $urlId;
            $urlId = getNextUrlId();          
            $url = getRPC($urlId);
            $sweb3 = new SWeb3($url);
    
            // Opcional: si se van a enviar transacciones
            $from_address = getFromAddress();
            $from_address_private_key = getPrivateKey();
            $sweb3->setPersonalData($from_address, $from_address_private_key);
            $nonce = getNonce();

            // TODO: Probar reintentos antes de cortar la ejecución. Probar con otro RPC si el primero falla.
        } catch (Exception $e) {
            // Capturar cualquier excepción ocurrida durante la ejecución
            $response["success"] = false;
            $response["msg"] = "error: We could not initialize: " . $e->getMessage();

            // Corto la ejecución si falla
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }
    }

    function changeRPC() {
        try {
            // Inicializar el objeto principal de SWeb3
            global $sweb3;
            global $nonce;
            global $urlId;
            $urlId = $urlId++;          
            $url = getRPC($urlId);
                 
            $sweb3 = new SWeb3($url);
    
            // Opcional: si se van a enviar transacciones
            $from_address = getFromAddress();
            $from_address_private_key = getPrivateKey();
            $sweb3->setPersonalData($from_address, $from_address_private_key);
            $nonce = getNonce();
        } catch (Exception $e) {
            // Capturar cualquier excepción ocurrida durante la ejecución
            $response["success"] = false;
            $response["msg"] = "error: We could not initialize: " . $e->getMessage();
            return $response;
        }
    }

    /* getVerifierSelector()
        Me da el selector usado para la verificación. Esta en función por si se quiere modificar en un 
        futuro la forma en que se toma
        */
        function getVerifierSelector() {
        return "0xbf5d3bdb";
    }

    /* getExecuteSelector()
        Me da el selector usado para la ejecución. Esta en función por si se quiere modificar en un 
        futuro la forma en que se toma
        */
        function getExecuteSelector() {
        return "0x47153f82";
    }

    /* getAdminMail()
        Me da el email de quien reciba los incidentes. Esta en función por si se quiere modificar en un 
        futuro la forma en que se toma
        */
        function getAdminMail() {
            return "cmarchese@comunyt.com";
    }

    /* email($emailAddress,$titulo,$contenido)
        Manda al emailAddress un email con el titulo en el asunto y el contenido adentro.
        Falta implementar. Pedirle a Nico.
        */
    function email($emailAddress, $titulo, $contenido) {
        // (1) Definición del correo y tomar parámetros del .env
        $transactional_api_key = ENV['BREVO_API_KEY'];     // APIKEY
        $template_id = ENV['BREVO_TEMPLATE_ID'];           // Templateid de la plantilla
        $brevo_url = 'https://api.brevo.com/v3/smtp/email'; // Brevo email URL
        $from = 'contacto@comunyt.co';                     // Campo from del email

        // Campos del correo
        $email_required_fields = json_encode([
            // El que envía el correo
            "sender" => [
                "name" => "Comuny-T Relayer",
                "email" => $from
            ],

            // Los parámetros, texto y título.
            "params" => [
                "title" => $titulo,
                "text" => $contenido
            ],

            // A quién responder (brevo lo pide aunque no lo usemos)
            "replyTo" => [
                "name" => "Comuny-T Relayer",
                "email" => $from
            ],

            // Para quién es el correo
            "to" => [
                [
                    "email" => $emailAddress,
                    "name" => "Administrador de Comuny-T Relayer"
                ]
            ],

            // Id de la plantilla de brevo y el tag para identificar el tipo de correo
            "templateId" => $template_id,
            "tags" => [
                "relayer"
            ]
        ]);

        // (2) CURL para enviar el correo
        $c = curl_init($brevo_url);
                curl_setopt($c, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($c, CURLOPT_POSTFIELDS, $email_required_fields);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, [ 
            "accept: application/json", 
            "api-key: $transactional_api_key",
            "Content-Type: application/json"
            ]
        );

        // (3) Tomo la respuesta y el http code
        $brevo_response = json_decode(curl_exec($c), true);
        $brevo_response['http_code'] = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);

        return $brevo_response; 
        // Brevo devuelve 201 o 202 como codigos de exitos. 
        // Cualquier otro código será considerado como falla al enviar correo.
        //echo json_encode($contenido, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    function maxRetries() {
        return 10;
    }
    function retriesByEndpoint() {
        return 4;
    }

    function getRelayerAddress() {
        return '0x0f56EA91233eA958eA3820Ba0F94349aFD866833';
    }

    /* relayTransaction()
        Funcion que organiza secuencialmente el relay de la transaccion. Al finalizar devuelve la respuesta de la transacción o el error. Ej:
        {"success":true,"msg":"sent successfully to blockchain","response":"0x4aa3c5b66fc14cbd05cc9959534f2f0787e129d1bb6b044044eb51ba60908441"}
        */
        function relayTransaction() {

        global $id;
        // obtengo los datos que se mandan con la firma para relayar
        $response = receiveData();
        // Si falla en recibir los datos mando el error. En este caso no hace falta crear log.
        if($response["success"]==false) {
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        // creo el campo data que se le va a mandar al relayer con los paramentros que vienen del post
        $verSelector = getVerifierSelector();
        $_POST["selector"] = $verSelector;
        //$_POST["selector"] = $_POST["selector"].'1'; // probando mal funcionamiento de createDatastring

        // Agregado para el post y su caso de falla con envío de email
        $response = post("setAll",$_POST);
        if ($response["success"] == false) {
            email(getAdminMail(),"Problema: set request en DB fallo",$response);
        } else {
            $response["response"] = json_decode($response["response"],true);
            $id = $response["response"]["response"]["id"];
        }

        // Termina agregado para el post
        
        $response = createDataString($_POST["selector"],
                        $_POST["from"],
                        $_POST["to"],
                        $_POST["value"],
                        $_POST["gas"],
                        $_POST["nonce"],
                        $_POST["data"],
                        $_POST["signature"]);

        // Si falla por algún motivo lo informo. Esto solo puede deberse a un error externo del llamado. Pasarle mal los parametros por ejemplo. así que no mando email
        if($response["success"]==false) {
            if($id>=0) {
                $response["status"] = "wrongData";            
                $response["response"] = post("updateStatusById",$response);
                if ($response["response"]["success"] == false) {
                    email(getAdminMail(),"Problema ".$id.": update to wrongData status in en DB failed",$response);
                }
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }


        // Realizo un call al verifier del relayer para saber si se puede ejecutar o no y ahorrar gas ante falta de permisos
        $aux = $response["response"];
        $response = verify(getRelayerAddress(),$aux);
        $maxRetries=maxRetries();//10;
        $retriesByEndpoint = retriesByEndpoint();//4;
        for($i=1; $response["success"]==false && $i<=$retriesByEndpoint && $maxRetries>0; $i++) { //14 segundos con cada uno
            if($i==$retriesByEndpoint) {
                changeRPC();
                $micro_seconds = 0;
                $i=1;
            }else {
                $micro_seconds = 1000000 * $i + mt_rand(0, 1000000);
            }
            usleep($micro_seconds);
            $response = verify(getRelayerAddress(),$aux);
            $maxRetries--;
        }

        // Informo si hubo un error con la verificación. Esto si hay que ponerlo en el log o hacer retries
        if( isset($response["response"]) ) {
            // Informo si tiene permiso o no para ejecutar y solo mando si lo tiene para ahorrar gas.
            if($response["response"]!=false) {
                // cambio el selector de verify al de execute y envío la transaccion para que se ejecute
                $excSelector = getExecuteSelector();
                $response["response"] = str_replace($verSelector,$excSelector,$response["response"]);
                $response = send(getRelayerAddress(),$response["response"]);

                if($response["success"]==true) {
                    $response["txHash"] = $response["response"];
                }else {
                    $response["txHash"] = "gas problem";
                }
                
                if (preg_match('/0x\w+/i', $response["txHash"])) {
                    // El string contiene "0x" seguido de caracteres alfanuméricos
                    $response["status"] = "success";
                    $response["post"] = post("updateStatusById",$response);
                    $response["post"] = post("updateTxHashById",$response);
                    if ($response["post"]["success"] == false) {
                        email(getAdminMail(),"Problema ".$id.": update to success status in DB failed",$response);
                    }
                } else { // comprobado
                    $response["status"] = "sentFailed";
                    $response["post"] = post("updateStatusById",$response);
                    email(getAdminMail(),"Problema ".$id.": sentFailed",$response);
                }
            }else { //comprobado
                // si no coincide la firma con el mensaje
                $response["success"] = false;
                $response["msg"]="Not the signer";
                $response["status"] = "signerFailure";
                $response["post"] = post("updateStatusById",$response);
                email(getAdminMail(),"Problema ".$id.": signerFailure",$response);
            }
        }else { //comprobado
            // si fallo la funcion verificar por algun error (en el nodo por ejemplo)
            $response["success"] = false;
            $response["msg"]="We could not verified. Try again latter";
            $response["status"] = "RPCnodeFailure";
            $response["post"] = post("updateStatusById",$response);
            email(getAdminMail(),"Problema ".$id.": RPCnodeFailure",$response);
        }
        //Imprimo el resultado, ya sea el hash creado o los mensajes de errores que se propagaron
        // esto si debo ponerlo en el log e incluso hacer el retry.
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /* verify($to, $data)
        Verifica que el relayer pueda realizar la operacion. devuelve en $response["response"]=false cuando no se verifica la firma y ["success"]=false con un problema de la llamada al call propagando su error.
        La data que devuelve en response es para poderla usar para ejecutar luego de esta verificacion y por eso
        solo está en caso de exito. (Recordar que antes de ejecutar debe cambiarse el selector de verificacion
        por el de ejecución para hacer la llamada al mentodo send)
        */
        function verify($to, $data) {
        $responseAux = call($to,$data);
        if($responseAux["success"]==false) {
            $response["success"] = false;
            $response["msg"]="We could not verify. Try again latter";
            return $response;
        }

        $r = json_encode($responseAux["response"], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $r = json_decode($r,true);

        if(strpos($r["result"],"1") > 10) {
            $response["success"] = true;
            $response["msg"]="Signer ok";
            $response["response"] = $data;
        } else {
            $response["success"] = true;
            $response["msg"]="Not the signer";
            $response["response"] = false;
        }
        return $response;
    }

    /* getRPC($urlId)
        me devuelve el RPC que se usa. Está en función porque así podemos cambiar la lógica de como organiza
        la devolución de los RPC y usar varios.
        tomaria el endpoint segun el urlId peviamente modularizandolo para que no se pase de la cantidad que hay.
        */
        function getRPC($urlId) {
            /*
            $urlId=1;
        $endpoint = get("https://comunyt.co/relayer/api/v1/relayerRPC/getById/".$urlId);
        //$endpoint["response"] = json_decode($endpoint["response"],true);
        $endpoint = ($endpoint["response"][0]["endpoint"]);
        print_r($endpoint);
        exit;*/

        //TODO: Get lower order val
        // $endpoint = get("https://comunyt.co/relayer/api/v1/relayerRPC/getByLowerOrderVal");
        // $endpoint = $endpoint['response'][0]['endpoint'];
        return 'https://polygon-amoy-bor-rpc.publicnode.com';
    }

    /* getFromAddress()
        Address of the relayer. La idea de la función es poder modificar la lógica de lo que entrega.
        Tiene que coincidir obviamente con private key de getPrivateKey().
        */
        function getFromAddress() {
        return ENV['RELAYER_ADDRESS'];
    }

    /* getPrivateKey()
        PrivateKey del relayer. La idea de la función es poder modificar la lógica de lo que entrega.
        Tiene que coincidir obviamente con el address de getFromAddress()
        */
        function getPrivateKey() {
        return ENV['RELAYER_PRIVATE_KEY'];
    }

    /* createDataString($selector,$from,$to,$value,$gas,$nonce,$data,$signature)
        0-7         0xbf5d3bdb
        0-31        0000000000000000000000000000000000000000000000000000000000000040 = 64                   => desde donde empieza la tupla
        32-63       0000000000000000000000000000000000000000000000000000000000000160 = 352                  => hasta donde termina la tupla
        64-95       000000000000000000000000112d7b19a01fa18cbdaa069d266553be254bff90 = from
        96-127      0000000000000000000000006867ff657d1d7bc23f0a5810d835e5c6f4e0b583 = to
        128-159     0000000000000000000000000000000000000000000000000000000000000000 = value
        160-191     00000000000000000000000000000000000000000000000000000000000f4240 = gas (1000000)
        192-223     0000000000000000000000000000000000000000000000000000000000000000 = nonce
        224-255     00000000000000000000000000000000000000000000000000000000000000c0 = 192                  => 192 + 64 = 256 (donde empieza la data)
        256-287     0000000000000000000000000000000000000000000000000000000000000024 = 36                   => Largo de data
        288-319     9eda069f000000000000000000000000250a6e217023b648b7d42a6e7f99bb38 = data(32)
        320-351     0e10432600000000000000000000000000000000000000000000000000000000 = data(4)
        352-383     0000000000000000000000000000000000000000000000000000000000000041 = 65                   => largo de signature
        384-415     8f3030420e2376d7f80e8d70a49abfdb72bd48eeb5d5a13c79ff3716291b0909 = signature(32)
        416-447     59d96497c85a2449759d2629854ed7fbcb4504c303ab0bba35fdf7fd61c0b1f2 = signature(32)
        448-479     1c00000000000000000000000000000000000000000000000000000000000000 = signature(1)

        Esta funcion crea la data para enviarle al forwarder devolviendola en $response["response"].
        En caso de error devuelve el ["success"] = false; y en ["msg"] te dice a que se debe. Pero
        los errores acá solo pueden deberse a longitudes mal envíadas de los argumentos.
        */
        function createDataString($selector,$from,$to,$value,$gas,$nonce,$data,$signature) {
        $selector = preg_replace('/^0x/', '', $selector);
        if(strlen($selector)!=8) {
            $response["success"] = false;
            $response["msg"] = "Error: Selector wrong lenght";
            return $response;
        }
        $signature = preg_replace('/^0x/', '', $signature);
        if(strlen($signature)!=130) {
            $response["success"] = false;
            $response["msg"] = "Error: signature wrong lenght";
            return $response;
        }

        $from = preg_replace('/^0x/', '', $from);
        $to = preg_replace('/^0x/', '', $to);

        if (strpos($gas, '0x') === 0) {
            $gas = preg_replace('/^0x/', '', $gas);
        } else {
            if (!preg_match('/[a-f]/i', $gas)) {
                $gas = sprintf('%X', $gas);
            }
        }
        $gas = str_pad($gas, 64, '0', STR_PAD_LEFT);
        $gas = strtoupper($gas);

        if (strpos($value, '0x') === 0) {
            $value = preg_replace('/^0x/', '', $value);
        } else {
            if (!preg_match('/[a-f]/i', $value)) {
                $value = sprintf('%X', $value);
            }
        }
        $value = str_pad($value, 64, '0', STR_PAD_LEFT);

        if (strpos($nonce, '0x') === 0) {
            $nonce = preg_replace('/^0x/', '', $nonce);
        } else {
            if (!preg_match('/[a-f]/i', $nonce)) {
                $nonce = sprintf('%X', $nonce);
            }
        }
        $nonce = str_pad($nonce, 64, '0', STR_PAD_LEFT);

        $data = preg_replace('/^0x/', '', $data);
        $dataSize = str_pad(dechex(strlen($data)/2), 64, '0', STR_PAD_LEFT);
        $dataVector = str_split($data, 64);
        $lastIndex = count($dataVector) - 1;
        $dataVector[$lastIndex] = str_pad($dataVector[$lastIndex], 64, '0', STR_PAD_RIGHT);
        //$dataSize = str_pad(dechex(count($dataVector) * 0x20), 64, '0', STR_PAD_LEFT);
        $end = str_pad(dechex(320 + (32*(count($dataVector)-1))), 64, '0', STR_PAD_LEFT);
        $data = implode('', $dataVector);

        $texto = "0x".$selector."0000000000000000000000000000000000000000000000000000000000000040".$end."000000000000000000000000".$from."000000000000000000000000".$to.$value.$gas.$nonce."00000000000000000000000000000000000000000000000000000000000000c0".$dataSize;
        $texto .= $data;
        $texto .= "0000000000000000000000000000000000000000000000000000000000000041".$signature."00000000000000000000000000000000000000000000000000000000000000";
        
        $response["success"] = true;
        $response["msg"] = "data field created";
        $response["response"] = $texto;
        return $response;
    }
    
    /*  receiveData() 
        Recibo la data que viene del post y la devuelvo en $response["response"]. Si no se puede porque 
        no se recibió nada en el post o hubo algún problema propaga el error devolviendolo.
        */
        function receiveData() {
        //Ubico la data que recibo en $_POST
        setPostWhenMissing();
        //verifico que haya recibido algo
        if(!empty($_POST)) {
            $response["success"]=true;
            $response["msg"]="data received. Saved in POST";
            $response["response"] = $_POST;
        } else {
            $response["success"]=false;
            $response["msg"]="error: no post data sent";
        }
        //devuelvo lo que recibí o el success en false para verificarlo mas arriba
        return $response;;   
    }

    /* getGas()
        Obtengo el gasLimit del valor envíado por el metodo post. Si el gas acá es muy alto puede superar
        el dinero que haya en la cuenta del relayer y fallará la transacción. Si es muy bajo puede no
        llegar a hacerse. La que yo hice del prueba con el relayer simple para incrementar un valor en 100
        la primera vez tomó un poco mas de 80K de gas y las sucesivas 53K
        */
        function getGas() {
        return $_POST["gas"];
    }

    /* getValue()
        Obtiene el valor a envíar de la cuenta del relayer durante la llamada. Por ahora está en 0 porque
        no quiero envíar Matics, pero lo puse como función para poder tocar su lógica en un futuro.
        */
        function getValue() {
        return Utils::toWei('0', 'ether');
    }

    /* getChainId()
        Devuelve el identificador de cadena. 80002 para Polygon Amoy (0x13882). En función para luego poder
        trabajar con muchas cadenas.
        */
        function getChainId() {
        return 0x13882;
    }

    /* getNonce()
        Obtiene el nonde de la cuenta seteada como personal durante la inicializacion (la del relayer).
        Esto es para poder armar las peticiones y lo hago en una función para poder tocar la logíca.
        llamarlo desde esta misma base de datos por ejemplo y así ahorrar llamados a la blockchain.
        O también poder eliminar el error de llamadas multiples que puede causar que el nonce no se
        haya actualizado.
        */
        function getNonce() {
        global $sweb3;
        return $sweb3->personal->getNonce();
    }

    /* send($to, $data)
        Realiza el envío con la cuenta seteada en personal hacía la dirección $to y con el campo data que tiene
        $data. Esto es para poder llamar al relayer en $to y decirle en $data lo que tiene que hacer.
        */
        function send($to, $data) {
        try {
            global $nonce; // es una variable global para caluclarlo una sola vez y ahorrar llamados al RPC
            global $sweb3;
            $sendParams = [
                'from' =>    $sweb3->personal->address,
                'to' =>      $to,
                'gasLimit' => getGas(), // si pongo de menos funciona pero se queda sin gas, de más puede superar lo que tengo
                'value' =>   getValue(),
                'nonce' =>   $nonce,
                'chainId' => getChainId(),
                'data' => $data
            ];
    
            $result = $sweb3->send($sendParams);
            $error = serialize($result);
            if (strpos($error, 'rror') > 0) {
                $response["success"] = false;
                $response["msg"] = "error: 1) data not sent to blockchain: ". $error;
                return $response;
            }
            $response["success"] = true;
            $response["msg"] = "sent successfully to blockchain";
            $response["response"] = $result->result;
            return $response;
    
        } catch (Exception $e) {
            // Capturar cualquier excepción ocurrida durante la ejecución
            $response["success"] = false;
            $response["msg"] = "error: 2) data not sent to blockchain: " . $e->getMessage();
            return $response;
        }
    }

    /* setPostWhenMissing()
        Se asegura que sin importar como hayan llamado al POST, estén todos los datos en $_POST
        Trata los diferentes casos pero no los errores, Si no llega nada se puede manejar más arriba
        preguntando si hay algo en $_POST.
        */
        function setPostWhenMissing() {
        if(empty($_POST)) {
            $aux = json_decode(file_get_contents('php://input'), true);
            if ($aux !== null) {
                $_POST["from"] = $aux["request"]["from"];
                $_POST["to"] = $aux["request"]["to"];
                $_POST["value"] = $aux["request"]["value"];
                $_POST["gas"] = $aux["request"]["gas"];
                $_POST["nonce"] = $aux["request"]["nonce"];
                $_POST["data"] = $aux["request"]["data"];
                $_POST["signature"] = $aux["signature"];
            } else {
                //no llego nada. Manejado en funcion superior cuando post está vacío
            }
        } else {
            if(isset($_POST["request"]["selector"])){
                $_POST["selector"] = $_POST["request"]["selector"];
            }                
            if(isset($_POST["request"]["from"])) {
                $_POST["from"] = $_POST["request"]["from"];
            }
            if(isset($_POST["request"]["to"])) {
                $_POST["to"] = $_POST["request"]["to"];
            }
            if(isset($_POST["request"]["value"])) {
               $_POST["value"] = $_POST["request"]["value"]; 
            }
            if(isset($_POST["request"]["gas"])) {
                $_POST["gas"] = $_POST["request"]["gas"];
            }                
            if(isset($_POST["request"]["nonce"])) {
                $_POST["nonce"] = $_POST["request"]["nonce"];
            }                
            if(isset($_POST["request"]["data"])) {
                $_POST["data"] = $_POST["request"]["data"];
            }                
            if(isset($_POST["request"]["signature"])) {
                $_POST["signature"] = $_POST["request"]["signature"];
            } 
        }
    }

    /* test($selector,$from,$to,$value,$gas,$nonce,$data,$signature)
        Me imprime los datos que le mando para poder ponerlo en la consola de remix en el minimalForwarder
        */
        function test($selector,$from,$to,$value,$gas,$nonce,$data,$signature) {
        $texto = "[".$from.", ".$to.", ".$value.", ".$gas.", ".$nonce.", ".$data."], ".$signature;
        echo $texto;
        exit;
    }


    /* call($to, $data)
        Realiza el metodo rpc eth_call a la dirección especificada en to con los parametros pasado en data.
        Ignora todo el resto de los parametros que pueda tener este metodo eth_call.
        Devuelve el resultado del call en caso de exito y la descripción de los errores sino para propagarlos
        más arriba.
        */
        function call($to, $data) {
        try {
            global $sweb3;
            global $nonce; // es una variable global para calcularlo una sola vez y ahorrar llamados al RPC
            $callParams = [
                [
                    'to' => $to,
                    'data' => $data
                ],
                'latest'
            ];
    
            $result = $sweb3->call('eth_call', $callParams);
    
            $error = serialize($result);
            if (strpos($error, 'rror') > 0) {
                $response["success"] = false;
                $response["msg"] = "error: call 1) data not sent to blockchain: " . $error;
                return $response;
            }
    
            $response["success"] = true;
            $response["msg"] = "call successful";
            $response["response"] = $result;
            return $response;
    
        } catch (Exception $e) {
            // Capturar cualquier excepción ocurrida durante la ejecución
            $response["success"] = false;
            $response["msg"] = "error: call 2) data not sent to blockchain: " . $e->getMessage();
            return $response;
        }
    }




    function post($method,$data) {
        global $id;
        $backup = $_POST;
        $_POST = array();

        $dataStrig = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $dataStrig = preg_replace('/[^[:alnum:]{},:\"[\] ]/', '', $dataStrig);

        $url = "https://comunyt.co/relayer/api/v1/requestLogs/".$method;

        if(isset($data["status"])) {
            $status = $data["status"];
        }else {
            $status = "pending";
        }

        if(isset($data["txHash"])) {
            $txHash = $data["txHash"];
        }else {
            $txHash = "";
        }

        if(!isset($data["from"])) {
            $data["from"] = '';
        }

        $data = array(
            "method" => $method,
            "id" => $id,
            "request" => $dataStrig,
            "txHash" => $txHash,
            "status" => $status,
            "from" => $data["from"],
            "nonce" => 0,
            "emailSent" => 0,
            "retry" => 0,
            "timestamp" => date('Y-m-d H:i:s')
        );
        $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
        
        $response["response"] = curl_exec($curl);
        if ($response["response"] == false) {
            // Ocurrió un error durante la ejecución de la solicitud
            $error = curl_error($curl);
            $response["msg"] = "Error en la solicitud cURL: " .$error;
            $response["success"] = false;
        }else {
            $response["msg"] = "Request added";
            $response["success"] = true;
        }
        curl_close($curl);
         
        $_POST = $backup;
        return $response;
    }


    function get($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
    
        $json = json_decode($response, true); // Decodificar la respuesta JSON en una matriz
    
        return $json;
    }



    
?>