<?php

include 'ImPushHelp.php';

$ImPushHelp = new ImPushHelp();
$title = '你好';
$desc = 'php to regId 这是一条mipush推送消息';
$payload = '{"test":1,"ok":"It\'s a string"}';
$secret = '3fSLWUZLVvfg6UOKNCnHyw==';
$package = 'com.snaillove.test';

$ImPushHelp->setAndroidAppInformatioin($secret, $package);
$result = $ImPushHelp->broadcastAll($title, $desc, $payload, ImPushHelp::TYPE_ANDROID);
var_dump($result);
echo "<BR><BR>";

$regId = "00Z+fht3K9/hO+/chMpoOlwb+BuHTWyVF0Qk0/zKt/4=";
$result = $ImPushHelp->send($title, $desc, $payload, $regId, ImPushHelp::TYPE_ANDROID);
var_dump($result);
?>
