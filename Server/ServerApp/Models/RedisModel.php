<?php
/********************************************************************************************
 *             Copy Right (c) 2022 Capsheaf Co., Ltd.
 *
 *  Author:          Archibald<yangjunjie@capsheaf.com.cn>
 *  Date:            2022-05-12 14:12:45 CST
 *  Description:     RedisModel.php's function description
 *  Version:         1.0.0.20220512-alpha
 *  History:
 *        Archibald<yangjunjie@capsheaf.com.cn> 2022-05-12 14:12:45 CST initialized the file
 *******************************************************************************************/

namespace ServerApp\Models;

use Capsheaf\Utils\Types\Arr;
use Capsheaf\Utils\Types\Json;

class RedisModel
{
    /**
     * redis实例
     * @var \Redis
     */
    private $m_hRedis;

    /**
     * @var
     */
    private $scene;

    /**
     * 有限期
     * @var int
     */
    private $m_nExpire = 5;

    /**
     * 锁随机值
     * @var
     */
    private $m_sLockValue;

    public function __construct($arrRedisConfig, $scene = 'kill')
    {
        $this->scene = $scene;
        $this->m_hRedis = new \Redis();
        $this->m_hRedis->connect($arrRedisConfig['server'], $arrRedisConfig['port']);
    }


    /**
     * 加锁
     * @return bool
     */
    public function lock()
    {
        $this->m_sLockValue = md5(uniqid());

        return $this->m_hRedis->set($this->scene, $this->m_sLockValue, ['NX', 'EX' => $this->m_nExpire]);
    }


    /**
     * 解锁
     * @return void
     */
    public function unlock()
    {
        // 通过lua脚本，解决了 解铃还须系铃人 的问题。
        // 使用redis+lua脚本（保证原子性，减少网络开销）
        $script = <<<LUA
            local key=KEYS[1]
            local value=ARGV[1]
            if(redis.call('get', key) == value)
            then
                return redis.call('del', key)
            end
LUA;
        // 执行lua脚本
        $this->m_hRedis->eval($script, [$this->scene, $this->m_sLockValue], 1);
    }


    /**
     * 切换到指定库
     * @param $nDb
     * @return void
     */
    private function selectDb($nDb)
    {
        $this->m_hRedis->select($nDb);
    }


    public function set($key, $value, $nDb)
    {
        $this->selectDb($nDb);
        $this->m_hRedis->set($key, $value);
    }


    public function get($key, $nDb)
    {
        $this->selectDb($nDb);
        return $this->m_hRedis->get($key);
    }
}
