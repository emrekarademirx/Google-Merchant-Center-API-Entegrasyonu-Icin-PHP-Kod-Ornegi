<?php

require_once 'config.php';
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->refreshToken(REFRESH_TOKEN);

$service = new Google_Service_ShoppingContent($client);
$products = $service->products->listProducts(MERCHANT_ID, [
  'country' => COUNTRY_CODE
]);

echo json_encode($products->toSimpleObject());

?>
