<?php
$url = 'https://github.com/login/oauth/access_token';
$clientId = $_ENV["CLIENT_ID"];
$clientSecret = $_ENV["CLIENT_SECRET"];

$postsFields = new \stdClass();
$postsFields->client_id = $clientId;
$postsFields->client_secret = $clientSecret;
$postsFields->code = $_GET['code'];

$headers = array(
  'Content-Type: application/json; charset=utf-8',
  'Accept: application/json'
);

try {
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postsFields));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //curl_setopt($ch, CURLOPT_NOBODY, 1);

  $response = json_decode(curl_exec($ch));
  $error = curl_error($ch);

  curl_close($ch);
  header("Location: https://" . $_SERVER['HTTP_HOST'] . "/#/checkToken/" . $response->access_token);
  // header("Location: http://localhost:4200/#/checkToken/" . $response->access_token);
} catch (\Exception $ex) {
  return [];
}
