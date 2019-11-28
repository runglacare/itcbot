<?php // callback.php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";
require_once('setting.php');

///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\AccountLinkEvent;
use LINE\LINEBot\Event\MemberJoinEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');

// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
$replyData = NULL;
$replyToken = NULL;
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    $userMessage = strtolower($userMessage);
    switch ($typeMessage){
        case 'text':
            switch ($userMessage) {
                case "t":
                    $textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;


                // case "i":
                //     $picFullSize = 'https://www.riskcomthai.org/images/DPC2/Infographic%20By%20Yutta/Info_TB-%E0%B9%81%E0%B8%81%E0%B9%89%E0%B9%84%E0%B8%8224032562_600_849.jpg';
                //     $picThumbnail = 'https://www.riskcomthai.org/images/DPC2/Infographic%20By%20Yutta/Info_TB-%E0%B9%81%E0%B8%81%E0%B9%89%E0%B9%84%E0%B8%8224032562_600_849.jpg';
                //     $replyData = new ImageMessageBuilder($picFullSize,$picThumbnail);
                //     break;
                case "v":
                    $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/240';
                    $videoUrl = "https://www.mywebsite.com/simplevideo.mp4";
                    $replyData = new VideoMessageBuilder($videoUrl,$picThumbnail);
                    break;
                // case "a":
                //     $audioUrl = "https://www.mywebsite.com/simpleaudio.mp3";
                //     $replyData = new AudioMessageBuilder($audioUrl,27000);
                //     break;
                // case "l":
                //     $placeName = "ที่ตั้งร้าน";
                //     $placeAddress = "แขวง พลับพลา เขต วังทองหลาง กรุงเทพมหานคร ประเทศไทย";
                //     $latitude = 13.780401863217657;
                //     $longitude = 100.61141967773438;
                //     $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);
                //     break;
                
                // case "care":
                //     $careReplyMessage = "รุ้งลาวัลย์";
                //     $replyData = new TextMessageBuilder($careReplyMessage);
                //     break;
                // case "s":
                //     $stickerID = 22;
                //     $packageID = 2;
                //     $replyData = new StickerMessageBuilder($packageID,$stickerID);
                //     break;

                

                case "สื่อ โรคและภัย":
                case "info โรคและภัย":
                case "infographic โรคและภัย":
                case "info โรคและภัย":
                case "infographic":
                case "สื่อเผยแพร่":
                case "อินโฟกราฟฟิค":
                case "สื่อมัลติมีเดีย":


                    $actionBuilder1 = array(
                      new UriTemplateActionBuilder(
                            'สื่ออินโฟกราฟฟิค', // ข้อความแสดงในปุ่ม
                            'http://203.157.41.80/riskcomthai/infographic.php'
                          )
                      );
                      $actionBuilder2 = array(
                        new UriTemplateActionBuilder(
                              'สื่อมัลติมีเดีย', // ข้อความแสดงในปุ่ม
                              'http://203.157.41.80/riskcomthai/mediavdo.php'
                          )
                        );
                      $actionBuilder3 = array(
                          new UriTemplateActionBuilder(
                                'วารสารออนไลน์', // ข้อความแสดงในปุ่ม
                                'http://203.157.41.80/riskcomthai/journal.php'
                            )
                          );
                      // $actionBuilder4 = array(
                      //       new UriTemplateActionBuilder(
                      //             'มัลติมีเดีย', // ข้อความแสดงในปุ่ม
                      //             'https://www.riskcomthai.org/th/media/radio/lastest.php'
                      //         )
                      //       );
                    $replyData = new TemplateMessageBuilder('Carousel',
                                new CarouselTemplateBuilder(
                                    array(
                                        new CarouselColumnTemplateBuilder(
                                            'สื่ออินโฟกราฟฟิค',
                                            'รายละเอียด สื่ออินโฟกราฟฟิค',
                                            'https://cloud.ddc.moph.go.th/index.php/apps/files_sharing/ajax/publicpreview.php?x=1366&y=226&a=true&file=info%2520copy.jpg&t=or85ojZnVE5BolT&scalingup=0',
                                            $actionBuilder1
                                        ),
                                        new CarouselColumnTemplateBuilder(
                                            'สื่อมัลติมีเดีย',
                                            'รายละเอียด-สื่อมัลติมีเดีย',
                                            'https://www.riskcomthai.org/images/theme2/page/home/epidemic-bg.jpg',
                                            $actionBuilder2
                                        ),
                                        new CarouselColumnTemplateBuilder(
                                            'วารสารออนไลน์',
                                            'รายละเอียด วารสารออนไลน์',
                                            'https://www.riskcomthai.org/images/theme2/page/home/health-bg.jpg',
                                            $actionBuilder3
                                        ),
                                        // new CarouselColumnTemplateBuilder(
                                        //     'มัลติมีเดีย',
                                        //     'รายละเอียด มัลติมีเดีย',
                                        //     'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                        //     $actionBuilder4
                                        // )
                                    )
                                )
                            );


                    break;

                    
                default:
                    $textReplyMessage = " คุณไม่ได้พิมพ์ ค่า ตามที่กำหนด";
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    break;
            }
            break;
        default:
            $textReplyMessage = json_encode($events);
            $replyData = new TextMessageBuilder($textReplyMessage);
            break;
    }
}
//l ส่วนของคำสั่งตอบกลับข้อความ
if(isset($replyToken) && $replyData){
  $response = $bot->replyMessage($replyToken,$replyData);
}

echo "OK";


?>