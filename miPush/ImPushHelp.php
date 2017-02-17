<?php

/**
 * @author xlc
 * @name ImPushHelp
 *
 */
use xmpush\Builder;
use xmpush\IOSBuilder;
use xmpush\HttpBase;
use xmpush\Sender;
use xmpush\Constants;
use xmpush\Stats;
use xmpush\Tracer;
use xmpush\Feedback;
use xmpush\DevTools;
use xmpush\Subscription;
use xmpush\TargetedMessage;
include_once(dirname(__FILE__) . '/sdk/autoload.php');

class ImPushHelp {

    const TYPE_ANDROID = 0; //android类型
    const TYPE_IOS = 1;    //ios类型

    private $android_app_secret = "";
    private $android_app_package = "";
    private $ios_app_secret = "";
    private $ios_app_bundleId = "";
    private $sender = null;

    public function ImPushHelp() {
        
    }

    //设备AndroidApp信息
    public function setAndroidAppInformatioin($secret, $package) {
        $this->android_app_package = $package;
        $this->android_app_secret = $secret;
        Constants::setPackage($this->android_app_package);
        Constants::setSecret($this->android_app_secret);
        $this->createSender();
    }

    //设备iosApp的信息
    public function setIosAppInformation($secret, $bundleId) {
        $this->ios_app_secret = $secret;
        $this->ios_app_bundleId = $bundleId;
        Constants::setBundleId($this->ios_app_bundleId);
        Constants::setSecret($this->ios_app_secret);
        $this->createSender();
    }

    //创建Sender对象
    private function createSender() {
        $this->sender = new Sender();
    }

    //向所有设备发送消息
    public function broadcastAll($title, $desc, $payload, $systemType, $timeToSend = 0) {
        $message = $this->createMessage($title, $desc, $payload, $systemType, $timeToSend);
        $result = $this->sender->broadcastAll($message)->getRaw();
        return $result;
    }

    //创建消息内容
    private function createMessage($title, $desc, $payload, $systemType, $timeToSend = 0) {
        $message = null;
        if ($systemType == self::TYPE_ANDROID) {
            $message = $this->createAndroidMessage($title, $desc, $payload, $timeToSend);
        } else if ($systemType == self::TYPE_IOS) {
            $message = $this->createIosMessage($desc, $payload, $timeToSend);
        }
        return $message;
    }

    //向单一指定用户发送消息
    public function send($title, $desc, $payload, $regId, $systemType, $timeToSend = 0) {
        $message = $this->createMessage($title, $desc, $payload, $systemType, $timeToSend);
        $result = $this->sender->send($message, $regId)->getRaw();
        return $result;
    }

    //创建android的消息体
    private function createAndroidMessage($title, $desc, $payload, $timeToSend = 0) {
        $message = new Builder();
        $message->title($title);  // 通知栏的title
        $message->description($desc); // 通知栏的descption
        $message->passThrough(0);  // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和descption两个参数
        $message->payload($payload); // 携带的数据，点击后将会通过客户端的receiver中的onReceiveMessage方法传入。
        $message->extra(Builder::notifyForeground, 1); // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
        $message->notifyId(2); // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
        if ($timeToSend >= time()) { //是否设备为定时推送
            $message->timeToSend($timeToSend * 1000);
        }
        $message->build();
        return $message;
    }

    //创建ios的消息体
    private function createIosMessage($desc, $payload, $timeToSend = 0) {
        $message = new IOSBuilder();
        $message->description($desc);
        $message->soundUrl('default');
        $message->badge('4');
        $message->extra('payload', $payload);
        if ($timeToSend >= time()) { //是否设备为定时推送
            $message->timeToSend($timeToSend * 1000);
        }
        $message->build();
        return $message;
    }
}
?>
