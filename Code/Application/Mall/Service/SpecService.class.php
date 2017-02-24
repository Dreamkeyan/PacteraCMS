<?php

namespace Mall\Service;

/**
 * Class NoticeService
 * @package Mall\Service
 */
class SpecService
{

    /**
     * @var
     */
    private $specitems;

    /**
     * @var
     */
    private $groupdata;

    /**
     * @var
     */
    private $rownum;

    /**
     * @var array
     */
    private $extraCol = array(
        'price' => '价格',
        'inventory' => '库存',
        'barcode' => '条码'
    );

    /**
     * SpecService constructor.
     *
     * @param $specitems
     */
    public function __construct($specitems)
    {
        $this->specitems = $specitems;
        $this->groupdata = $this->_getGroupdata();
        $this->rownum = $this->_getRownum();
    }

    /**
     * get table thead
     *
     * @return array
     */
    public function getThead()
    {
        $result = array();
        foreach ($this->groupdata as $item) {
            $result[] = array(
                'spec_id' => $item['spec_id'],
                'spec_name' => $item['spec_name'],
            );
        }

        return array_merge($result, $this->extraCol);
    }

    /**
     * get table tbody
     *
     * @return array
     */
    public function getTbody()
    {
        $result = array();
        for ($i = 0; $i < $this->rownum; $i++) {
            $mul = 1;
            foreach ($this->groupdata as $item) {
                if (end($this->groupdata) === $item) {
                    $key = $i % $item['length'];
                    $result[$i][] = $item[$key];
                } else {
                    $mul = $mul * $item['length'];
                    $dividend = $this->rownum / $mul;
                    $offset = $dividend * $item['length'];
                    if ($i < $offset) {
                        $divisor = $i;
                    } else {
                        $double = floor($i / $offset);
                        $divisor = $i - ($double * $offset);
                    }
                    $key = floor($divisor / $dividend);
                    $result[$i][] = $item[$key];
                }
            }
        }

        return $this->_appendExtraCol($result);
    }

    /**
     * this append the extra column
     *
     * @param array $result
     *
     * @return array
     */
    private function _appendExtraCol(array $result)
    {
        $data = array();
        foreach ($result as $item) {
            $speckey = implode('_', $this->_getSpeckey($item));
            $speckeyname = implode(' ', $this->_getSpeckeyName($item));
            $colName = $this->_getColName($item);
            $extraCol = $this->_getExtraCol($speckey, $speckeyname);
            $data[] = array_merge($colName, $extraCol);
        }

        return $data;
    }

    /**
     * get column name
     *
     * @param array $specs
     *
     * @return array
     */
    private function _getColName(array $specs)
    {
        return array_map(function ($item) {
            return $item['item'];
        }, $specs);
    }

    /**
     * get the extra column
     *
     * @param $speckey
     * @param $speckeyname
     *
     * @return array
     */
    private function _getExtraCol($speckey, $speckeyname)
    {
        $cols = array();
        foreach ($this->extraCol as $key => $val) {
            $cols[$key] = array(
                'key' => $speckey,
                'key_name' => $speckeyname
            );
        }

        return $cols;
    }

    /**
     * get spec key name comb
     *
     * @param array $specs
     *
     * @return array
     */
    private function _getSpeckeyName(array $specs)
    {
        return array_map(function ($item) {
            return $item['spec_name'] . '：' . $item['item'];
        }, $specs);
    }

    /**
     * get spec id comb
     *
     * @param array $specs
     *
     * @return array
     */
    private function _getSpeckey(array $specs)
    {
        $keys = array_map(function ($item) {
            return $item['id'];
        }, $specs);
        natsort($keys);
        return $keys;
    }

    /**
     * get row num
     *
     * @return string
     */
    private function _getRownum()
    {
        $lengths = array_column($this->groupdata, 'length');
        $nums = '';
        foreach ($lengths as $length) {
            if ($nums) {
                $nums = $nums * $length;
            } else {
                $nums = $length;
            }
        }
        return $nums;
    }

    /**
     * get group data
     *
     * @return array
     */
    private function _getGroupdata()
    {
        $data = array();
        foreach ($this->specitems as $item) {
            $data[$item['spec_id']][] = $item;
        }
        $data = array_map(function ($item) {
            $item['length'] = count($item);
            $item['spec_name'] = $item[0]['spec_name'];
            $item['spec_id'] = $item[0]['spec_id'];
            return $item;
        }, $data);

        return $this->_arrayOrder($data, 'length', SORT_ASC);
    }

    /**
     * More weft array sort
     *
     * @return array
     */
    private function _arrayOrder()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

}
