<?php

require_once __DIR__ . '/vendor/autoload.php';

use Google\AdsApi\AdWords\AdWordsServices;
use Google\AdsApi\AdWords\v201809\cm\Product;
use Google\AdsApi\AdWords\v201809\cm\ProductCanonicalCondition;
use Google\AdsApi\AdWords\v201809\cm\ProductCanonicalConditionCondition;
use Google\AdsApi\AdWords\v201809\cm\ProductDimensionType;
use Google\AdsApi\AdWords\v201809\cm\ProductPartitionType;
use Google\AdsApi\AdWords\v201809\cm\ProductType;
use Google\AdsApi\AdWords\v201809\cm\ProductTypeFull;

/**
 * Inserts a product item for a shopping campaign.
 */
function insertProductItem(
    AdWordsServices $adWordsServices,
    int $merchantId,
    int $productId,
    string $title,
    string $description,
    string $brand,
    string $productType,
    string $googleProductCategory,
    int $priceMicros,
    string $priceCurrencyCode,
    string $imageUrl,
    string $finalUrl,
    string $itemGroupId,
    array $customAttributes
) {
    $product = new Product();
    $product->setId($productId);
    $product->setTitle($title);
    $product->setDescription($description);
    $product->setBrand($brand);

    $productType = new ProductType();
    $productType->setValue($productType);
    $product->setProductType($productType);

    $googleProductCategory = new ProductType();
    $googleProductCategory->setValue($googleProductCategory);
    $product->setGoogleProductCategory($googleProductCategory);

    $price = new Money();
    $price->setMicroAmount($priceMicros);
    $price->setCurrencyCode($priceCurrencyCode);
    $product->setPrice($price);

    $image = new ProductImage();
    $image->setUrl($imageUrl);
    $product->setImages([$image]);

    $product->setCanonicalCondition(new ProductCanonicalCondition([
        'condition' => new ProductCanonicalConditionCondition([
            'type' => ProductCanonicalConditionConditionType::NEW_PRODUCT
        ])
    ]));

    $product->setProductTypeFull(new ProductTypeFull([
        'value' => $productType,
        'delimiter' => '>',
        'type' => ProductPartitionType::SUBDIVISION
    ]));

    $customAttributes = array_map(function($customAttribute) {
        $productDimension = new ProductDimension();
        $productDimension->setType($customAttribute['type']);
        $productDimension->setValue($customAttribute['value']);
        return $productDimension;
    }, $customAttributes);

    $product->setCustomAttributes($customAttributes);

    $finalUrl = new ProductCanonicalizedUrl();
    $finalUrl->setValue($finalUrl);
    $product->set
