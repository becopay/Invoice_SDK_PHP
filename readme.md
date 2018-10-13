## Becopay Payment Gateway

This is php library for becopay payment gateway

"php": ">=5.3.0"
### Installing
Pull this package via Composer.
```json
    {
        "require": {
            "becopay/php-payment-gateway": "0.*"
        }
    }
```

or run in terminal: ```composer require becopay/php-payment-gateway```


### Usage

**Create Class**<br>
First use the library with this namespace `use Becopay\PaymentGateway;`.<br>
for getting the constructor parameters, you first need to register on becopay website([register now](https://becopay.com/en/io/#api))<br>
If invalid data type class is entered throw an exception.
```php
use Becopay\PaymentGateway;

try {
    $payment = new PaymentGateway(
        'api service url',
        'gateway url',
        'api key',
        'mobile'
    );
} catch (Exception $e) {
	//Add yours exception handling
    echo $e->getMessage();
}
```
**Create payment redirect url**<br>
For creating the payment gateway url, use `create()` method.<br>
Type of parameter value must be string.<br>
If invalid data type class is entered throw an exception.
If response is successful it will return object and if not, it will return false<br>
`$payment->error` return the error message
```php
try {
    /*
     * This function is used to create an invoice.
     * Return result data type is object
     */ 
    $invoice = $payment->create('order id','price','descriptiom');
    if($invoice)
    {
        /*
        * Save invoice id in your database 
        * For checking the invoice status you need invoice id
        * Then redirect user to gateway url for doing the payment process
        */
       
		//echo the result
  		echo json_encode($invoice);

        //Get invoice id and insert to database
        /*
        	$invoiceId = $invoice->id;
       		echo 'invoice id:'.$invoiceId.'<br>';
        */

        //Get redirect url
        /*
        	$redirectUrl = $invoice->redirectUrl;
        	echo 'redirect url'.$invoiceId.'<br>';
        */
    }else{
    	//Add your error handling
    	echo $payment->error;
    }
} catch (Exception $e) {
	//Add your exception handling
    echo $e->getMessage();
}
```
Response
```json
{
    "id": "POS_29_61a5",
    "shopName": "New Shop",
    "status": "waiting",
    "remaining": 40,
    "symbol": "IRR",
    "price": 15000,
    "date": "2018-10-13 06:45:36",
    "timestamp": 1539413136148,
    "description": "test payment",
    "gatewayUrl": "https://gateway.becopay.com/invoice/POS_29_61a5",
    "callback": "http://www.your-website.com/invoice?orderid=12324320",
    "orderId": "12324320"
}
```

**Check**<br>
For checking the invoice status you can use `check()` method.<br>
If invalid data type is entered, throw an execption<br>
If response is successful it will return object and if not, it will return false<br>
`$payment->error` return the error message
```php
      /*
       * Use this function to check the invoice status.
       * This function gets invoice id (which has been created by `create()` function) as parameter
       * and returns status of that
       */
try {
      /*
       * Get invoice id 
       * This function is used on your callback function,
       * so for using your invoice id, you must have saved invoice id
       * while creating the invoice
       */
      $invoiceId = $invoice->id; // this code is for test. you must get invoice id form 


      $invoiceStatus = $payment->check($invoice->id);
      
      if($invoiceStatus)
      {
      	/*
         * Insert your code here for updating order status
         */
      
		//echo the result
      	echo json_encode($invoiceStatus);
        
        
      }else{
        //Add your error handling
        echo $payment->error;
      } 
} catch (Exception $e) {
	//Add your exception handling
    echo $e->getMessage();
}
```
Response
```json
{
    "id": "POS_29_61a5",
    "shopName": "New Shop",
    "status": "waiting",
    "remaining": 40,
    "symbol": "IRR",
    "price": 15000,
    "date": "2018-10-13 06:45:36",
    "timestamp": 1539413136148,
    "description": "test payment",
    "gatewayUrl": "https://gateway.becopay.com/invoice/POS_29_61a5",
    "callback": "http://www.your-website.com/invoice?orderid=12324320",
    "orderId": "12324320"
}
```

### License

This package is open-source software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Contact
For any questions, bugs, suggestions or feature requests, please use the Github issue system or submit a pull request.
When submitting an issue, always provide a detailed explanation of your problem with any response or feedback you get. Log those messages that might be relevant or a code example that demonstrates the problem. If none of this is available, we will most likely not be able to help you with your problem. Please review the contribution guidelines before submitting your issue or pull request.

For any other question, feel free to use the credentials listed below:

- Email: io@becopay.com
