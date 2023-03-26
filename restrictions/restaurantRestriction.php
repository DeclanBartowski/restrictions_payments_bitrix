<?php

use Bitrix\Sale\Delivery\Restrictions;
use Bitrix\Sale\Internals\Entity;

class restaurantRestriction extends Restrictions\Base
{
    public static function getClassTitle()
    {
        return 'по ресторану';
    }

    public static function getClassDescription()
    {
        return 'Платежная система будет выводится только для указанных ресторанов';
    }

    public static function check($restId, array $restrictionParams, $paymentId = 0)
    {
        if (!$restrictionParams['RESTAURANTS'] || !$restId) {
            return false;
        }
        return in_array($restId, $restrictionParams['RESTAURANTS']);
    }

    protected static function extractParams(Entity $payment)
    {
        $restId = 0;
        foreach ($payment->getCollection()->getOrder()->getBasket()->getBasketItems() as $item) {
            if ($restId = TMDostavka::getRestXmlIdByProduct($item->getField('PRODUCT_ID'))) {
                break;
            }
        }


        return $restId;
    }

    public static function getParamsStructure($entityId = 0)
    {
        $arOptions = [];
        $arRestaurants = TMDostavka::getRests();
        foreach ($arRestaurants as $arRestaurant) {
            $arOptions[$arRestaurant['UF_XML_ID']] = sprintf('%s [%s]', $arRestaurant['UF_NAME'],
                $arRestaurant['UF_XML_ID']);
        }

        return array(
            "RESTAURANTS" => array(
                'TYPE' => 'ENUM',
                'MULTIPLE' => 'Y',
                'OPTIONS' => $arOptions,
                'LABEL' => 'Рестораны'
            ),
        );
    }
}
