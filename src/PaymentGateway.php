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
     * @var string payment gateway base url
     */
    private $gatewayUrl;

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
     * @param string $gatewayUrl
     * @param string $apiKey payment gateway api key
     * @param string $mobile merchant mobile number
     * @throws \Exception
     */
    public function __construct($apiUrl, $gatewayUrl, $apiKey, $mobile)
    {
        /*
         * validate the url
         * If url is invalid throw the exception
         */
        self::__validateUrl($apiUrl);
        self::__validateUrl($gatewayUrl);

        /*
         * Check value is string
         * If url is invalid throw the exception
         */
        self::__isString($apiKey);
        self::__isString($mobile);

        $this->apiUrl = trim($apiUrl);
        $this->gatewayUrl = trim($gatewayUrl);
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
         * If url is invalid throw the exception
         */
        self::__isString($orderId);
        self::__isString($price);
        self::__isString($description);

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
         * If url is invalid throw the exception
         */
        self::__isString($invoiceId);

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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $method == 'POST' ? json_encode($param) : '',
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        return (object)array(
            'code' => $httpCode,
            'response' => $error ? $error : json_decode($response),
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
    private function __isString($string)
    {
        if (!is_string($string))
            throw new \Exception('parameter is not string');
        return true;
    }

}