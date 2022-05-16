<?php

namespace ObuhovPavel\RetriveProductQtyGraphQl;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\GraphQlAbstract;

class ProductQtyTest  extends GraphQlAbstract
{
    /**
     * @var mixed
     */
    private $productRepository;

    protected function setUp(): void
    {
        $objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $objectManager->get(ProductRepositoryInterface::class);
    }

    /**
     * @param String $sku
     * @param int $storeId
     * @return string
     */
    private function getProductQtyQuery(String $sku, int $storeId): string
    {
        return <<<QUERY
{
  productqty(sku:"$sku", store:$storeId) {
  	qty
	}
}
QUERY;
    }

    /**
     * @magentoApiDataFixture ObuhovPavel/RetriveProductQtyGraphQl/product_simple.php
     *
     */
    public function testGetProductQty()
    {
        $sku = 'simpel-product';
        $storeId = 1;
        $newQty = rand(1, 200);

        $query = $this->getProductQtyQuery($sku, $storeId);
        $response = $this->graphQlQuery($query);

        $this->assertArrayNotHasKey('errors', $response);
        $this->assertEquals(120, $response['productqty']['qty']);

        $this->populate($sku, $newQty, $storeId);

        $query = $this->getProductQtyQuery($sku, $storeId);
        $response = $this->graphQlQuery($query);

        $this->assertArrayNotHasKey('errors', $response);
        $this->assertEquals($newQty, $response['productqty']['qty']);
    }

    private function populate(string $sku, float $qty, $storeId=1)
    {
        /** @var ProductInterface $product */
        $product = $this->productRepository->get($sku, false, $storeId, true);
        $stockItem = $product->getExtensionAttributes()->getStockItem();

        $stockItem->setQty($qty)->save();
    }
}
