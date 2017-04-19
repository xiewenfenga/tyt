<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width"/>
    <link rel="stylesheet" type="text/css" href="//static.tianyantou.com/css/mobile/reset.css"/>
    <link rel="stylesheet" type="text/css" href="//static.tianyantou.com/css/mobile/defult.css"/>
    <title></title>
</head>
<body>
<div class="jpform">
    <div class="header">
        <a href="/"><img src="//static.tianyantou.com/images/mobile/11.png"/></a>
        <p class="plat-title">平台筛选</p>
    </div>
    <div class="jpform-nav">

        <a href="javascript:;">项目周期</a>
        <a href="javascript:;">综合收益</a>
        <a href="javascript:;">平台评级</a>
        <a href="javascript:;">热门平台</a>
    </div>
    <div class="jpform-con">
        @foreach($lists as $cv)
        <div class="data-list">
            <div class="data-title">
                <img src="{!! config('app.static_url') !!}{!! $cv->m_logo  or ''!!}" alt="{!! $cv->platform !!}"/>
                <span>{!! $cv->name or '' !!}</span>
                <a href="{!! config('app.m_url') !!}/platform/{!! $cv->ename or ''!!}.html">首投</a>
            </div>
            <ul>
                <li class="con-red">
                    @if($cv->min_yield == $cv->max_yield)
                        <p class="rt"><b>{!! $cv->max_yield or 0.00 !!}</b><i>%</i></span>
                    @else
                        <p class="rt"><b>{!! $cv->min_yield or 0.00 !!}</b><i>%</i><em>-</em><b>{!! $cv->max_yield or 0.00 !!}</b><i>%</i></span>
                    @endif
                    <!--<p class="rt"><b>{!! $cv->ratio or 0.00 !!}</b><i>%</i></p>-->
                    <p>综合年华收益</p>
                </li>
                <li class="con-red">
                    <p class="rt">{!! $cv->term or '' !!}@if(isset($cv->term_unit)){!! $cv->term_unit == 0 ? '天' : ($cv->term_unit == 1 ? '个月' : '年')!!}@endif</p>
                    <p>期 限</p>
                </li>
                <li class="con-p">
                    <p>返利上限：2000元 </p>
                    <p>起投金额：100元 </p>
                    <p>最大金额：{!! tmoney_format($cv->limit) !!}</p>
                </li>
            </ul>
        </div>
        @endforeach

        <!--<div class="data-list">
            <div class="data-title">
                <img src="//static.tianyantou.com/images/mobile/biao0.png"/>
                <span>搜易贷-搜狐集团旗下公司</span>
                <a href="javascript:;">首投</a>
            </div>
            <ul>
                <li class="con-red">
                    <p class="rt">11-25%</p>
                    <p>综合年华收益</p>
                </li>
                <li class="con-red">
                    <p class="rt">30天</p>
                    <p>期 限</p>
                </li>
                <li class="con-p">
                    <p>返利上限：2000元 </p>
                    <p>起投金额：100元 </p>
                    <p>最大金额：50万</p>
                </li>
            </ul>
        </div>

        <div class="data-list">
            <div class="data-title">
                <img src="//static.tianyantou.com/images/mobile/biao0.png"/>
                <span>搜易贷-搜狐集团旗下公司</span>
                <a href="javascript:;">首投</a>
            </div>
            <ul>
                <li class="con-red">
                    <p class="rt">11-25%</p>
                    <p>综合年华收益</p>
                </li>
                <li class="con-red">
                    <p class="rt">30天</p>
                    <p>期 限</p>
                </li>
                <li class="con-p">
                    <p>返利上限：2000元 </p>
                    <p>起投金额：100元 </p>
                    <p>最大金额：50万</p>
                </li>
            </ul>
        </div>

        <div class="data-list">
            <div class="data-title">
                <img src="//static.tianyantou.com/images/mobile/biao0.png"/>
                <span>搜易贷-搜狐集团旗下公司</span>
                <a href="javascript:;">首投</a>
            </div>
            <ul>
                <li class="con-red">
                    <p class="rt">11-25%</p>
                    <p>综合年华收益</p>
                </li>
                <li class="con-red">
                    <p class="rt">30天</p>
                    <p>期 限</p>
                </li>
                <li class="con-p">
                    <p>返利上限：2000元 </p>
                    <p>起投金额：100元 </p>
                    <p>最大金额：50万</p>
                </li>
            </ul>
        </div>

        <div class="data-list">
            <div class="data-title">
                <img src="//static.tianyantou.com/images/mobile/biao0.png"/>
                <span>搜易贷-搜狐集团旗下公司</span>
                <a href="javascript:;">首投</a>
            </div>
            <ul>
                <li class="con-red">
                    <p class="rt">11-25%</p>
                    <p>综合年华收益</p>
                </li>
                <li class="con-red">
                    <p class="rt">30天</p>
                    <p>期 限</p>
                </li>
                <li class="con-p">
                    <p>返利上限：2000元 </p>
                    <p>起投金额：100元 </p>
                    <p>最大金额：50万</p>
                </li>
            </ul>
        </div>

        <div class="data-list">
            <div class="data-title">
                <img src="//static.tianyantou.com/images/mobile/biao0.png"/>
                <span>搜易贷-搜狐集团旗下公司</span>
                <a href="javascript:;">首投</a>
            </div>
            <ul>
                <li class="con-red">
                    <p class="rt">11-25%</p>
                    <p>综合年华收益</p>
                </li>
                <li class="con-red">
                    <p class="rt">30天</p>
                    <p>期 限</p>
                </li>
                <li class="con-p">
                    <p>返利上限：2000元 </p>
                    <p>起投金额：100元 </p>
                    <p>最大金额：50万</p>
                </li>
            </ul>
        </div>
    </div>-->
</div>
<div class="jpform-foot">
    <ul>
        <li>
            <a href="{!! config('app.m_url') !!}">
                <img src="//static.tianyantou.com/images/mobile/biao1.png"/>
            </a>
            <p>首页</p>

        </li>
        <li>
            <a href="{!! config('app.m_url') !!}/platform">
                <img src="//static.tianyantou.com/images/mobile/biao2.png"/>
            </a>
            <p>精选</p>
        </li>
        <li>
            <img src="//static.tianyantou.com/images/mobile/biao3.png"/>
            <p>我的</p>
        </li>
    </ul>
</div>
</div>
<script src="//static.tianyantou.com/js/mobile/jquery-2.1.3.min.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>


