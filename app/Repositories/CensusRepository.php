<?php
/*********************************************************************************
 *  PhpStorm - phpad
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By cw100.com
 * 统计说明
 *-------------------------------------------------------------------------------
 * $FILE:CensusRepository.php
 * $Author:zxs
 * $Dtime:2016/9/15
 ***********************************************************************************/
namespace App\Repositories;

use App\Models\BookModel;
use App\Models\BookRepayModel;
use App\Models\CorpModel;
use App\Models\MoneyModel;
use App\Models\PastModel;
use App\Models\RecordModel;
use App\Models\TaskAchieveModel;
use App\Models\TaskModel;
use App\Models\TaskReceiveModel;
use App\Models\UserModel;
use App\Models\WithdrawModel;
use App\Models\ScoreModel;
use Carbon\Carbon;

class CensusRepository extends BaseRepository
{

    public function __construct(
        TaskReceiveModel $taskReceiveModel,
        TaskAchieveModel $taskAchieveModel,
        MoneyModel $moneyModel,
        UserModel $userModel,
        PastModel $pastModel,
        RecordModel $recordModel,
        WithdrawModel $withdrawModel,
        ScoreModel $scoreModel,
        BookModel $bookModel,
        BookRepayModel $bookRepayModel,
        CorpModel $corpModel,
        TaskModel $taskModel
    )
    {
        $this->taskReceiveModel = $taskReceiveModel;
        $this->taskAchieveModel = $taskAchieveModel;
        $this->moneyModel = $moneyModel;
        $this->userModel = $userModel;
        $this->pastModel = $pastModel;
        $this->recordModel = $recordModel;
        $this->withdrawModel = $withdrawModel;
        $this->scoreModel = $scoreModel;
        $this->bookModel = $bookModel;
        $this->bookRepayModel = $bookRepayModel;
        $this->corpModel = $corpModel;
        $this->taskModel = $taskModel;
    }


    /**
     * @param $userId
     * 用户签到信息
     */
    public function savePast($userId)
    {
        $result = $this->pastModel->getConnection()->transaction(function ($conn) use ($userId) {
            $signInReward = getSignReward();
            $pastModel = $this->pastModel->firstOrCreate(['user_id' => $userId]);
            //签到
            $sql = "UPDATE ad_pasts SET days = ";
            $sql .= "CASE WHEN TO_DAYS(updated_at) = TO_DAYS(now()) - 1 THEN (days + 1) MOD 7 ";
            $sql .= "ELSE 0 END WHERE user_id = ?";
            $conn->update($sql, [$userId]);
            if ($pastModel->days == 0) {
                $this->pastModel->saveBy(['id' => $pastModel->id, 'days' => 1]);
                $pastModel->days = 1;
            }
            $score = $signInReward[$pastModel->days];
            //增加记录积分流水
            $data['intro'] = sprintf('您第%d天签到获取%d个积分', $pastModel->days, $score);
            $data['user_id'] = $userId;
            $data['score'] = $score;
            $this->scoreModel->create($data);
            $this->moneyModel->where('user_id', $userId)->increment('score', $score);
        });

        if ($result instanceof \Exception) {
            return $this->getError($result->getMessage());
        } else {
            return $this->getSuccess('签到完成', $result);
        }
    }

    /**
     * @param $startTime
     * @param $endTime
     * 获取注册人数u
     *
     */
    public function getRegisterUserStats($startTime, $endTime)
    {
        return $this->userModel->whereBetween('created_at', [$startTime, $endTime])->count();
    }


    /**
     * @param int $status
     * @param $startTime
     * @param $endTime
     * @return mixed
     * 用户领取任务统计
     */
    public function getTaskReceiveStats($status = 0, $startTime, $endTime, $corpId, $taskId)
    {
        $startTime = $startTime;
        $endTime = $endTime;
        if ($status == 0) {
            $query = $this->taskReceiveModel->whereBetween('created_at', [$startTime, $endTime]);
        } else if ($status == 2) {
            $query = $this->taskAchieveModel->where('status',0)->whereBetween('created_at', [$startTime, $endTime]);
        } else if ($status == 1) {
            $query = $this->taskAchieveModel->where('status',1)->whereBetween('updated_at', [$startTime, $endTime]);
        }
        if ($corpId) {
            $query = $query->where('corp_id', $corpId);
        }
        if ($taskId) {
            $query = $query->where('task_id', $taskId);
        }
        $count = $query->count();
        return $count;
    }

