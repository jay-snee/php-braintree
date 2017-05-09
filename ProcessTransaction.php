<?php

	require_once('./lib/Braintree.php');
	
	Braintree_Configuration::environment('sandbox');
	Braintree_Configuration::merchantId('83cr4qfg7cpdm32v');
	Braintree_Configuration::publicKey('hfmqcdgkrxxb4b6w');
	Braintree_Configuration::privateKey('9a58840d9a2f377d3ce31557dbbedc87');
	
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	    
    $customerInformation = Array(
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        //'company' => '',
        'email' =>$_POST['email'],
        'phone' => $_POST['phone'],
        //'fax' => '',
        'website' =>$_POST['website']
    );
    
    $billingInfo = Array(
      
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        //'company' => 'Braintree',
        'streetAddress' => $_POST['streetAddress'],
        //'extendedAddress' => 'Suite 403',
        'locality' => $_POST['locality'],
        'region' => $_POST['region'],
        'postalCode' => $_POST['postalCode'],
        'countryCodeAlpha2' => 'GB'

    );
    
    $options = Array(
        'submitForSettlement' => true,
            'threeDSecure' => [
                'required' => true
                ]
    );
    
    $transactionDetails = Array(
        'amount' => $_POST['amount'],
        //'orderId' => '',
        //'merchantAccountId' => '',
        'paymentMethodNonce' => $_POST['nonce'],
        'customer' => $customerInformation,
        'billing' => $billingInfo,
        'shipping' => $billingInfo,
        'options' => $options    
    );           
                    
    $result = Braintree_Transaction::sale($transactionDetails);
    
    if ($result->transaction->gatewayRejectionReason == Braintree_Transaction::THREE_D_SECURE) {
    {
        echo "3DSecure failed.<br>";
    }
  // Ask for a new payment method
}
 	 echo "<pre>";
 	 print_r($result);
 	 echo "</pre>";
?>