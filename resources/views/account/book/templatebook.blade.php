    @if(!empty($book->id))
        <input type="hidden" name="data[id]" value="{!! $book->id or '' !!}">
    @endif
    <input type="hidden" name="data[user_id]" value="{!! $user['id'] or '' !!}">
    <div class="control-group">
        <label for="real-name">投资平台</label>
        <input type="text" name="data[corp_name]" class="input-style" value="{!! $book->corp_name or '' !!}" placeholder="输入平台名称必填">
    </div>
    <div class="control-group">
        <label>项目名称</label>
        <input type="text" name="data[task_name]" class="input-style" value="{!! $book->task_name or '' !!}" placeholder="输入项目名称必填">
    </div>
    <div class="autobuy-panel-2 control-group">
        <label>投资金额</label>
        <input class="input-style input-size" type="text" name="data[money]" value="{!! $book->money or '' !!}"  placeholder="输入实投金额(不含抵扣)" />
        <i class="input-icon">元</i>
    </div>
    <div class="autobuy-panel-2 control-group">
        <label>起息日期</label>
        <input id="valueDate" class="input-style input-size" type="text" name="data[start_time]" value="{!! $book->start_time or '' !!}" onclick="WdatePicker()" placeholder="选择起息时间" />
        <i class="input-icon iconfont">&#xe689;</i>
    </div>
    <div class="control-group">
        <label>利率</label>
        <input type="text" name="data[rate]" value="{!! $book->id or '' !!}" class="input-style" placeholder="例:10.8">
        <label class="control-option">
            <input type="radio" name="data[rate_unit]" value="0" @if(empty($book->rate_unit) || (!empty($book->rate_unit)&&$book->rate_unit==0))checked @endif /> 年利率
        </label>
        <label class="control-option">
            <input type="radio" name="data[rate_unit]" value="1" @if(!empty($book->rate_unit)&&$book->rate_unit==1 )checked @endif /> 日利率
        </label>
        <label class="control-option">
            <input type="radio" name="data[rate_unit]" value="2" @if(!empty($book->rate_unit)&&$book->rate_unit==2 )checked @endif /> 年利率（按360天计算）
        </label>
    </div>
    <div class="control-group">
        <label for="">期限</label>
        <input type="text" name="data[term]" value="{!! $book->term or '' !!}" class="input-style" placeholder="例:6">
        <label class="control-option">
            <input type="radio" name="data[term_unit]" value="0" @if(empty($book->term_unit) || (!empty($book->term_unit)&&$book->term_unit=='月'))checked @endif /> 月
        </label>
        <label class="control-option">
            <input type="radio" name="data[term_unit]" value="1" @if(!empty($book->term_unit)&&$book->term_unit=='年' )checked @endif /> 年
        </label>
    </div>
    <div class="control-group">
        <label for="">还款方式</label>
        <select name="data[repay_type]" class="input-style required">
            <option value="1" @if(!empty($book->repay)&&$book->repay=='一次性还本付息')selected @endif>一次性还本付息</option>
            <option value="2" @if(!empty($book->repay)&&$book->repay=='按月付息到期还本')selected @endif>按月付息到期还本</option>
            <option value="3" @if(!empty($book->repay)&&$book->repay=='按日付息到期还本')selected @endif>按日付息到期还本</option>
            <option value="4" @if(!empty($book->repay)&&$book->repay=='等额本金')selected @endif>等额本金</option>
            <option value="5" @if(!empty($book->repay)&&$book->repay=='等额本息')selected @endif>等额本息</option>
            <option value="6" @if(!empty($book->repay)&&$book->repay=='月还息按季等额本金')selected @endif>月还息按季等额本金</option>
            <option value="7" @if(!empty($book->repay)&&$book->repay=='按季付息到期还本')selected @endif>按季付息到期还本</option>
        </select>
    </div>
    <div class="control-group">
        <label for="">现金奖励</label>
        <input type="text" name="data[reward]" value="{!! $book->reward or '' !!}" class="input-style" placeholder="选填">
        <label for="">折扣奖励</label>
        <input type="text" name="data[discount]" value="{!! $book->discount or '' !!}" class="input-style" placeholder="选填">
    </div>
    <div class="control-group">
        <label for="">管理费</label>
        <input type="text" name="data[manage_fee]" value="{!! $book->manage_fee or '' !!}" class="input-style" placeholder="输入管理费(选填)">
        <i class="input-icon">%</i>
    </div>
    <div class="control-group">
        <label for="">模板名称</label>
        <input type="text" name="data[template_name]" value="" class="input-style" placeholder="输入模板名称(选填)">
        <label class="control-option">
            <input type="checkbox" name="data[is_template]" value="1" /> 存为模板
        </label>
    </div>
    <div class="control-group">
        <label for="">备注</label>
        <textarea class="remark" name="data[remark]" cols="3" rows="10" placeholder="备注：不超过40字（选填）">{!! $book->remark or '' !!}</textarea>
    </div>
    <div class="control-group">
        <div class="total">
            预期收益<em class="num1" id="t_profit">{!! isset($stats['income'])?sprintf('%.2f',$stats['income']) : 0 !!}</em>
            预期利息<em class="num2" id="t_interest">{!! isset($stats['income'])?sprintf('%.2f',$stats['interest']) : 0 !!}</em>
            总奖励<em class="num3" id="t_reward">{!! isset($stats['reward'])?sprintf('%.2f', $stats['reward']):0 !!}</em>
            实际年化<em class="num1" id="t_rate">{!! isset($stats['rate'])?sprintf('%.2f', $stats['rate'] * 100):0 !!}%</em>
        </div>
    </div>
    <input type="submit" class="btn-blue btn-l btn-submit" value="提交">

