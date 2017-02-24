<?php

namespace Common\Model;

/**
 * Description of PacteraSystemSmsModel
 *
 * @author Wang Rong 王荣 <rong.wang4@pactera.com>
 * @version 0.0.0.1
 * @datetime 2016-9-18  16:42:05
 */
class SystemSmsModel extends CommonModel
{

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
    );

}
