<?php
session_start();
include 'asyncLogin.class.php';

$asyncLoginClass = new asyncLogin();
//设置post的数据 
$post = array (  
); 
//登录地址 
$url = "http://ucenter.snaillove.com/interfaces/user/index/login?phone=18513584012&password=111111&source=snail_relax";
//设置cookie保存路径 
$cookie = dirname(__FILE__) . '/cookie_18513584012.txt'; 
//登录后要获取信息的地址 
//模拟登录
$result = $asyncLoginClass->login_post($url, $cookie, $post); 
$objectJson = json_decode($result);
$token = $objectJson->content->info->token;
echo $token;
$_SESSION['token'] = $token;
