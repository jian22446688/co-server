<?php
// +----------------------------------------------------------------------
// | d_comment [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 DaliyCode All rights reserved.
// +----------------------------------------------------------------------
// | Author: DaliyCode <3471677985@qq.com> <author_url:dalicode.com>
// +----------------------------------------------------------------------
return array(
    'comment_type'     => array(
        'title'   => '是否开启:',
        'type'    => 'radio',
        'options' => [
            '1' => '开',
            '2' => '关',
        ],
        'value'   => '1',
    ),
    'comment_check'    => array(
        'title'   => '开启审核:',
        'type'    => 'radio',
        'options' => [
            '1' => '是',
            '2' => '否',
        ],
        'value'   => '2',
        'tip'     => '开启，则评论需要审核才会显示',
    ),
    'comment_interval' => array(
        'title' => '评论间隔:',
        'type'  => 'number',
        'value' => '5',
        'tip'   => '单位秒，每次评论间隔时间',
    ),
);
