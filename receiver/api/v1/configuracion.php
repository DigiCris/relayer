
<?php
// Here we will add every constant, password and development stage of the platform

/*!
* \brief	Constant to determine the stage of the website
* \details	DEBUG_ECHO: printing echo texts ; DEBUG_CONSOLE: print console.logs ; PRODUCTION: no printing anything on the screen
*/
define('DESARROLLO', 'PRODUCTION');

/*!
* \brief   Our website domain
*/
define('MYURL', 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST']);

/*!
* \brief   Name of the database for comunyt
*/
define('DBNAME','');
/*!
* \brief    User for the comunyt database
*/
define('DBUSER','');
/*!
* \brief    Password for the user of the comunyt database
*/
define('DBPASSWD','');

/*! 
* \brief    Constant to determine an admin user.
* \details 	It is used to access certain information that only logged in administrators can do. YES: Redirect to the authentification files ; NO: does nothing.
*/
define('VERIFYLOGIN', 'NO');

// to print this every time this file is added in order to check if it is correctly added
debug ('soy configuracion.php <br>'); 

/*!
* \brief    Prints a message on the screen for debuging
* \details  Only if we are in debuging mode, which can be seen in the constant DESARROLLO, is that we will print the echos to the screen.
* \param $mensaje    (string) this is the message we want to print for debugging. Console.log function not implemented yet.
* \return   void  (void) It returns nothing but if we are in debugging mode we print the message on the screen with an echo.
*/
function debug($mensaje) {
    if(DESARROLLO==='DEBUG_ECHO') {
        echo $mensaje;
        return;
    }
    if(DESARROLLO==='DEBUG_CONSOLE') {
        //implementacion not done yet
        return;
    }
    if(DESARROLLO==='PRODUCTION') {
        return;
    }
}

/*!
* \brief    Send to the login page to login as admin. No está funcional, habría que agregarla en los archivos que crea authCreator
* \details  If the constant VERIFYLOGIN = 'YES', we redirect to the authentification files to login as administrator. If it's 'NO', does nothing.
* \return   void  (void) It returns nothing but if we are in VERYFYLOGIN='YES' we redirect to the authentication files. We also verify that the origin is from comunyt.com and not from another site. 
*/
function auth_489203842093() {
    if(VERIFYLOGIN==='YES') {
        session_start();
        include_once 'auth.php';
        include_once 'authProcedencia.php';
        return;
    }
    if(VERIFYLOGIN==='NO') {
        return;
    }
}
        
/*!
* \brief    Verify the origin of the request. No esta funcional...
* \details  If the VERIFYLOGIN constant = 'YES', we verify if the source request comes from comunyt. If so, we allow data retrieval. Otherwise, we prevent the loading of the data.
* \return   void  (void) 
*/
function verify_origin_829380921381209381() {
    if(VERIFYLOGIN==='YES') {
        //session_start();
        include_once 'authProcedencia.php';
        return;
    }
    if(VERIFYLOGIN==='NO') {
        return;
    }
}

/*!
* \brief    Send to the login page to login as superAdmin. No esta funcional...
* \details  If the constant VERIFYLOGIN = 'YES', we redirect to the authentification files to login as superAdmin. If it's 'NO', does nothing.
* \return   void  (void) It returns nothing but if we are in VERYFYLOGIN='YES' we redirect to the superAdmin authentication files. We also verify that the origin is from comunyt.com and not from another site.
*/
function superAuth_83904830943902() {
    if(VERIFYLOGIN==='YES') {
        session_start();
        include_once 'authProcedencia.php';
        include_once 'authSuperAdmin.php';
        return;
    }
    if(VERIFYLOGIN==='NO') {
        return;
    }
}
        
?>
