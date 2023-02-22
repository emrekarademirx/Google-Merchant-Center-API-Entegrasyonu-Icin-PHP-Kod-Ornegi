<?php

require_once 'config.php';
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->refreshToken(REFRESH_TOKEN);

$service = new Google_Service_ShoppingContent($client);
$product = $service->products->get(MERCHANT_ID, 'productId', [
  'country' => COUNTRY_CODE
]);

$product->setAvailability('out of stock');
$update = $service->products->update(MERCHANT_ID, 'productId', $product);

echo json_encode($update->toSimpleObject());

?>
