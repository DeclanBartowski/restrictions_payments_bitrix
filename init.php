<?php


Bitrix\Main\EventManager::getInstance()->addEventHandler(
    'sale',
    'onSalePaySystemRestrictionsClassNamesBuildList',
    'restaurantRestriction'
);

function restaurantRestriction()
{
    return new \Bitrix\Main\EventResult(
        \Bitrix\Main\EventResult::SUCCESS,
        array(
            '\restaurantRestriction' => '/local/php_interface/include/restrictions/restaurantRestriction.php',
        )
    );
}
