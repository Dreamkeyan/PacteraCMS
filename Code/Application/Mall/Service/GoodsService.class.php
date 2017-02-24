<?php

namespace Mall\Service;

/**
 * Class NoticeService
 * @package Mall\Service
 */
class GoodsService
{

    /**
     * get category ids
     *
     * @param $cates
     * @param $cat3id
     *
     * @return array
     */
    public static function getCategoryIds($cates, $cat3id)
    {
        $filters = array_filter($cates, function ($item) use ($cat3id) {
            return $item['id'] == $cat3id ? true : false;
        });
        $cat3 = array_pop($filters);
        $cat2id = $cat3['pid'];
        $result = array();
        foreach ($cates as $item) {
            if ($item['id'] == $cat2id) {
                $result[] = $item['pid'];
                $result[] = $cat2id;
                $result[] = $cat3id;
            }
        }

        return $result;
    }

    /**
     * get form date options
     *
     * @return array
     */
    public static function formOptions()
    {
        return array(
            'types' => D('GoodsType')->getOptions(),
            'shops' => D('Shop')->getOptions(),
            'cates' => D('Category')->getOptions(),
            'brand' => D('Brand')->getOptions()
        );
    }

    /**
     * clear the image attr specs
     *
     * @param $gid
     */
    public static function clearAll($gid)
    {
        D('GoodsImage')->where(array('goods_id' => $gid))->delete();
        D('GoodsAttr')->where(array('goods_id' => $gid))->delete();
        D('GoodsSpecPrice')->where(array('goods_id' => $gid))->delete();
    }

    /**
     * save the images
     *
     * @param       $gid
     * @param array $data
     */
    public static function saveImages($gid, array $data)
    {
        $images = array_map(function ($item) use ($gid) {
            $item['goods_id'] = $gid;
            $item['create_time'] = NOW_TIME;
            $item['status'] = 1;
            return $item;
        }, $data);
        D('GoodsImage')->addAll($images);
    }

    /**
     * save the attrs
     *
     * @param       $gid
     * @param array $data
     */
    public static function saveAttrs($gid, array $data)
    {
        $attrs = array_map(function ($item) use ($gid) {
            $item['goods_id'] = $gid;
            $item['create_time'] = NOW_TIME;
            return $item;
        }, $data);
        D('GoodsAttr')->addAll($attrs);
    }

    /**
     * save the specs
     *
     * @param       $gid
     * @param array $data
     */
    public static function saveSpecs($gid, array $data)
    {
        $specs = array_map(function ($item) use ($gid) {
            $keyarr = explode('_', $item['key']);
            $item['key'] = implode(',', $keyarr);
            $item['goods_id'] = $gid;
            $item['create_time'] = NOW_TIME;
            return $item;
        }, $data);
        D('GoodsSpecPrice')->addAll($specs);
    }

}
