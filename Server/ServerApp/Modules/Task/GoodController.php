<?php
/********************************************************************************************
 *             Copy Right (c) 2022 Capsheaf Co., Ltd.
 *
 *  Author:          Archibald<yangjunjie@capsheaf.com.cn>
 *  Date:            2022-05-11 15:40:20 CST
 *  Description:     GoodController.php's function description
 *  Version:         1.0.0.20220511-alpha
 *  History:
 *        Archibald<yangjunjie@capsheaf.com.cn> 2022-05-11 15:40:20 CST initialized the file
 *******************************************************************************************/
namespace ServerApp\Modules\Task;

use ServerApp\Models\Good\ToolGood;
use ServerApp\Modules\BaseController;

class GoodController extends BaseController
{
    public function getGood($pagesize, $currentPage)
    {
        $arrGood = (new ToolGood())->getGood();

        return $this->success(['list' => $arrGood, 'count' => count($arrGood)]);
    }


    public function buyGood($nGoodId)
    {
        //秒杀思路设计
        //1、在redis中进行操作数据修改
        //2、redis不存在需要从mysql中取出更新到redis
        //3、设置redis过期

    }
}
