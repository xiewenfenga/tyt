@extends('layout.main')
@section('title') {!! $corp->name or '' !!}大数据@stop
@section('style')
    <link rel="stylesheet"
          href="{!! config('app.static_url') !!}/js/lib/prettyPhoto/css/prettyPhoto.css?ver={!! date('YmdHis') !!}"/>
@stop
@section('content')
    <div id="platform-page" class="wrap">
        <div class="container">
            <ul class="main-nav">
                <span>当前位置：</span>
                <li><a href="/">首页</a></li>
                <li><a href="/platform">选平台</a></li>
                <li class="nav-location">平台详情页</li>
            </ul>
            <div class="main plat-detaile">
                <div class="plat-evaluate">
                    <div id="safety-rating" style="width:330px;height:260px;margin-top: 10px;"></div>
                    @if(!empty($ctask = $corp->tasks->where('status',1)->first()))
                        <a href="javascript:;" data-sso-url="/platform/login/{!! $corp->ename or ''!!}/{!! $ctask->id or 0 !!}" rel="platform_join"
                           data-plat-url="{!! $ctask->url or '' !!}" class="btn btn-blue btn-allwidth">进入平台
                        </a>
                     @endif
                </div>
                <div class="plat-info">
                    <div class="plat-logo">
                        <img src="{!! config('app.static_url') !!}{!! $corp->logo or '' !!}"
                             alt="{!! $corp->name or '' !!}" title="{!! $corp->platoform or '' !!}logo"/>
                    </div>
                    <h2>{!! $corp->name or '' !!}<i class="iconfont">&#xe68e;</i>

                        <div class="tag">
                            @if(!empty($metas['honour_corp_1']))
                                <span>{!! $metas['honour_corp_1'] !!}</span>
                            @endif
                            @if(!empty($metas['honour_corp_2']))
                                <span>{!! $metas['honour_corp_2'] !!}</span>
                            @endif
                            @if(!empty($metas['honour_corp_3']))
                                <span>{!! $metas['honour_corp_3'] !!}</span>
                            @endif
                            <span>天眼投合作平台</span>
                        </div>
                    </h2>
                    <table style="margin-bottom: 10px;-ms-table-layout:auto;width: 568px;">
                        <thead>
                        <tr class="text-ellipsis">
                            <td width="160" class="no-pleft">年化收益率
                                @if($corp->min_yield == $corp->max_yield)
                                    <span class="rate"><em>{!! $corp->min_yield or 0.00 !!}</em>%</span>
                                    @else
                                <span class="rate"><em>{!! $corp->min_yield or 0.00 !!}</em>%-<em>{!! $corp->max_yield or 0.00 !!}</em>%</span>
                                    @endif
                            </td>
                            <td width="120" style="text-indent: 20px;">注册资本<span>{!! $corp->capital or 0 !!}</span></td>
                            <td class="safe" width="120">安全评级<span>{!! $corp->level or '' !!}</span></td>
                            <td class="expire noborder" width="160">天眼投年化率
                                @if($corp->min_myield == $corp->max_myield)
                                    <span  title="{!! $corp->max_myield or 0.00 !!}%">{!! $corp->max_myield or 0.00 !!}%</span>
                                    @else
                                <span  title="{!! $corp->min_myield or 0.00 !!}%-{!! $corp->max_myield or 0.00 !!}%">{!! $corp->min_myield or 0.00 !!}%-{!! $corp->max_myield or 0.00 !!}%</span>
                                    @endif
                            </td>
                        </tr>
                        </thead>
                    </table>
                    <table class="plat-details" style="border-top: 1px solid #F0F1F1;">
                        <tbody>
                        <tr class="table-margin">
                            <td width="200" class="no-pleft">上线时间：<span
                                        title="{!! $corp->online or '' !!}">{!! $corp->online or '' !!}</span></td>
                            <td class="no-pleft">保障方式：<span class="text-ellipsis" style="width: 285px;"
                                        title="{!! $metas['pattern'] or '' !!}">{!! $metas['pattern'] or '' !!}</span></td>

                        </tr>
                        <tr>
                            <td class="no-pleft">所在城市：<span>{!! $corp->city or '' !!}</span></td>
                            <td>担保机构：<span class="text-ellipsis" style="width: 285px;"
                                           title="{!! $metas['assure'] or '' !!}">{!! $metas['assure'] or '' !!}</span></td>
                        </tr>
                        <tr>
                            <td class="no-pleft">充值费用：<span title="免费">免费</span></td>
                            <td>提现费用：<span class="text-ellipsis" style="width: 285px;" title="免费">免费</span></td>
                        </tr>
                        <tr>
                            <td class="no-pleft">VIP费用：<span class="text-ellipsis"
                                                             style=" float:none;width: 100px;margin-left: 6px;"
                                                             title="无">无</span></td>
                            <td>ICP备案：<span style="margin-left: 5px;">{!! $metas['icp_no'] or '' !!}</span></td>
                        </tr>
                        <tr>
                            <td colspan='2' style="color: #75b227;">重要提示：网贷有风险，投资需谨慎</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--荣誉-->
            <div class="content">
                <div class="main">
                    @if(!empty($metas['honour_1']))
                    <div class="honor">
                        <i></i>
                        <p title="{!! $metas['honour_1'] !!}">{!! $metas['honour_1'] !!}</p>
                    </div>
                        @else
                        <div class="nohonor">
                            暂无更多荣誉
                        </div>
                    @endif
                </div>
                <div class="main">
                    @if(!empty($metas['honour_2']))
                    <div class="honor">
                        <i></i>
                        <p title="{!! $metas['honour_2'] !!}">{!! $metas['honour_2'] !!}</p>
                    </div>
                        @else
                        <div class="nohonor">
                            暂无更多荣誉
                        </div>
                    @endif
                </div>

                <div class="main">
                    @if(!empty($metas['honour_3']))
                    <div class="honor">
                        <i></i>
                        <p title="{!! $metas['honour_3'] !!}">{!! $metas['honour_3'] !!}</p>
                    </div>
                    @else
                        <div class="nohonor">
                            暂无更多荣誉
                        </div>
                    @endif
                </div>
            </div>
            <!--详情-->
            <div class="tab click-tab">
                <ul class="tab-nav">
                    <li class="active"><a href="javascript:void(0);">平台简介</a></li>
                    <li><a href="javascript:void(0);">团队介绍</a></li>
                    <li><a href="javascript:void(0);">安全保障</a></li>
                    <li><a href="javascript:void(0);">图片资料</a></li>
                    <li><a href="javascript:void(0);">平台最新动态</a></li>
                </ul>
                <div class="tab-main">
                    <div class="active">
                        <div class="license"><img src="{!! config('app.static_url') !!}{!! $corp->chartered !!}"
                                                  width="280" height="220" alt="{!! $corp->name !!}营业执照"/></div>
                        {!! $corp->article->content or '' !!}
                    </div>

                    <div class="plat-team">
                        @if(!empty($corp->terms))
                        <div class="imgplay" id="plat-team">
                            <?php $len = floor(count($corp->terms)/ 4) + 1; ?>
                            <div class="imgplaycon">
                                <ul class="imglistcon">
                                    @for($i=0; $i< $len;$i++)
                                    <li>
                                        @for($j=0; $j<4;$j++)
                                            <?php $tv = !empty($corp->terms[$i * 4 + $j]) ? $corp->terms[$i * 4 + $j] : null; ?>
                                            @if(!empty($tv))
                                                <div class="member-box">
                                                    <div class="member-img">
                                                        <div class="circle-mask" style="display:none;"></div>
                                                        <img src="{!! config('app.static_url') !!}{!! $tv->avatar->name or '' !!}"
                                                             target="{!! $tv->name or '' !!}"/>
                                                    </div>
                                                    <h4>{!! $tv->name or '' !!}</h4>
                                                    <span title="{!! $tv->position or '' !!}">{!! $tv->position or '' !!}</span>

                                                    <p title="{!! $tv->intro or '' !!}">
                                                        {!! $tv->intro or '' !!}
                                                    </p>
                                                </div>
                                            @endif
                                        @endfor
                                    </li>
                                     @endfor
                                </ul>
                            </div>
                                @if($len > 1)
                            <a href="javascript:void(0);" class="actbtn perbtn">
                                <span class="iconfont">&#xe65f;</span>
                            </a>
                            <a href="javascript:void(0);" class="actbtn nextbtn">
                                <span class="iconfont">&#xe660;</span>
                            </a>
                             @endif
                        </div>
                        @endif
                    </div>
                    <div class="plat-safe">
                        <div class="safe-box" style="margin-left: 0;">
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="2" class="safe-title">网站备案</td>
                                </tr>
                                <tr>
                                    <td><span>备案域名：</span></td>
                                    <td>{!! $metas['icp_domain'] or '' !!}</td>
                                </tr>
                                <tr>
                                    <td><span>备案时间：</span></td>
                                    <td>{!! $metas['icp_time'] or '' !!}</td>
                                </tr>
                                <tr>
                                    <td><span>单位性质：</span></td>
                                    <td>{!! $metas['icp_corp_type'] or '' !!}</td>
                                </tr>
                                <tr>
                                    <td><span>单位名称：</span></td>
                                    <td>{!! $metas['icp_corp_name'] or '' !!}</td>
                                </tr>
                                <tr>
                                    <td><span>ICP备案号：</span></td>
                                    <td>{!! $metas['icp_no'] or '' !!}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="safe-box">
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="2" class="safe-title">考查报告</td>
                                </tr>
                                <tr>
                                    <td><span>考察时间：</span></td>
                                    <td>
                                        暂无
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="safe-box noborder" style="width: 24%;">
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="2" class="safe-title">合作担保</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="line-height:1.5;"></td>
                                </tr>
                                <tr>
                                    <td width="80"><span>注册资本：</span></td>
                                    <td>{!! $corp->capital or 0.00 !!}</td>
                                </tr>
                                <tr>
                                    <td><span>成立时间：</span></td>
                                    <td>{!! $corp->online or 0.00 !!}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="plat-photos">
                        <div class="tab click-tab">
                            <ul class="tab-nav">
                                <li class="active" style="width:50% !important;"><a href="">平台证件</a></li>
                                <li style="width:50% !important;"><a href="#">办公环境</a></li>
                            </ul>
                            <div class="tab-main">
                                <div class="active">
                                    <div class="imgplay" id="carousel-photo01">
                                        @if(!empty($metas['credentials']))
                                            <?php $count = count($metas['credentials']); $len = $count / 5 + 1; ?>
                                        <ul class="imgplaycon">
                                                @for($i=0; $i<$len; $i++)
                                                    <li>
                                                        @for($l=0;$l<5;$l++)
                                                            <?php $key = 5 * $i + $l;?>
                                                            @if(!empty($metas['credentials'][$key]))
                                                                <a rel="prettyPhoto[pp_gal]" href="{!! getRealThumb($metas['credentials'][$key]) !!}">
                                                                    <img src="{!! $metas['credentials'][$key] !!}"/>
                                                                </a>
                                                            @endif
                                                        @endfor
                                                    </li>
                                                @endfor
                                        </ul>
                                            @if($count > 5)
                                                <a href="javascript:void(0);" class="actbtn perbtn"><span class="iconfont"></span></a>
                                                <a href="javascript:void(0);" class="actbtn nextbtn"><span class="iconfont"></span></a>
                                           @endif
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <div class="imgplay" id="carousel-photo03">
                                        @if(!empty($metas['office_address']))
                                            <?php $count = count($metas['office_address']); $len = $count / 5 + 1; ?>
                                            <ul class="imgplaycon">
                                                @for($i=0; $i<$len; $i++)
                                                    <li>
                                                        @for($l=0;$l<5;$l++)
                                                            <?php $key = 5 * $i + $l;?>
                                                            @if(!empty($metas['office_address'][$key]))
                                                                <a rel="prettyPhoto[pp_gal]" href="{!! getRealThumb($metas['office_address'][$key]) !!}">
                                                                    <img src="{!! $metas['office_address'][$key] !!}"/>
                                                                </a>
                                                            @endif
                                                        @endfor
                                                    </li>
                                                @endfor
                                            </ul>
                                            @if($count > 5)
                                        <a href="javascript:void(0);" class="actbtn perbtn"><span class="iconfont">&#xe65f;</span></a>
                                        <a href="javascript:void(0);" class="actbtn nextbtn"><span class="iconfont">&#xe660;</span></a>
                                                @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="padding-bottom: 0;">
                        @if(empty($corp->news[0]))
                            <div style="text-align:center;margin-bottom:26px;">暂无平台动态信息</div>
                        @endif
                        @if(!empty($corp->news[0]))
                            @foreach($corp->news as $nv)
                        <div class="news-box"><!-- -->
                            <a href="{!! url('about/news/' . $nv->id .'.html') !!}" target="_blank"><img src="{!! $nv->image->name or '' !!}" title="{!! $nv->title !!}"></a>
                            <div class="news">
                                <h3><a href="{!! url('about/news/' . $nv->id .'.html') !!}" target="_blank">{!! $nv->title !!}</a></h3>
                                <span>发布时间： {!! $nv->created_at !!}<em>241</em>人</span>
                                <p style="word-wrap: break-word;">{!! $nv->description or '' !!}</p>
                            </div>
                        </div>
                         @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="main">
                <h2 class="filter-title" data-en-name="{!! $corp->ename or '' !!}">
                    <a href="javascript:void(0);" class="btn btn-m btn-white" sorttype="0" sortorder="asc">默认排序</a>
                    <a href="javascript:void(0);" class="btn btn-m btn-white" sorttype="1" sortorder="desc">收益率<i
                                class="iconfont">&#xe674;</i></a>
                    <a href="javascript:void(0);" class="btn btn-m btn-white" sorttype="2" sortorder="desc">项目期限<i
                                class="iconfont">&#xe674;</i></a>
                    <a href="javascript:void(0);" class="btn btn-m btn-white" sorttype="3" sortorder="desc">投标进度<i
                                class="iconfont">&#xe674;</i></a>
                </h2>
                <table class="table">
                    <thead>
                    <tr>
                        <td width="180" class="title">项目标题</td>
                        <td width="160">项目金额</td>
                        <td width="180">综合收益率</td>
                        <td width="160">项目期限</td>
                        <td width="180">还款方式</td>
                        <td width="160">投标进度</td>
                        <td width="110">详情</td>
                    </tr>
                    </thead>
                    <tbody id="platfrom_bid_list">

                    </tbody>
                </table>
                <div id="palt_bidding_page">

                </div>
            </div>
        </div>
    </div>
    <!--内容结束-->
@stop
@section('script')
    <script type="text/javascript">
        //雷达图数据
        var platformInfo = {
            "yunyingnengli": "{!! $metas['operating_capacity'] or 0.00!!}",
            "levers": "{!! $metas['capital_adequacy'] or 0.00 !!}",
            "liudongxing": "{!! $metas['flowability'] or 0.00 !!}",
            "weiyuechengben": "{!! $metas['contract_rate'] or 0.00 !!}",
            "toumingdu": "{!! $metas['transparency'] or 0.00 !!}",
            "fensandu": "{!! $metas['dissemination'] or 0.00 !!}"
        };
    </script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/lib/jquery-1.11.3.min.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/lib/jquery.dotdotdot.min.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/lib/prettyPhoto/jquery.prettyPhoto.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/imgopacity.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript" src="{!!config('app.static_url')!!}/js/lib/jquery.form.min.js"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/imgmove.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/tab.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/form.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/login.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/echarts-all.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/plugins/main.js?ver={!! date('YmdHIs') !!}"></script>
    <script type="text/javascript"
            src="{!! config('app.static_url') !!}/js/lib/laypage/laypage.js?ver={!! date('YmdHIs') !!}"></script>
@stop