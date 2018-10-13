<?php
/**
 * User: Becopay Team
 * Version 0.0.1
 * Date: 10/10/18
 * Time: 10:36 AM
 */

namespace Test;

use PHPUnit\Framework\TestCase;
use Becopay\PaymentGateway;
use Tests\LoadConfig;

class PaymentGatewayCreateTest extends TestCase
{

    private $config = array();

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->config = new LoadConfig();
    }

    public function dataSet()
    {
        return $dataSet = array(
            // Test invalid api key
            array(
                'apiUrl' => $this->config->API_URL,
                'apiKey' => 'apikey', //The parameter is being tested
                'mobile' => $this->config->MOBILE,
                'orderId' => '4988849849',
                'price' => '54166',
                'description' => 'test order',
                'isAssertion' => false,
                'test' => 'Test invalid api key'
            ),
            //Test invalid mobile
            array(
                'apiUrl' => $this->config->API_URL,
                'apiKey' => $this->config->API_KEY,
                'mobile' => '09100000', //The parameter is being tested
                'orderId' => '4988849849',
                'price' => '54166',
                'description' => 'test order',
                'isAssertion' => false,
                'test' => 'Test invalid mobile'
            ),
            //Test invalid api url
            array(
                'apiUrl' => 'http://localhost', //The parameter is being tested
                'apiKey' => $this->config->API_KEY,
                'mobile' => '09100000',
                'orderId' => '4988849849',
                'price' => '54166',
                'description' => 'test order',
                'isAssertion' => false,
                'test' => 'Test invalid api url'
            ),
            //Test $orderId parameter with more than 50 character
            array(
                'apiUrl' => 'http://localhost', //The parameter is being tested
                'apiKey' => $this->config->API_KEY,
                'mobile' => '09100000',
                'orderId' => '21245154843156463135468435165434654456468434684664681',
                'price' => '54166',
                'description' => 'test order',
                'isAssertion' => false,
                'test' => 'Test $orderId parameter with more than 50 character'
            ),
            //Test $price parameter with more than 20 character
            array(
                'apiUrl' => 'http://localhost', //The parameter is being tested
                'apiKey' => $this->config->API_KEY,
                'mobile' => '09100000',
                'orderId' => '21245154',
                'price' => '12545658754125485321554',
                'description' => 'test order',
                'isAssertion' => false,
                'test' => 'Test $orderId parameter with more than 20 character'
            ),
            //Test $description parameter with more than 255 character
            array(
                'apiUrl' => 'http://localhost', //The parameter is being tested
                'apiKey' => $this->config->API_KEY,
                'mobile' => '09100000',
                'orderId' => '21245154',
                'price' => '12545658754125485321554',
                'description' => 'test order,test ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest ordertest order',
                'isAssertion' => false,
                'test' => 'Test $description parameter with more than 255 character'
            ),
            //Test create invoice
            array(
                'apiUrl' => $this->config->API_URL,
                'apiKey' => $this->config->API_KEY,
                'mobile' => $this->config->MOBILE,
                'orderId' => (string)rand(),
                'price' => '54166',
                'description' => 'test order',
                'isAssertion' => true,
                'test' => 'Test create invoice'
            )
        );
    }

    /**
     * Test the class constructor
     * Create class with correct data
     * If create without error pass the test
     */
    public function testCreateMethod()
    {
        echo "\n//////////////////////////////////";
        echo "\n/// Test Create Method";
        foreach (self::dataSet() as $key => $data) {
            try {
                $payment = new PaymentGateway(
                    $data['apiUrl'],
                    $data['apiKey'],
                    $data['mobile']
                );

                $result = $payment->create($data['orderId'], $data['price'], $data['description']);

                echo "\n" . $key . ' : ' . $data['test'];
                $this->assertTrue(!empty($result) == $data['isAssertion']);

            } catch (\Exception $e) {
                if ($data['isAssertion'])
                    $this->assertTrue(false, 'dataSet number ' . $key . ' is not passed,' . $e->getMessage());
                else {
                    echo "\n" . $key . ' : ' . $data['test'];
                    $this->assertTrue(true);
                }
            }

        }
    }
}