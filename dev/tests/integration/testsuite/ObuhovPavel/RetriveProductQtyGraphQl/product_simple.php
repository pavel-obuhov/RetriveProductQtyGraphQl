<?php
use Magento\Catalog\Model\ProductFactory;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;

$productFactory = Bootstrap::getObjectManager()->get(ProductFactory::class);
$product = $productFactory->create();
$product->setTypeId(\Magento\Catalog\Model\Product\Type::DEFAULT_TYPE)
    ->setId(20)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Test Product Simple')
    ->setSku('simpel-product')
    ->setPrice(10)
    ->setTaxClassId(0)
    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    ->setStockData(
        [
            'qty' => 120,
            'is_in_stock' => 1,
            'manage_stock' => 1,
        ]
    );
/** @var ProductResource $productResource */
$productResource = Bootstrap::getObjectManager()->create(ProductResource::class);
$productResource->save($product);
