<?php

/*
  Include file with:
  - Consumer Key
  - Consumer Secret
  - BusinessShortCode
  - Timestamp
  - PartyA
  - CallBackURL
*/
include_once 'credentials.php';

  $headers = ['Content-Type: application/json; charset=utf8'];

  $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);

  $result = curl_exec($curl);
  // $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $result = json_decode($result);
  $access_token = $result->access_token;

  curl_close($curl);

  // Initiating the transaction

  
  $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

  //Collect amount and phone number from form
  $Amount = '1';
  $phoneNumber = '07xxx'; //to run the program successfully, use actual phone number
  $AccountReference = 'MPESAExpress Integration';
  $TransactionDesc = 'MPESAExpress Integration';

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $initiate_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $partyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $phoneNumber,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
  print_r($curl_response);
  
  echo $curl_response;
  ?>