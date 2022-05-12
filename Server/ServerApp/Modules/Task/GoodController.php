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

use Capsheaf\Utils\Types\Json;
use ServerApp\Models\Good\ToolGood;
use ServerApp\Models\Order\ToolOrder;
use ServerApp\Models\RedisModel;
use ServerApp\Modules\BaseController;

class GoodController extends BaseController
{
    protected $nGoodInfoDb = 0;

    protected $nGoodTotalDb = 1;

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

        //判断redis中是否存在秒杀商品，不存在则进行redis缓存
        $redis = new RedisModel($this->m_app['config']['database']['redis']);
        $goodCount = $redis->get($nGoodId, $this->nGoodTotalDb);

        if ($goodCount === false){
            $bRet = $redis->lock();
            if ($bRet){
                //加锁成功，第一个请求进行从mysql取出数据，存入缓存
                $arrGood = (new ToolGood())->getGood((int)$nGoodId);
                $nNewGoodTotal = $arrGood['total'] - 1;
                if ($nNewGoodTotal<0){
                    return $this->error();
                }
                $redis->set($nGoodId, $nNewGoodTotal, $this->nGoodTotalDb);
                $redis->unlock();
                $this->operateInventoryAndOrder($nGoodId, $nNewGoodTotal);
            } else {
                while($goodCount = $redis->get($nGoodId, $this->nGoodTotalDb) === false){
                    sleep(1);
                }

                $nNewGoodTotal = $goodCount - 1;
                if ($nNewGoodTotal<0){
                    return $this->error();
                }
                $redis->set($nGoodId, $nNewGoodTotal, $this->nGoodTotalDb);
                $this->operateInventoryAndOrder($nGoodId, $nNewGoodTotal);
            }
        } else {
            $nNewGoodTotal = $goodCount -1;
            if ($nNewGoodTotal<0){
                return $this->error();
            }
            $redis->set($nGoodId, $nNewGoodTotal, $this->nGoodTotalDb);
            $this->operateInventoryAndOrder($nGoodId, $nNewGoodTotal);
        }

        return $this->success();
    }


    /**
     * 同步更新库存和下订单（若并发量大，可以先写入消息队列，等秒杀活动结束后，后台异步更新到数据库）
     * @param $nGoodId
     * @param $nNewGoodTotal
     * @return void
     */
    public function operateInventoryAndOrder($nGoodId, $nNewGoodTotal)
    {
        (new ToolGood())->updateGoodTotal($nNewGoodTotal, (int)$nGoodId);
        $arrKVPair = [
            'good_id' => $nGoodId,
            'pay'     => 0
        ];
        (new ToolOrder())->createOrder($arrKVPair);
    }


}
