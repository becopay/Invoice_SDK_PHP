<?php
/**
 * User: Becopay Team
 * Version 0.0.1
 * Date: 10/10/18
 * Time: 10:36 AM
 */

namespace Becopay;


/**
 * Class PaymentGateway
 *
 * @package Becopay\Gateway
 */
class PaymentGateway implements PaymentGatewayInterface
{

    /**
     * @var string payment gateway api base url
     */
    private $apiUrl;

    /**
     * @var string payment gateway api key
     */
    private $apiKey;
    /**
     * @var string merchant mobile number
     */
    private $mobile;


    /**
     * @var string error message
     */
    public $error = '';

    /**
     * PaymentGateway constructor.
     *
     * @param string $apiUrl
     * @param string $apiKey
     * @param string $mobile merchant mobile number
     * @throws \Exception
     */
    public function __construct($apiUrl, $apiKey, $mobile)
    {
        /*
         * validate the url
         * If url is invalid throw the exception
         */
        self::__validateUrl($apiUrl);

        /*
         * Check value is string
         * If string is invalid throw the exception
         */
        self::__validateString($apiKey,100);
        self::__validateString($mobile,15);

        $this->apiUrl = trim($apiUrl);
        $this->apiKey = trim($apiKey);
        $this->mobile = trim($mobile);
    }

    /**
     * Create the payment invoice and return the gateway url
     *
     * @param  string $orderId
     * @param string  $price
     * @param string  $description
     * @return mixed bool | object
     * @throws \Exception
     */
    public function create($orderId, $price, $description)
    {
        /*
         * Check value is string
         * If string is invalid throw the exception
         */
        self::__validateString($orderId,50);
        self::__validateString($price,20);
        self::__validateString($description,255);

        $param = array(
            "apiKey" => $this->apiKey,
            "mobile" => $this->mobile,
            "description" => $description,
            "orderId" => $orderId,
            "price" => $price
        );

        // Clear the error variable
        $this->error = '';

        $result = self::__sendRequest('invoice', 'POST', $param);


        // if response code is 200 return the response value
        if ($result->code === 200) {
            if (isset($result->response->qr))
                unset($result->response->qr);

            return $result->response;

        } else if ($result->code == 0) { // if response code is 0 return false and set error message
            $this->error = $result->response;
            return false;
        } else { //Get error massage and return false
            if (isset($result->response->description))
                $this->error = $result->response->description;
            return false;
        }
    }

    /**
     * Check the payment status
     *
     * @param string $invoiceId
     * @return mixed
     * @throws \Exception
     */
    public function check($invoiceId)
    {
        /*
         * Check value is string
         * If string is invalid throw the exception
         */
        self::__validateString($invoiceId,50);

        $param = array(
            "id" => $invoiceId
        );

        // Clear the error variable
        $this->error = '';

        $result = self::__sendRequest('invoice', 'GET', $param);

        // if response code is 200 return the response value
        if ($result->code === 200) {
            if (isset($result->response->qr))
                unset($result->response->qr);

            return $result->response;

        } else if ($result->code == 0) { // if response code is 0 return false and set error message
            $this->error = $result->response;
            return false;
        } else { //Get error massage and return false
            if (isset($result->response->description))
                $this->error = $result->response->description;
            return false;
        }
    }

    /**
     * Send the request to payment server
     *
     * @param string $urlPath
     * @param string $method request method type , POST|GET
     * @param array  $param request parameters
     * @return object
     */
    private function __sendRequest($urlPath, $method, $param)
    {
        $url = trim($this->apiUrl, '/') . '/' . trim($urlPath, '/');

        if ($method == 'GET') {
            $query = http_build_query($param);
            $url = $url . '?' . $query;
        }

        $opts = array('http' =>
            array(
                'method' => $method,
                'timeout'=>'30',
                'max_redirects'=>'10',
                'ignore_errors'=>'1',
                'header' => 'Content-type: application/json',
                'content' => $method == 'POST' ? json_encode($param) : ''
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);

        //get http status code
        $httpCode = (int)(explode(' ', $http_response_header[0]))[1];


        return (object)array(
            'code' => $httpCode,
            'response' => json_decode($result),
        );
    }


    /**
     * Validate url
     * If url is invalid throw the exception
     *
     * @param $url
     * @return bool
     * @throws \Exception
     */
    private function __validateUrl($url)
    {
        if (empty($url) || !is_string($url) || strlen($url) > 512 ||
            !preg_match('/^http(s)?:\/\/[a-z0-9-]+(.[a-z0-9-]+)+(:[0-9]+)?(\/.*)?$/i', $url) ||
            !filter_var($url, FILTER_VALIDATE_URL)
        ) {
            throw new \Exception('invalid url ' . $url);
        }
        return true;
    }

    /**
     * validate the string
     *
     * @param $string
     * @return bool
     * @throws \Exception
     */
    private function __validateString($string,$lenghth = 0)
    {
        if (!is_string($string))
            throw new \Exception('parameter is not string');
        if($lenghth > 0 && strlen($string) > $lenghth)
            throw new \Exception('parameter is too long');
        return true;
    }

}