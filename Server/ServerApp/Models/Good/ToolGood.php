<?php
/********************************************************************************************
 *             Copy Right (c) 2022 Capsheaf Co., Ltd.
 *
 *  Author:          Archibald<yangjunjie@capsheaf.com.cn>
 *  Date:            2022-05-11 15:33:20 CST
 *  Description:     ToolGood.php's function description
 *  Version:         1.0.0.20220511-alpha
 *  History:
 *        Archibald<yangjunjie@capsheaf.com.cn> 2022-05-11 15:33:20 CST initialized the file
 *******************************************************************************************/
namespace ServerApp\Models\Good;

use Capsheaf\Utils\Types\Json;
use ServerApp\Models\BaseModel;
use DateTime;

class ToolGood extends BaseModel
{
    protected $m_sTable     = 'tool_good';

    public function getGood($nGoodId = null)
    {
        if ($nGoodId){
            return $this->M()
                ->find($nGoodId);
        } else {
            return $this->M()
                ->get();
        }
    }


    public function updateGoodTotal($nTotal, $nGoodId)
    {
        $arrKVPair = ['total' => (int)$nTotal];

        return $this->M()
            ->where('id', $nGoodId)
            ->update($arrKVPair);
    }
}
