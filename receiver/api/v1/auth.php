
            <?php
            include_once 'configuracion.php';
                    
/*!
* \brief    Verify the origin of the user.
* \details  If the user typed the URL and it doesn't come from our website, then we abort the connection.
*/
function proc0() {
    if(!isset($_SERVER['HTTP_REFERER']))
    {
        $success['success'] = false;
        $success['msg'] = 'You cannot access this page by typing the link in the browser directly.';
        //echo json_encode($success);
        //die;
    }
    else
    {
        // Get the hostname of the source page
        $referrer_host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

        // Get the hostname of the current page
        $current_host = $_SERVER['HTTP_HOST'];

        // Compare the hostname of the source page with the hostname of the current page
        if ($referrer_host != $current_host)
        {
            // If the host names are not the same, the page is being accessed from another domain
            $success['success'] = false;
            $success['msg'] = 'You cannot access this page from another page';
            //echo json_encode($success);
            //die;
        }
    }
}
                    
        if( proc0()  == true ) {
            $success['url'] = MYURL.'/api/v1/registers/functions/logout.php';
            $success['success'] = true;
            $success['msg'] = 'You are login';
        }else {
            $success['url']=MYURL.'/api/v1/registers/functions/login.php';
            //echo '<a href='".$url."'>Login <br></a>';
            $success['success'] = false;
            $success['msg'] = 'You do not have access';
            debug( json_encode($success) );
        }
        echo (json_encode($success));
        ?>