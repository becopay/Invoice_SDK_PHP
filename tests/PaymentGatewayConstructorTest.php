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
            'gatewayUrl' => 'http://gatwayurl',
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
            'gatewayUrl' => 'http://gatwayurl',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter with null value',
        ),
        // Test $apiUrl parameter length more than 512 character
        array(
            'apiUrl' => 'https://www.api.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functions.com%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu&sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHc47DAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functions.com%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu&sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHc47DAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functionscom%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu', //The parameter is being tested
            'gatewayUrl' => 'http://gatway.url',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter length more than 512 character',
        ),
        // Test $apiUrl parameter with incorrect protocol
        array(
            'apiUrl' => 'httpq://api.com', //The parameter is being tested
            'gatewayUrl' => 'http://gatway.url',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter with incorrect protocol'
        ),
        // Test $apiUrl parameter  without protocol
        array(
            'apiUrl' => 'api.com', //The parameter is being tested
            'gatewayUrl' => 'http://gatway.url',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter without protocol'
        ),
        // Test $apiUrl parameter with port
        array(
            'apiUrl' => 'https://api.com:8080', //The parameter is being tested
            'gatewayUrl' => 'https://gateway.url',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiUrl parameter with port'
        ),
        // Test $apiUrl parameter with Ip
        array(
            'apiUrl' => 'https://80.80.80.80', //The parameter is being tested
            'gatewayUrl' => 'https://gateway.url',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $apiUrl parameter with Ip'
        ),
        // Test $apiUrl parameter with Ip and port
        array(
            'apiUrl' => 'https://80.80.80.80:8054', //The parameter is being tested
            'gatewayUrl' => 'https://api.com:8080',
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $apiUrl parameter with Ip and port'
        ),
        ////////////////////////////////////////////
        /// Test $gatewayUrl value
        // Test $gatewayUrl parameter with null value
        array(
            'apiUrl' => 'http://api.url',
            'gatewayUrl' => null, //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $gatewayUrl parameter with null value',
        ),
        // Test $gatewayUrl parameter length more than 512 character
        array(
            'apiUrl' => 'http://api.url',
            'gatewayUrl' => 'https://www.api.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functions.com%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu&sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHc47DAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functions.com%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu&sa=t&rct=j&q=&esrc=s&source=web&cd=1&ved=2ahUKEwi56MDUi_zdAhUGiSwKHc47DAwQFjAAegQICRAB&url=http%3A%2F%2Fstring-functionscom%2Flength.aspx&usg=AOvVaw1utca5OnUZuOIkPiOsOGnu', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $gatewayUrl parameter length more than 512 character',
        ),
        // Test $gatewayUrl parameter with incorrect protocol
        array(
            'apiUrl' => 'http://api.url',
            'gatewayUrl' => 'httpq://gateway.com', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $gatewayUrl parameter with incorrect protocol'
        ),
        // Test $gatewayUrl parameter  without protocol
        array(
            'apiUrl' => 'http://api.url',
            'gatewayUrl' => 'gateway.url', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $gatewayUrl parameter without protocol'
        ),
        // Test $gatewayUrl parameter with port
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://api.com:8080', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $gatewayUrl parameter with port'
        ),
        // Test $gatewayUrl parameter with Ip
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://80.80.80.80', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $gatewayUrl parameter with Ip'
        ),
        // Test $gatewayUrl parameter with Ip and port
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://80.80.80.80:8054', //The parameter is being tested
            'apiKey' => 'apikey',
            'mobile' => '09100000000',
            'isAssertion' => true,
            'test'=>'Test $gatewayUrl parameter with Ip and port'
        ),
        ///////////////////////////////////////////////
        /// Test $apiKey
        ///
        // Test $apiKey parameter with null value
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://gateway.url',
            'apiKey' => null, //The parameter is being tested
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiKey parameter with null value'
        ),
        // Test $apiKey parameter with other type of value
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://gateway.url',
            'apiKey' => 13165465, //The parameter is being tested
            'mobile' => '09100000000',
            'isAssertion' => false,
            'test'=>'Test $apiKey parameter with other type of value'
        ),
        ///////////////////////////////////////////////
        /// Test $mobile
        ///
        // Test $apiKey parameter with null value
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://gateway.url',
            'apiKey' => 'api key',
            'mobile' => null, //The parameter is being tested
            'isAssertion' => false,
            'test'=>'Test $mobile parameter with null value'
        ),
        // Test $mobile parameter with other type of value
        array(
            'apiUrl' => 'https://api.url',
            'gatewayUrl' => 'https://gateway.url',
            'apiKey' => 'api key',
            'mobile' => 13165465, //The parameter is being tested
            'isAssertion' => false,
            'test'=>'Test $mobile parameter with other type of value'
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
                    $data['gatewayUrl'],
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