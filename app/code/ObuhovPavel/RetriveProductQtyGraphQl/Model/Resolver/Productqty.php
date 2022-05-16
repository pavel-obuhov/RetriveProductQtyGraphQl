<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace ObuhovPavel\RetriveProductQtyGraphQl\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class Productqty implements ResolverInterface
{

    private $productqtyDataProvider;

    /**
     * @param DataProvider\Productqty $productqtyDataProvider
     */
    public function __construct(
        DataProvider\Productqty $productqtyDataProvider
    ) {
        $this->productqtyDataProvider = $productqtyDataProvider;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (empty($args['sku'])) {
            throw new GraphQlInputException(__('Required parameter "sku" is missing'));
        }

        if (empty($args['store'])) {
            throw new GraphQlInputException(__('Required parameter "store" is missing'));
        }

        try{
            $qty =  $this->productqtyDataProvider->getProductqty($args['sku'], $args['store']);
            return ['qty' => $qty];
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        } catch (LocalizedException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()));
        }
    }
}