    /**
     * @param array $where
     * @return mixed
     *
     * 任务统计
     */
    public function getTaskStats($where = [])
    {
        $tasks = $this->taskModel->alls('*', $where);

        foreach ($tasks as $task) {
            $task->investnums = $this->taskAchieveModel->where('task_id', $task->id)->count();
            $task->overplus = $task->nums - $task->investnums;
            $task->reject = $this->taskAchieveModel->where('task_id',$task->id)->where('status',2)->count();
            $task->create = $this->taskAchieveModel->where('task_id', $task->id)->where('status', 0)->sum('price');
            $task->commit = $this->taskAchieveModel->where('task_id', $task->id)->where('status', 2)->sum('price');
            $task->complete = $this->taskAchieveModel->where('task_id', $task->id)->where('status', 1)->sum('price');
            $task->income = $this->taskAchieveModel->where('task_id', $task->id)->where('status', 1)->sum('income');
        }

        return $tasks;
    }

    /**
     * @param $userId
     * @param $startTime 2016-08-09
     * @param $endTime 2016-10-10
     * 查询投资统计
     */
    public function getIncomesStats($userId, $startTime, $endTime)
    {
        list($startTime, $endTime) = $this->getMonthTime($endTime, $startTime);
        $stats = [];
        $receiveIn = 0.00;
        $repayIn = 0.00;
        $account = 0.00;
        $colors = [
            0 => '#2aa3ce',
            1 => '#FB9142',
            2 => '#fb4242',
            3 => '#79B32B',
        ];
        //账号金额
        $moneyModel = $this->moneyModel->where('user_id', $userId)->first();
        if (!empty($moneyModel->money)) {
            $account = $moneyModel->money;
        }
        $query = $this->taskAchieveModel->select(['*']);
        $where['user_id'] = $userId;
        $query = $this->taskAchieveModel->createWhere($query, $where);
        $result = $query->get();
        if (empty($result)) return $stats;
        foreach ($result as $achieveModel) {
            $unit = $achieveModel->task->term_unit == 0 ? '天' : ($achieveModel->task->term_unit == 1 ? '月' : '年');

            if (!empty($achieveModel->created_at) &&
                (strtotime($achieveModel->created_at) >= $startTime && strtotime($achieveModel->created_at) < $endTime) && $achieveModel->status == 0
            ) {
                $title = '待收' . $achieveModel->income . '元';
                $repayIn += sprintf('%.2f', $achieveModel->income);
                $stats[] = ['title' => $title, 'color' => $colors[1], 'start' => date('Y-m-d', strtotime($achieveModel->create_at))];
            }

            if (!empty($achieveModel->updated_at) &&
                (strtotime($achieveModel->updated_at) >= $startTime && strtotime($achieveModel->updated_at) < $endTime) && $achieveModel->status == 1
            ) {
                $title = '已收' . $achieveModel->income . '元';
                $repayIn += sprintf('%.2f', $achieveModel->income);
                $stats[] = ['title' => $title, 'color' => $colors[3], 'start' => date('Y-m-d', strtotime($achieveModel->updated_at))];
            }

        }

        //记录记账功能点
        $query = $this->bookModel->select(['*']);
        $where['user_id'] = $userId;
        $query = $this->bookModel->createWhere($query, $where);
        $bookResult = $query->get();
        if (!empty($bookResult)) {
            foreach ($bookResult as $book) {
                if (!empty($book->created_at)) {
                    $createdTime = strtotime($book->created_at);
                    if ($createdTime >= $startTime && $createdTime < $endTime) {
                        $title = "记录" . $book->corp_name . '平台，' . $book->task_name . '投资';
                        $stats[] = ['title' => $title, 'color' => $colors[2], 'start' => date('Y-m-d', $createdTime)];
                    }
                }
            }
        }
        return [$account, $receiveIn, $repayIn, $stats];
    }

    /**
     * @param $userId
     * 查询用户投资收益金额
     */
    public function getUserInvestIncome($userId)
    {
        //待收总额
        $unIncome = $this->taskAchieveModel->where('user_id', $userId)->where('status', 0)->sum('income');
        $unIncome = !empty($unIncome) ? $unIncome : 0.00;
        //已投资收益
        $hasIncome = $this->taskAchieveModel->where('user_id', $userId)->where('status', 1)->sum('income');
        $hasIncome = !empty($hasIncome) ? $hasIncome : 0.00;
        //待收笔数
        $unCount = $this->taskAchieveModel->where('user_id', $userId)->where('status', 0)->count();

        return [$unIncome, $hasIncome, $unCount];
    }

