@extends('layout.main')
@section('style')
    <link rel="stylesheet" href="{!! config('app.static_url') !!}/css/mainindex.css?ver={!! time() !!}" />

    @stop
<!--内容开始-->
@section('content')
<div id="index-con" class="wrap">
    <div class="banner-box">
        <!-- 大轮播区 s-->
        <div class="banner-con">
            <div class="banner-play" id="banner-play-mod">
                <div class="banner-play-con imgplaycon">
                    @if(!empty($advs))
                        @foreach($advs as $av)
                            @if(!empty($av->image->name))
                            <a href="{!! $av->url or '' !!}" title="{!! $av->title or '' !!}" target="_blank"><img src="{!! config('app.static_url') . $av->image->name !!}" alt="{!! $av->title !!}"/></a>
                            @endif
                        @endforeach
                    @endif
                </div>
                <a href="javascript:void(0);" class="perbtn"><i class="iconfont">&#xe65f;</i></a>
                <a href="javascript:void(0);" class="nextbtn"><i class="iconfont">&#xe660;</i></a>
                <p class="banner-nav imgnav"></p>
                <div class="main-data">
                    <div class="main-data-show">
                        <p class="trading-volume">撮合成交量：<span class="data-num" datanum="8,533,635,487"></span>元</p>
                        <p class="user-number">累计用户数：<span class="data-num" datanum="2,498,399"></span>人</p>
                        <p class="earnings-num">累计产生收益：<span class="data-num" datanum="216,735,707"></span>元</p>
                        <p class="fund-num">专项赎回基金：<span class="data-num" datanum="13,109,942"></span>元</p>
                    </div>
                    <div class="main-data-mask"></div>
                </div>
            </div>
        </div>

        <!-- 大轮播区 e-->
        <!-- 数据展示区 s-->
        <div class="data-con">
            <div class="honour-show">
                <ul class="company-honour" id="honour-list">
                    <li>
                        <a href="{!! config('app.topics_url') !!}/financing.html" target="_blank">
                            <div class="honour-iconcon">
                                <span class="honour-icon"></span>
                                <p class="honour-title">
                                    <span>顶尖风投亿级融资</span>
                                </p>
                            </div>
                            <p class="honourdetail honourdetail0">
                                赛富、创东方助力<br />新未来
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="{!! config('app.topics_url') !!}/honorwall.html" target="_blank">
                            <div class="honour-iconcon">
                                <span class="honour-icon honour-icon0"></span>
                                <p class="honour-title">
                                    <span>中国互联网金融协会</span>
                                </p>
                            </div>
                            <p class="honourdetail honourdetail0">
                                中国互联网金融协会<br />会员单位
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="{!! config('app.topics_url') !!}/tplan.html" target="_blank">
                            <div class="honour-iconcon">
                                <span class="honour-icon honour-icon1"></span>
                                <p class="honour-title">
                                    <span>天眼投T盾计划</span>
                                </p>
                            </div>
                            <p class="honourdetail honourdetail0">
                                确保投资人资金安全<br />为您的投资保驾护航
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="{!! config('app.url') !!}/about/latest/2274.html" target="_blank">
                            <div class="honour-iconcon">
                                <span class="honour-icon honour-icon3"></span>
                                <p class="honour-title">
                                    <span>CCTV等权威媒体采访</span>
                                </p>
                            </div>
                            <p class="honourdetail honourdetail0">
                                央视采访<br />权威媒体报道
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="notice">
                <h3 class="notice-title"><span><i class="iconfont">&#xe627;</i>&nbsp;&nbsp;公告</span> <a href="{!! config('app.url') !!}/about/notice.html" target="_blank">更多>></a></h3>
                <ul class="notice-list">
                    @foreach($notices as $nv)
                    <li><a href="{!! config('app.url') !!}/about/notice/{{$nv->id}}.html" target="_blank">{!! $nv->title !!}</a><span>{!! date('m-d',strtotime($nv->created_at)) !!}</span></li>
                    @endforeach
                </ul>
            </div>        </div>
        <!-- 数据展示区 e-->
    </div>

    <div class="container">
        <!-- 推荐 s-->
        <div class="index-main-modcon">
            <ul class="platform-list-con">
                @foreach($tasks as $tv)
                <li>
                    <p class="platform-ad">
                        <a  href="{!! config('app.url') !!}/platform/detail_{!! $tv->id or 0!!}.html"  target="_blank" title="点击了解详情"><img src="{!! config('app.static_url') !!}{!! $tv->corp->ad_logo or '' !!}" height="129" width="294" alt="{!! $tv->corp->platform or ''!!}"></a>
                    </p>
                    <div class="plaform-about">
                        <a href="{!! config('app.url') !!}/platform/detail_{!! $tv->id or 0!!}.html" target="_blank" class="plat-logo" title="{!! $tv->corp->platform or '' !!}">
                            <img src="{!! config('app.static_url') !!}{!! $tv->corp->logo !!}" width="70" alt="">
                        </a>
                        <h4 class="debt-title" title="{!! $tv->title or '' !!}">{!! $tv->title or '' !!}</h4>
                        <div class="platform-data">
                            <p class="earnings-num">年化收益率<br/><b>{!! $tv->ratio !!}</b><i>%</i></p>
                            <p class="time-limit-num">
                                期限<br/><b>{!! $tv->term !!}</b><i>天</i>
                            </p>
                            <p class="safe-leavel">安全级别<br><b>{!! $tv->corp->level or 'A' !!}</b></p>
                        </div>
                        <p class="goin-btn">
                            <span>可购金额：{!! money_format('%.2n', $tv->limit) !!} 元</span>
                            <a
                                data-inversurl='{!! $tv->url or '' !!}'
                                title="{!! $tv->title !!}"
                                class="btn btn-blue" title="投资">投资</a>
                        </p>
                    </div>
                </li>
                 @endforeach
              </ul>
        </div>
        <!-- 推荐 e-->

        <!-- 新闻&公告 s-->
        <div class="news-notice">
            <div class="hot-news">
                <div class="hot-con recent-news">
                    <h2><span>最新动态</span><a href="{!! config('app.url') !!}/about/latest.html" target="_blank">更多&gt;</a></h2>
                    <ul>
                        @foreach($latests as $lv)
                        <li>
                            <a href="{!! config('app.url') !!}/about/latest/{!! $lv->id !!}.html" target="_blank" class="img-link">
                                <img src="{!! config('app.static_url') !!}{!! $lv->image->name or '' !!}" alt="{!! $lv->title or '' !!}" height="95">
                            </a>
                            <p class="link-con">
                                <a href="{!! config('app.url') !!}/about/latest/{!! $lv->id !!}.html" target="_blank">{!! $lv->title or '' !!}</a>
                                <span>发布时间：{!! date('Y-m-d',strtotime($lv->created_at)) !!}</span>
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="hot-notice">
                <h2><span>投资攻略</span><a href="{!! config('app.url') !!}/about/strategy.html" target="_blank">更多&gt;</a></h2>
                <dl class="rank-list">
                    @foreach($strategys as $sv)
                    <dd><a href="{!! config('app.url') !!}/about/strategy/{!! $sv->id or 0 !!}.html" target="_blank" title="{!! $sv->title or '' !!}"><p>{!! $sv->title or '' !!}</p><em>{!! $sv->views or 0 !!}</em></a></dd>
                    @endforeach
                </dl>
            </div>
        </div>
        <!-- 新闻&公告 e-->
    </div>
    <!-- 友情链接 s-->
    <div class="friend-link">
        <p class="friend-link-con">
            <span class="link-title">友情链接：</span>
                            <span class="link-detail">
                    <a href="http://www.wdzj.com" target="_blank">网贷之家</a>
                    <a href="http://bbs.wdzj.com" target="_blank">网贷论坛</a>
                    <a href="http://www.touzhijia.com/debt/" target="_blank">二级市场</a>
                    <a href="http://wenda.touzhijia.com/" target="_blank">投资问答</a>
                    <a href="http://finance.china.com.cn/money/efinance/index.shtml" target="_blank">中国网</a>
                    <a href="http://huaxia.kameng.com" target="_blank">华夏银行</a>
                    <a href="http://ipo.qianzhan.com" target="_blank">资本前瞻</a>
                    <a href="http://www.678678.com" target="_blank">淘金网</a>
                    <a href="http://www.rongzhijia.com" target="_blank">融之家</a>
                    <a href="http://www.yiyebang.com/" target="_blank">异业邦</a>
                    <a href="http://www.12308.com" target="_blank">12308汽车票</a>
                    <a href="http://www.liveapp.cn/" target="_blank">场景应用</a>
                    <a href="http://www.yingcanzixun.com/" target="_blank">盈灿咨询</a>
                    <a href="http://www.jinlibaba.com" target="_blank">黄金价格</a>
                    <a href="http://www.gifa.com.cn/" target="_blank">广东互联网金融协会</a>
                 </span>
        </p>
    </div>
    <!-- 友情链接 e-->

