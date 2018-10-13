<?php
/**
 * User: Becopay Team
 * Version 0.0.1
 * Date: 10/10/18
 * Time: 10:50 AM
 */

namespace Becopay;


/**
 * Interface PaymentGatewayInterface
 *
 * @package becopay\gateway
 */
interface PaymentGatewayInterface
{


    /**
     * PaymentGatewayInterface constructor.
     *
     * @param string $apiUrl payment gateway api base url
     * @param string $apiKey payment gateway api key
     * @param string $mobile merchant mobile number
     */
    public function __construct($apiUrl,$apiKey,$mobile);

    /**
     * Create the payment invoice and return the gateway url
     * @param  string $orderId
     * @param integer $price
     * @param string $description
     * @return object
     */
    public function create($orderId,$price,$description);

    /**
     * Check the payment status
     * @param string $invoiceId
     * @return object
     */
    public function check($invoiceId);

}