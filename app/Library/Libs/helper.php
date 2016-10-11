<?php
/*********************************************************************************
 *  PhpStorm - phpad
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By cw100.com
 * 帮助函数集合
 *-------------------------------------------------------------------------------
 * $FILE:helper.php
 * $Author:zxs
 * $Dtime:2016/9/8
 ***********************************************************************************/
use Illuminate\Support\Facades\Route;

/**
 * @param $url
 * 获取html菜单
 */
function getNavConfig()
{
    $routeName = \Route::currentRouteName();
    $routeName = explode('.', $routeName);
    $one = isset($routeName['0']) ? $routeName[0] : '';
    $two = isset($routeName['1']) ? $routeName[1] : '';

    $nav = config('menu.menu');
    $navHtml = $sidebarHtml = '';

    foreach ($nav as $key => $value) {
        $navHtml .= '<div class="header-nav-inner">';
        if (checkPrivi($value['tag'])) {
            $navHtml .= '<a href="' . url($value['url']) . '"';

            if ($one == $value['tag']) {
                $navHtml .= ' class="at"';
                $sidebarHtml .= '<ul class="content-left-menu clearfix">';
                if (!empty($value['child'])) {
                    foreach ($value['child'] as $sidebar) {
                        if (checkPrivi($sidebar['tag'])) {
                            $tag = explode('.', $sidebar['tag']);
                            $sidebarHtml .= '<li><a href="' . url($sidebar['url']) . '"';
                            if (isset($tag[1]) && ($two == $tag[1])) {
                                $sidebarHtml .= ' class="on"';
                            }
                            $sidebarHtml .= ' >' . $sidebar['name'] . '</a></li>';
                        }
                    }
                    $sidebarHtml .= '</ul>';
                }
            }
            $navHtml .= '>' . $value['name'] . '</a>';
        }
        $navHtml .= '</div>';
    }

    return [$navHtml, $sidebarHtml];
}

/**
 * @param $privicode
 * @return bool
 *
 * 检测权限
 */
function checkPrivi($privicode)
{
    $user = \Illuminate\Support\Facades\Session::get('user.passport');
    if (!$user) return false;

    $filter = ['passport.login', 'passport.logout'];
    if (in_array($privicode, $filter)) return true;

    if ($user['role'] == 1) return true;

    $n = substr_count($privicode, '.');
    if ($n <= 1) {
        $code = $privicode;
    } else {
        $p = strpos($privicode, '.', strpos($privicode, '.') + 1);
        $code = substr($privicode, 0, $p);
    }

    $role = \App\Models\RoleModel::find($user['role']);
    if (empty($role)) return false;
//    $roles = explode('.', $role->roles);
    var_dump($privicode);
    var_dump($role->roles);
    if (in_array($code, $role->roles)) return true;

    return false;
}

//将内容进行UNICODE编码，编码后的内容格式：\u56fe\u7247 （原始：图片）
function unicodeToEncode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2) {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0) {    // 两个字节的文字
            $str .= '\u' . base_convert(ord($c), 10, 16) . base_convert(ord($c2), 10, 16);
        } else {
            $str .= $c2;
        }
    }
    return $str;
}

// 将UNICODE编码后的内容进行解码，编码后的内容格式：\u56fe\u7247 （原始：图片）
function unicodeToDecode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches)) {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++) {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0) {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code) . chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            } else {
                $name .= $str;
            }
        }
    }
    return $name;
}

/**
 * 金钱格式
 */

function tmoney_format($number, $fractional = false)
{
    if ($number == 0)
        return '0.00';
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
}


/**
 * @param $startTime
 * @param $endTime
 * @return float
 * 计算时间差
 */
function getDiffTime($startTime, $endTime)
{
    return round(abs($endTime - $startTime) / 60 / 60 / 24);
}

/**
 * @param $day
 * 格式化日期信息
 */
function dateFormat($day)
{
    if ($day <= 30) {
        return $day . '天';
    }
    if ($day > 30 && $day < 365) {
        return ceil(abs($day / 30)) . '个月';
    }

    if ($day > 365) {
        return round(abs($day / 365)) . '年';
    }
}

/**
 * @param $thumb
 * 获取实际图片
 */
function getRealThumb($thumb)
{
    $lists = parse_url($thumb);
    $patshs = explode('/', $lists['path']);
    unset($patshs[count($patshs) - 2]);
    if (!empty($lists['scheme'])) {
        return $lists['scheme'] . '://' . $lists['host'] . implode('/', $patshs);
    } else {
        return '//' . $lists['host'] . implode('/', $patshs);
    }
}

/**
 * @param $phone
 * @return bool
 * 验证手机号码
 */
function is_phone($phone)
{
    $isMobile = "/^1[3-5,8]{1}[0-9]{9}$/";
    $isPhone = "/^([0-9]{3,4}-)?[0-9]{7,8}$/";
    if (!preg_match($isMobile, $phone) && !preg_match($isPhone, $phone)) {
        return false;
    }
    return true;
}

/**
 * @param $money
 * @return bool
 * 验证金额
 */
function is_money($money)
{
    $isMoney = "#^[0-9]+\.?[0-9]{2}?#";
    if (!preg_match($isMoney, $money)) {
        return false;
    }
    return true;
}

/**
 * @param $term 期限
 * @param $unit 单位0是天 1月 2年
 * @param $ratio 年化率
 * @param $money 投资金额
 *
 * 计算收益 100是因为年化率为整型
 */
function getIncome($term, $unit, $ratio, $money)
{
    if ($unit == 0)
        return sprintf('%.2f', $money * $ratio * $term / 365 / 100);
    if ($unit == 1)
        return sprintf('%.2f', $money * $ratio * $term / 12 / 100);
    if ($unit == 2)
        return sprintf('%.2f', $money * $ratio * $term / 100);

}

/**
 * @return array
 * 签到奖励
 */
function getSignReward()
{
    return [1 => 1, 2 => 3, 3 => 5, 4 => 7, 5 => 9, 6 => 13, 7 => 15];
}

//随机验证码
function randomCode($type = 'num')
{
    if ($type == 'num') {
        $code = rand(100000, 999999);
    }
    if ($type == "str") {
        $code = range('a', 'z');
        shuffle($code);
        $code = implode('', array_slice($code, 0, 5));
    }
    return $code;
}

/**
 * @param int $length
 * @return mixed
 *
 * 随机生成用户名
 */
function createUsername($length = 9)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $username = '';
    for ($i = 0; $i < $length; $i++) {
        // 这里提供两种字符获取方式
        // 第一种是使用substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组$chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        $username .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $username;
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    $ckey_length = 4;

    // 密匙
    $key = md5($key ? $key : env('APP_KEY'));

    // 密匙a会参与加解密
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
        substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
//解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
        sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        // 验证数据有效性，请看未加密明文的格式
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
            substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
        ) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function stats($data)
{
    $obj = app()->make('LibraryManager')->create('income');
    $result = $obj->_init($data)->getStats();
    return $result;
}
