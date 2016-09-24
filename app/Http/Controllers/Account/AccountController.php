<?php
/*********************************************************************************
 *  账户管理控制器 - phpad
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By tianyantou.com
 * 文件内容简单说明
 *-------------------------------------------------------------------------------
 * $FILE:AccountController.php
 * $Author:pzz
 * $Dtime:2016/9/13
 ***********************************************************************************/

namespace App\Http\Controllers\Account;


use App\Events\ValidateEmail;
use App\Http\Controllers\FrontController;
use App\Repositories\CensusRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends FrontController
{
    public function __construct(
        UserRepository $userRepository,
        CensusRepository $census
    )
    {
        parent::__initalize();
        $this->userRepository = $userRepository;
        $this->census = $census;
    }

    public function safe()
    {
        $userinfo = $this->userRepository->userModel->find($this->user['id']);
        return view('account.account.safe', compact('userinfo'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     *
     * 绑定银行卡
     */
    public function bankcard(Request $request)
    {
        $bank = $this->userRepository->bankModel->where('user_id', $this->user['id'])->first();
        if ($request->isMethod('post')) {
            if (!empty($bank)) return $this->error('该用户已绑定银行卡', null, true);
            $data = $request->get('data');
            try {
                $result = $this->userRepository->bankModel->saveBy($data);
                if ($result) return $this->success('添加银行卡成功', url('bankcard.html'), true);
            } catch (QueryException $e) {
                return $this->error('添加银行卡失败', null, true);
            }
        }
//        if (empty($bank)) return redirect('/bankcard.html');
        return view('account.account.bankcard', compact('bank'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     *
     * 更新银行卡信息
     */
    public function updatebcard(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->get('data');
            $bank = $this->userRepository->bankModel->find($data['id']);
            if (empty($bank)) return $this->error('该银行卡不存在', null, true);
            try {
                $result = $this->userRepository->bankModel->saveBy($data);
                if ($result) return $this->success('修改银行卡信息成功', url('bankcard.html'), true);
            } catch (QueryException $e) {
                return $this->error('修改银行卡失败信息失败', null, true);
            }
        }
        $bank = $this->userRepository->bankModel->where('user_id', $this->user['id'])->first();
        if (empty($bank)) return redirect('/bankcard.html');
        $area[] = !empty($bank->province) ? $bank->province : '省';
        $area[] = !empty($bank->city) ? $bank->city : '市';
        $area[] = '区';
        $area = json_encode($area);
        return view('account.account.updatecard', compact('bank', 'area'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|void
     *
     *
     * 修改用户名
     */
    public function changenickname(Request $request)
    {
        if ($request->isMethod('post')) {
            $username = $request->nickname;
            $vUsername = $request->nickname_verify;
            if (!$username || !$vUsername) {
                return $this->error('用户名不能为空!', null, true);
            }
            if ($username != $vUsername) {
                return $this->error('两次用户名不一致!', null, true);
            }
            $exists = $this->userRepository->userModel->where('nickname', $username)->exists();
            if ($exists) {
                return $this->error('该用户名已经存在!', null, true);
            }
            $data = ['id' => $this->user['id'], 'nickname' => $username];
            try {
                $result = $this->userRepository->userModel->saveBy($data);
                if ($result) {
                    $data = Session::get('user.passport');
                    $data['nickname'] = $username;
                    Session::put('user.passport', $data);
                    return $this->success('修改成功!', url('/'), true);
                }
            } catch (QueryException $e) {
                $e->getMessage();
            }
            return $this->error('修改失败!', null, true);
        }

        return view('account.account.changenickname');
    }

    public function changetelephone()
    {
        return view('account.account.changetelephone');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     *
     * 验证邮箱
     */
    public function validateemail(Request $request)
    {
        if ($request->isMethod('post')) {
            $action = $request->get('action');
            if ($action == 'authEmail') {
                $user = $this->userRepository->userModel->find($this->user['id']);
                $user->email = $request->email;
                event(new ValidateEmail($user));
                return $this->success('发送成功!', null, true);
            }
            if ($action == 'emailauth') {
                $code = $request->get('verifyCode');
                $email = $request->get('email');
                $checkcode = Session::get('user_' . $this->user['id']);
                if (!$code) {
                    return $this->error('邮箱验证码不能为空!', null, true);
                }
                if (trim($code) != $checkcode) {
                    return $this->error('邮箱验证码不正确!', null, true);
                }
                $exists = $this->userRepository->userModel->where('email', $email)->exists();
                if ($exists) {
                    return $this->error('该邮箱已注册天眼投账号!', null, true);
                }
                $data = ['id' => $this->user['id'], 'email' => $email];
                try {
                    $result = $this->userRepository->userModel->saveBy($data);
                    if (!empty($result)) return $this->success('验证邮箱成功!', url('safe.html'), true);
                } catch (\Exception $e) {
                    return $this->error('验证邮箱失败!', null, true);
                }
            }
            if ($action == 'emailstep1') {
                $code = $request->get('verifyCode');
                $checkcode = Session::get('user_' . $this->user['id']);
                if (trim($code) != $checkcode) {
                    return $this->error('邮箱验证码不正确!', null, true);
                }
                return view('account.account.validateemail1');
            }
            if ($action == 'emailstep2') {
                $code = $request->get('verifyCode');
                $email = $request->get('email');
                $checkcode = Session::get('user_' . $this->user['id']);
                if (trim($code) != $checkcode) {
                    return $this->error('邮箱验证码不正确!', null, true);
                }
                $data = ['id' => $this->user['id'], 'email' => $email];
                try {
                    $result = $this->userRepository->userModel->saveBy($data);
                    if (!empty($result)) return $this->success('修改邮箱成功!', url('safe.html'), true);
                } catch (\Exception $e) {
                    return $this->error('修改邮箱失败!', null, true);
                }
            }
            $user = $this->userRepository->userModel->find($this->user['id']);
            if ($action == 'changeEmail') {
                $email = $request->get('email');
                $exists = $this->userRepository->userModel->where('email', $email)->exists();
                if ($exists) {
                    return $this->error('该邮箱已注册天眼投账号!', null, true);
                }
                $user->email = $email;
            }
            event(new ValidateEmail($user));
            return $this->success('发送成功!', null, true);
        }
        if ($this->user['email']) {
            return view('account.account.changeemail');
        }
        return view('account.account.validateemail');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * 通过手机修改邮箱
     */
    public function changeEmailByTelephone(Request $request)
    {
        if ($request->isMethod('post')) {
            $action = $request->get('action');
            if ($request->get('step') == 1) {
                $verifyCode = trim($request->get('verifyCode'));
                $code = Session::get('phone');
                if ($verifyCode != $code) {
                    return $this->error('手机验证码不正确!', null, true);
                }
                return view('account.account.changeemailbytelephone1');
            }
            $email = $request->get('email');
            $exists = $this->userRepository->userModel->where('email', $email)->exists();
            if ($exists) {
                return $this->error('该邮箱已注册天眼投账号!', null, true);
            }
            if ($action == 'changeEmail') {
                $user = $this->userRepository->userModel->find($this->user['id']);
                $user->email = $email;
                event(new ValidateEmail($user));
                return $this->success('发送成功!', null, true);
            }
            if ($action == 'emailstep2') {
                $verifyCode = $request->get('verifyCode');
                $code = Session::get('user_' . $this->user['id']);
                if ($verifyCode != $code) {
                    return $this->error('邮箱验证码不正确!', bull, true);
                }
                $data = ['id' => $this->user['id'], 'email' => $email];
                try {
                    $result = $this->userRepository->userModel->saveBy($data);
                    if (!empty($result)) return $this->success('修改邮箱成功!', url('safe.html'), true);
                } catch (\Exception $e) {
                    return $this->error('修改邮箱失败!', null, true);
                }
            }
        }
        return view('account.account.changeemailbytelephone');
    }

//    public function validcard()
//    {
//        return view('account.account.validcard');
//    }


    public function changepassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $oldPassword = $request->get('oldPassword');
            $newPassword = $request->get('newPassword');
            $confirmPassword = $request->get('confirmPassword');

            if ($newPassword != $confirmPassword)
                return $this->error('两次密码不一致!', null, true);
            $user = $this->userRepository->userModel->find($this->user['id']);
            if (empty($user))
                return $this->error('该用户不存在', null, true);
            if (!password_verify($oldPassword, $user->password))
                return $this->error('原密码不正确!', null, true);
            try {
                $user->password = $newPassword;
                $user->save();
                return $this->success('修改密码成功!', url('safe.html'), true);
            } catch (QueryException $e) {
                return $this->error('修改密码失败!', null, true);
            }
        }
        return view('account.account.changepassword');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     *
     * 设置交易密码
     */
    public function setDealPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $password = $request->get('password');
            $confirmPassword = $request->get('confirmPassword');

            if (!$password || !$confirmPassword) return $this->error('', null, true);
            $money = $this->userRepository->moneyModel->where('user_id', $this->user['id'])->first();
            if (empty($money))
                return $this->error('该用户没有钱包,请联系天眼投客服!', null, true);
            if ($password != $confirmPassword)
                return $this->error('两次密码不一致!', null, true);
            try {
                $money->password = \Hash::make($password);
                $money->save();
                return $this->success('设置交易密码成功!', url('safe.html'), true);
            } catch (QueryException $e) {
                return $this->error('设置交易密码失败!', null, true);
            }

        }
        return view('account.account.setdealpassword');
    }

    public function dealpassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $oldPassword = $request->get('oldPassword');
            $newPassword = $request->get('newPassword');
            $confirmPassword = $request->get('confirmPassword');

            if ($newPassword != $confirmPassword)
                return $this->error('两次密码不一致!', null, true);
            $money = $this->userRepository->moneyModel->where('user_id', $this->user['id'])->first();
            if (empty($money))
                return $this->error('该用户没有钱包,请联系天眼投客服!', null, true);
            if (!password_verify($oldPassword, $money->password))
                return $this->error('原密码不正确!', null, true);
            try {
                $money->password = \Hash::make($newPassword);
                $money->save();
                return $this->success('修改密码成功!', url('safe.html'), true);
            } catch (QueryException $e) {
                return $this->error('修改密码失败!', null, true);
            }
        }
        return view('account.account.dealpassword');
    }

    public function findpassword()
    {
        return view('account.account.findpassword');
    }

    /**
     * 签到操作
     */
    public function signin(Request $request)
    {
        try {
            $result = $this->census->savePast($this->user['id']);
            if ($result['status']) {
                $past = $this->census->pastModel->where('user_id', $this->user['id'])->first();
                $signReward = getSignReward();
                $res['ret'] = 1;
                $res['info']['username'] = $this->user['username'];
                $res['info']['Score'] = $signReward[$past->days];
                $res['info']['SignCount'] = $past->days;
                $res['info']['SignInReward'] = $signReward;
                $res['info']['LastSignDate'] = date('c', strtotime($past->updated_at));
                return $this->ajaxReturn($res);
            }
        } catch (\Exception $e) {
            $res['ret'] = 0;
            return $this->ajaxReturn($res);
        }
    }
}