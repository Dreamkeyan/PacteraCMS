<?php

namespace Mall\Service;

/**
 * Class NoticeService
 * @package Mall\Service
 */
class ShopService
{

    /**
     * Trans the shop list tabs
     *
     * @param integer $shop_id
     * @param array   $shops
     *
     * @return array
     */
    public static function transTabs($shop_id, array $shops)
    {
        $data = array_filter($shops, function ($item) use ($shop_id) {
            return ($item['id'] != $shop_id) ? true : false;
        });
        $key = array_search($shop_id, array_column($shops, 'id'));
        array_unshift($data, $shops[$key]);

        return $data;
    }

}
