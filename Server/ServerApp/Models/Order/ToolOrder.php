<?php
/********************************************************************************************
 *             Copy Right (c) 2022 Capsheaf Co., Ltd.
 *
 *  Author:          Archibald<yangjunjie@capsheaf.com.cn>
 *  Date:            2022-05-12 09:50:26 CST
 *  Description:     ToolOrder.php's function description
 *  Version:         1.0.0.20220512-alpha
 *  History:
 *        Archibald<yangjunjie@capsheaf.com.cn> 2022-05-12 09:50:26 CST initialized the file
 *******************************************************************************************/
namespace ServerApp\Models\Order;

use Capsheaf\Utils\Types\Json;
use ServerApp\Models\BaseModel;
use DateTime;

class ToolOrder extends BaseModel
{
    protected $m_sTable     = 'tool_order';

    public function createOrder($arrKVPair)
    {
        if (!isset($arrKVPair['created_at'])){
            $arrKVPair['created_at'] = new DateTime();
        }

        return $this->M()
            ->insert($arrKVPair);
    }
}