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

/**
 * Class PaymentGatewayTest
 *
 * @package Test
 */
class PaymentGatewayConstructorTest extends TestCase
{

    private $dataSet = array(
        //test constructor with correct data
        array(
            'apiUrl' => 'http://api.com',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test constructor with correct data',
        ),
        /////////////////////////////////////////////////
        /// Test $apiKey value

        // Test $apiUrl parameter with null value
        array(
            'apiUrl' => null, //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter with null value',
        ),
        // Test $apiUrl parameter length more than 512 character
        array(
            'apiUrl' => 'https://www.api.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functions.com%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu&sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHc47DAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functions.com%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu&sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHc47DAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functionscom%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu', //The parameter is being tested,
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter length more than 512 character',
        ),
        // Test $apiUrl parameter with incorrect protocol
        array(
            'apiUrl' => 'httpq://api.com', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter with incorrect protocol'
        ),
        // Test $apiUrl parameter  without protocol
        array(
            'apiUrl' => 'api.com', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter without protocol'
        ),
        // Test $apiUrl parameter with port
        array(
            'apiUrl' => 'https://api.com:8080', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $apiUrl parameter with port'
        ),
        // Test $apiUrl parameter with Ip
        array(
            'apiUrl' => 'https://80.80.80.80', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $apiUrl parameter with Ip'
        ),
        // Test $apiUrl parameter with Ip and port
        array(
            'apiUrl' => 'https://80.80.80.80:8054', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $apiUrl parameter with Ip and port'
        ),
        ///////////////////////////////////////////////
        /// Test $apiKey
        ///
        // Test $apiKey parameter with null value
        array(
            'apiUrl' => 'https://api.url',
            'apiKey' => null, //The parameter is being tested
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiKey parameter with null value'
        ),
        // Test $apiKey parameter with other type of value
        array(
            'apiUrl' => 'https://api.url',
            'apiKey' => 13165465, //The parameter is being tested
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiKey parameter with other type of value'
        ),
        // Test $apiKey parameter with more than 100 character
        array(
            'apiUrl' => 'https://api.url',
            'apiKey' => 'B8B8$%%^93905A34$98B3FB82@!kF8BF37ED&&&4AB8939;0@5B822U%#BB93^8B3#0CWE45FEE5EQ^$*DFG%$!6GHJ6ES646544545640', //The parameter is being tested
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiKey parameter with more than 100 character'
        ),
        ///////////////////////////////////////////////
        /// Test $mobile
        ///
        // Test $mobile parameter with null value
        array(
            'apiUrl' => 'https://api.url',
            'apiKey' => 'api key',
            'mobile' => null, //The parameter is being tested
            'isAssertion' => false,
            'test'=>'Test $mobile parameter with null value'
        ),
        // Test $mobile parameter with other type of value
        array(
            'apiUrl' => 'https://api.url',
            'apiKey' => 'api key',
            'mobile' => 13165465, //The parameter is being tested
            'isAssertion' => false,
            'test'=>'Test $mobile parameter with other type of value'
        ),
        // Test $mobile parameter with more than 15 character
        array(
            'apiUrl' => 'https://api.url',
            'apiKey' => 'api key',
            'mobile' => '0910000005689574', //The parameter is being tested
            'isAssertion' => false,
            'test'=>'Test $mobile parameter with more than 15 character'
        ),
    );

    /**
     * Test the class constructor with dataSet
     */
    public function testConstructor()
    {
        echo "\n//////////////////////////////////";
        echo "\n/// Test Constructor Method";
        foreach ($this->dataSet as $key => $data) {
            echo "\n".$key.' : '.$data['test'];
            try {
                new PaymentGateway(
                    $data['apiUrl'],
                    $data['apiKey'],
                    $data['mobile']
                );
            } catch (\Exception $e) {
                $this->assertEquals($data['isAssertion'], false, 'Error:dataSet number ' . $key . ' is not passed'.
            "\nTest:".$data['test']);
            }
        }
        $this->assertTrue(true);
    }

}