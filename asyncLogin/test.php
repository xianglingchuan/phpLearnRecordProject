<?php
session_start();
include 'asyncLogin.class.php';
$asyncLoginClass = new asyncLogin();
//设置cookie保存路径 
$cookie = dirname(__FILE__) . '/cookie_18513584012.txt';
echo $_SESSION['token'];
$token = $_SESSION['token'];
//获取登录页的信息 
$user_id = 82;
$url = "http://ucenter.snaillove.com/interfaces/user/index/verify-user?user_id={$user_id}&token={$token}";
$content = $asyncLoginClass->get_content($url, $cookie); 
var_dump($content);
?>