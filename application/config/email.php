<?php
/**
 * Created by PhpStorm.
 * User: dongdong
 * Date: 16-3-9
 * Time: 下午7:26
 */
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.126.com';
$config['smtp_user'] = 'wangdong95@126.com';//这里写上你的163邮箱账户
$config['smtp_pass'] = '550965989';//这里写上你的163邮箱密码
$config['mailtype'] = 'html';
$config['validate'] = true;
$config['priority'] = 1;
$config['crlf']  = "\r\n";
$config['smtp_port'] = 25;
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;