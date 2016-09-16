<?php
/*********************************************************************************
 *  PhpStorm - phpad
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By cw100.com
 * 模型相关操作
 *-------------------------------------------------------------------------------
 * $FILE:models.php
 * $Author:zxs
 * $Dtime:2016/9/10
 ***********************************************************************************/

/**
 * @param $models
 * @param $keys
 * 获取模型中的某些值数据
 */
function getMetas($models,$keys,$isModel=false) {
    foreach($models as $model) {
        if(array_key_exists ($model->meta_key, $keys)) {
            if($isModel) {
                $model->meta_value = unserialize($model->meta_value);
                $keys[$model->meta_key] = $model;
            } else {
                $keys[$model->meta_key] = unserialize($model->meta_value);
            }
        }
    }
    return $keys;
}

/**
 * @param $title
 * @param $body
 * @param int $ownerId
 * @param int $senderId
 * 发送消息
 */
function sendMessage($title,$body,$ownerId=0,$senderId=0) {
    if($ownerId != 0 ) {
        return \App\Models\MessageModel::sendGlobalMessage($title,$body);
    }
    return \App\Models\MessageModel::sendPrivateMessage($ownerId,$title,$body,$senderId);
}