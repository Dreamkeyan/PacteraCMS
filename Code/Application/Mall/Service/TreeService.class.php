<?php

namespace Mall\Service;

/**
 * Class TreeService
 * @package Mall\Service
 */
class TreeService
{

    /**
     * @var array
     */
    private $data = array();

    /**
     * @var array
     */
    private $tree = array();

    /**
     * constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * get the tree data
     *
     * @return array
     */
    public function getTreeData()
    {
        foreach ($this->data as $item) {
            if (isset($this->data[$item['pid']])) {
                $this->data[$item['pid']]['nodes'][] = &$this->data[$item['id']];
            } else {
                $this->tree[] = &$this->data[$item['id']];
            }
        }

        return $this->tree;
    }

}
