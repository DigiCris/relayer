
<?php
/*!
* \brief Send a POST request using cURL
* \details The POST request receives an URL to make the curl, an array with the parameters in $_POST method and an empty array of options (which in this case are not needed).
* \param $url (string) Url to request.
* \param $post (array)  Values to send.
* \param $options (array) Options for cURL. At default is empty.
* \return $result (bool) Returns true if the curl execution was successful, false if not.
*/
include_once "./configuracion.php";

function curl_post($url, array $post, array $options = array())
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
        CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if( ! $result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

/*!
* \brief Send a GET request using cURL.
* \details This function receives the url with GET method and try to get the response of the query. Example: https://test.com/?var=getexample -> Where 'var=getexample' is an example of a GET petition.
* \param $url (string) Url to request.
* eturn $result (string) Returns the content of the get request if the curl execution was successful, false if not.
*/

function curl_get($url)
{
    $ch = curl_init();

    // Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, $url); 

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    if (!$result = curl_exec($ch))
    {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

/*!
* \brief Read $_POST from swagger.
* \details Converts the post input format to a $_POST format.
* \param (void) No params.
* eturn (void) Nothing returns.
*/

function setPostWhenMissing()
{
    debug("dentro de setPostWhenMissing");
    if(empty($_POST))
    {
        debug("estaba vacio $_POST por lo que lo trajde de php://input");
        $_POST = json_decode(file_get_contents('php://input'), true);
        debug($_POST);
    }
}

?>
        