    /**
     * 首页统计情况
     */
    public function getHomeStats()
    {
        //撮合成交总量
        $total = $this->taskAchieveModel->where('status', 1)->sum('price');
        $census['total'] = !empty($total) ? $total : '0.00';
        //累计注册人数
        $census['registers'] = $this->userModel->where('roles', 0)->count();
        //累计产生收益
        $income = $this->taskAchieveModel->where('status', 1)->sum('income');
        $census['income'] = !empty($income) ? $income : '0.00';
        //待完成成交
        //投资笔数
        $census['itotal'] = $this->taskAchieveModel->count();

        return $census;
    }

    /**
     * @param $userId
     * 获取用户明细统计中信息
     */
    public function getUserAnalysisStats($userId)
    {
        $total = $this->taskAchieveModel->where('user_id', $userId)->sum('price');
        $census['total'] = !empty($total) ? $total : '0.00';
        $income = $this->taskAchieveModel->where('user_id', $userId)->sum('income');
        $census['income'] = !empty($income) ? $income : '0.00';
        $platform = $this->taskAchieveModel->where('user_id', $userId)->distinct()->count('corp_id');
        //$query = $this->taskReceiveModel->where('user_id',$userId)->groupBy('corp_id')->distinct();
        $census['platform'] = !empty($platform) ? $platform : 0;
        return $census;
    }

    /**
     * @param $userId
     * @return mixed
     *
     * 用户流水统计
     */
    public function getUserRocordStats($userId)
    {
        //累计收入
        $income = $this->recordModel->where('user_id', $userId)->sum('income');
        $census['income'] = !empty($income) ? $income : '0.00';
        //累计支出
        $cost = $this->recordModel->where('user_id', $userId)->sum('cost');
        $census['cost'] = !empty($cost) ? $cost : '0.00';
        //账户余额
        $money = $this->moneyModel->where('user_id', $userId)->first();
        $census['money'] = !empty($money) ? $money->money : '0.00';

        return $census;
    }

    /**
     * @param $userId
     * @return mixed
     *
     * 用户提现统计
     */
    public function getUserWithdrawStats($userId)
    {
        //累计成功提现次数
        $census['success'] = $this->withdrawModel->where('user_id', $userId)->where('status', 1)->count();
        //累计提现金额
        $withdraw = $this->withdrawModel->where('user_id', $userId)->where('status', 1)->sum('price');
        $census['withdraw'] = !empty($withdraw) ? $withdraw : '0.00';
        //账户余额
        $money = $this->moneyModel->where('user_id', $userId)->first();
        $census['money'] = !empty($money) ? $money->money : '0.00';

        return $census;
    }

    /**
     * @param $userId
     * @return mixed
     *
     *
     * 获取用户总积分
     */
    public function getUserScoreTotal($userId)
    {
        $census['total'] = $this->scoreModel->where('user_id', $userId)->sum('score');

        return $census;
    }

    /**
     * @param $userId
     * 获取用户半年收益统计
     */
    public function getHalfYearStat($userId)
    {
        $stats = [];
        for ($i = 0; $i < 6; $i++) {
            $time = $i == 0 ? time() : strtotime('-' . $i . ' months');
            $yearMonth = date('Y-m', $time);
            $startTime = $yearMonth . '-01 00:00:01';
            $endTime = $yearMonth . '-' . date('t', $time) . ' 23:59:59';
            $income = $this->recordModel->where('user_id', $userId)
                ->whereBetween('created_at', [$startTime, $endTime])->sum('income');
            $stats[$yearMonth] = !empty($income) ? (int)$income : 0;
        };
        ksort($stats);
        return $stats;
    }

    /**
     * @param $endTime
     * @param $startTime
     * 判断当开始和结束时间
     */
    private function getMonthTime($endTime, $startTime)
    {
        $time = strtotime($startTime) + 15 * 24 * 60 * 60; //加半个月
        //这个月的天数
        $money = date('m', $time);
        $days = date('t', $time);
        $start = strtotime(date('Y-m', $time) . '-01 00:00:01');
        $end = strtotime(date('Y-m', $time) . '-' . $days . ' 23:59:59');
        return [$start, $end];
    }


}