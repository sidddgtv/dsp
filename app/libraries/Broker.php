<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class for generating broker Properties
 *
 * @Niranjan sahoo
 */
class Broker {
	/**
	* Constants for available HTTP methods
	*/
    const GET     = 'GET';
    const POST    = 'POST';
    const PUT     = 'PUT';
    const PATCH   = 'PATCH';
    const DELETE  = 'DELETE';
	
	/**
    * @var cURL handle
    */
    public $CI;
	public $error_code;		 // Error code returned as an int
	public $error_string;
    public $curl;
    public $AccessToken;
    public $SubscriptionKey="f98db70a57df45789d87151dfd353ad3";
    public $client_id="aL16Yal1oIcm";
    public $client_secret="g9HlayKeGkDn";

    public $body;

	public $headers=array();
	
	/**
    * Create the cURL resource
    */
    public function __construct(){
        $this->CI =& get_instance(); 
        $this->curl = curl_init();
		$this->headers=array(
			"Content-Type: application/x-www-form-urlencoded", 
			"Ocp-Apim-Subscription-Key: $this->SubscriptionKey", 
		);
        $this->AccessToken = $this->getToken();

    }

    public function setHeaders($headers){
        
        if($headers=="json"){
            $this->body=$headers;
            $content_type="Content-Type: application/json";
        }else if($headers){
            $content_type=$headers;
        }else{
            $content_type="Content-Type: application/x-www-form-urlencoded";
        }
        $this->headers = array(
			$content_type,
			"Ocp-Apim-Subscription-Key: $this->SubscriptionKey", 
		);
        return $this;
    }

    public function getToken(){
        if(time() > $this->CI->session->userdata('access_token_expiry')) {
            // Get a new access token using the refresh token
            $params=array(
                'grant_type'=>'client_credentials',
                'client_id'=>$this->client_id,
                'client_secret'=>$this->client_secret,
                'scope'=>'customer'
            );

            $apiresult = $this->post('https://api-staging.booker.com/v5/auth/connect/token',$params);
            $responsedata=$apiresult['data'];
            //printr($responsedata);       
            // Again save the expiry time of the new token
            $this->CI->session->set_userdata('access_token_expiry', time() + $responsedata['expires_in']);
            $this->CI->session->set_userdata('access_token', $responsedata['access_token']);

            $token=$responsedata['access_token'];
        }else{
            $token=$this->CI->session->userdata('access_token');

        }
        return $token;
    }
    
	/**
    * Clean up the cURL handle
    */
    public function __destruct()
    {
        if (is_resource($this->curl))
        {
            curl_close($this->curl);
        }
    }
	/**
    * Get the cURL handle
    *
    * @return  cURL            cURL handle
    */
    public function getCurl()
    {
        return $this->curl;
    }
	/**
    * Make a HTTP GET request
    *
    * @param   string  $url          Full URL including protocol
    * @param   array   $params       Any GET params
	* @return  array                 Response
    */
	
    public function get($url, $params = array())
    {
        return $this->request($url, self::GET, $params);
    }
	 /**
     * Make a HTTP POST request
     *
     * @param   string  $url          Full URL including protocol
     * @param   array   $params       Any POST params
     * @return  array                 Response
     */
    public function post($url, $params = array())
    {
        return $this->request($url, self::POST, $params);
    }
    /**
     * Make a HTTP PUT request
     *
     * @param   string  $url          Full URL including protocol
     * @param   array   $params       Any PUT params
     * @param   array   $options      Additional options for the request
     * @return  array                 Response
     */
    public function put($url, $params = array())
    {
        return $this->request($url, self::PUT, $params);
    }
    /**
     * Make a HTTP PATCH request
     *
     * @param   string  $url          Full URL including protocol
     * @param   array   $params       Any PATCH params
     * @return  array                 Response
     */
    public function patch($url, $params = array())
    {
        return $this->request($url, self::PATCH, $params);
    }
    /**
     * Make a HTTP DELETE request
     *
     * @param   string  $url          Full URL including protocol
     * @param   array   $params       Any DELETE params
     * @return  array                 Response
     */
    public function delete($url, $params = array())
    {
        return $this->request($url, self::DELETE, $params);
    }
	 /**
     * Make a HTTP request
     *
     * @param   string  $url          Full URL including protocol
     * @param   string  $method       HTTP method
     * @param   array   $params       Any params
     * @return  array                 Response
     */
    protected function request($url, $method = self::GET, $params = array())
    {
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		
		if($method =="GET")
		{
			$url .= '?' . http_build_query($params);
		}
		else
		{
			curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($this->curl, CURLOPT_POSTFIELDS, ($this->body=="json")?json_encode($params):http_build_query($params));
		}
		
		curl_setopt($this->curl, CURLOPT_URL, $url);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
		
        
		
		
		$response = $this->doCurl();
		//printr($response);
        // Separate headers and body
        $responseSplit = preg_split('/((?:\\r?\\n){2})/', $response['response']);
        $responseCount = count($responseSplit);
        $results = array(
            'curl_info'     => $response['curl_info'],
            'status'        => $response['curl_info']['http_code'],
            'headers'       => $this->splitHeaders($responseSplit[$responseCount-2]),
            'data'          => json_decode($responseSplit[$responseCount-1],true),
        );
        return $results;
    }
	 /**
     * Split the HTTP headers
     *
     * @param   string  $rawHeaders     Raw HTTP headers
     * @return  array                   Key/Value headers
     */
    protected function splitHeaders($rawHeaders)
    {
        $headers = array();
        $headerLines = explode("\n", $rawHeaders);
        $headers['HTTP'] = array_shift($headerLines);
        foreach ($headerLines as $line) {
            $header = explode(":", $line, 2);
            $headers[trim($header[0])] = trim($header[1]);
        }
        return $headers;
    }
	 /**
     * Perform the Curl request
     *
     * @param   cURL Handle     $curl       The cURL handle to use
     * @return  array                       cURL response
     */
    protected function doCurl()
    {
        $response     = curl_exec($this->curl);
        $curlInfo     = curl_getinfo($this->curl);
		/*if ($curlInfo === FALSE)
		{
			$this->error_code = curl_errno($this->curl);
			$this->error_string = curl_error($this->curl);
			return false;
			
		} else {
			$response = json_decode($response,true);
		} */ 
		$results = array(
            'curl_info'     => $curlInfo,
            'response'      => $response,
        );
        return $results;
    }

    
	
}