</div>
<!--内容结束-->
@stop
<!--底部开始-->
@section('script')
<link rel="stylesheet" href="{!! config('app.static_url') !!}/css/pagestyle/wx_qr.css">
<script type="text/javascript" src="{!! config('app.static_url') !!}/js/plugins/normalplugins.js?ver={!! time() !!}"></script>
<script type="text/javascript" src="{!! config('app.static_url') !!}/js/lib/jquery.dotdotdot.min.js?ver={!! time() !!}"></script>
<script type="text/javascript" src="{!! config('app.static_url') !!}/js/plugins/main.js?ver={!! time() !!}"></script>
<script type="text/javascript" src="{!! config('app.static_url') !!}/js/plugins/mainindex.js?ver={!! time() !!}"></script>
<script>
    $(document).ready(function(){
        $('div.other-debt-list-live li div').removeClass('fixedbd');
    });
</script>  <!--其他-->

<!-- Piwik -->
<script type="text/javascript">
    $(function() {
        var weixinBox = '<iframe src="//open.weixin.qq.com/connect/qrconnect?appid=wx796a0210a2d55243&amp;scope=snsapi_login&amp;redirect_uri={!! config('app.account_url') !!}/thirdparty/callback/weixin&amp;state=tzj&amp;login_type=jssdk&amp;href=http://static.tianyantou.com/css/pagestyle/wx_qr.css" frameborder="0" scrolling="no" width="170px" height="170px">\
                </iframe>\
                <p class="code-text">请使用微信扫码登录<br />首次登录送<b>30</b>积分</p>';
        $('#topbar-wx-qrcode').append(weixinBox);
    })
</script>
@stop
