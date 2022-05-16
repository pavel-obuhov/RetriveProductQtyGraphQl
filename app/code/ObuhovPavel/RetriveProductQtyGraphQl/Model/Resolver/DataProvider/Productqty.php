<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace ObuhovPavel\RetriveProductQtyGraphQl\Model\Resolver\DataProvider;

use Magento\InventorySalesApi\Api\GetProductSalableQtyInterface;

class Productqty
{
    /**
     * @var GetProductSalableQtyInterface
     */
    private GetProductSalableQtyInterface $getProductSalableQty;

    public function __construct(
        GetProductSalableQtyInterface $getProductSalableQty
    )
    {
        $this->getProductSalableQty = $getProductSalableQty;
    }

    /**
     * @param string $sku
     * @param int $store
     * @return float
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductqty(string $sku, int $store) : float
    {
        return $this->getProductSalableQty->execute($sku, $store);
    }
}

