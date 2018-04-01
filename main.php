


<?php
//オートローダの指定
require_once __DIR__ . '/vendor/autoload.php';


$channelToken='wWl/v5Q4pIzUKTQHu1VWe/TOg5EyHoYr1ibfrRNOUBK1A7SO7IQAHbipRZxHTg7LW/ftb/JuSrmiUmzudZ7UE5UQs4RKDpM8F6uNufZjT+HyttLXfe2DI8UrP/pwrLT+s2DsLeVftHC3GhQegFns/wdB04t89/1O/w1cDnyilFU=';
$channelSecret='4d1d952f7c66b900ee9964ddf5db48eb';


//CurlHTTPClientとLINEBotのインスタンス化

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelToken);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

//署名の検証作業
$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
}


foreach ($events as $event) {
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    error_log('Non text message has come');
    continue;
  }
  $bot->replyText($event->getReplyToken(), $event->getText());
}
 ?>
