<?php

const admin_true_login = [
    'email'    => 'root@guangda.work',
    'password' => '123456',
    'assert'   => '后台管理',

];
const admin_false_login = [
    'false_email'    => 'test1@163.com',
    'illegal_email'  => 'test',
    'false_password' => '1234567',
    'false_assert'   => '账号密码不匹配',
    'illegal_assert' => 'email 必须是一个有效的电子邮件地址。',
    'no_email'       => 'email 字段是必须的。',
    'no_pwd'         => 'password 字段是必须的。',
];
