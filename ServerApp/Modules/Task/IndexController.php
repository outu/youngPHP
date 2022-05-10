<?php
/********************************************************************************************
 *             Copy Right (c) 2022 Capsheaf Co., Ltd.
 *
 *  Author:          Archibald<yangjunjie@capsheaf.com.cn>
 *  Date:            2022-01-25 17:46:06 CST
 *  Description:     IndexController.php's function description
 *  Version:         1.0.0.20220125-alpha
 *  History:
 *        Archibald<yangjunjie@capsheaf.com.cn> 2022-01-25 17:46:06 CST initialized the file
 *******************************************************************************************/

namespace ServerApp\Modules\Task;

use ServerApp\Models\Task\ToolTask;
use ServerApp\Modules\BaseController;

class IndexController extends BaseController
{
    protected $m_sTaskStateMap = [
        'TASK_WAITING'   => '任务等待执行',
        'TASK_SCANNING'  => '任务处于扫描中',
        'TASK_SCANNED'   => '任务扫描结束',
        'TASK_FINISHED'  => '任务结束'
    ];

    public function createCopyTask($sSourceDir, $sTargetDir)
    {

        (new ToolTask())->addTask([$sSourceDir, $sTargetDir]);

        return $this->success();
    }


    public function getRunningTask($pagesize, $currentPage)
    {
        /**
         * 左连接一次性查询
         * select tool_task.id, tool_task.meta, tool_task.created_at, task_state.state_C as state
        from tool_task LEFT JOIN task_state ON tool_task.state = task_state.state_E;
         */
        $arrRunningTask = (new ToolTask())->getRunningTask();
        $nRunningTaskCount = (new ToolTask())->getRunningTaskCount();

        foreach ($arrRunningTask as $key => $arrTaskInfo) {
            $arrRunningTask[$key]['state'] = $this->taskStateMap($arrTaskInfo['state']);
        }

        return $this->success(['list' => $arrRunningTask, 'count' => $nRunningTaskCount]);
    }


    public function getCompletedTransList($pagesize, $currentPage)
    {
        $arrFinishedTransList = (new TransList())->getCompletedTransList($pagesize, $currentPage);
        $nFinishedTransList   = (new TransList())->getCompletedTransListCount();

        return $this->success(['list' => $arrFinishedTransList, 'count' => $nFinishedTransList]);
    }


    public function getInCompleteTransList($pagesize, $currentPage)
    {
        $arrFinishedTransList = (new TransList())->getInCompleteTransList($pagesize, $currentPage);
        $nFinishedTransList   = (new TransList())->getInCompleteTransListCount();

        return $this->success(['list' => $arrFinishedTransList, 'count' => $nFinishedTransList]);
    }


    public function taskStateMap($sTaskSate)
    {
        return $this->m_sTaskStateMap[$sTaskSate];
    }
}