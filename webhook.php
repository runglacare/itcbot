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
$events = json_decode($content, true); // content สิ่งที่เราพิม เข้าไปใน line (เก็บแบบ array)
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


                case "สื่อ โรคและภัย":
                case "info โรคและภัย":
                case "infographic โรคและภัย":
                case "info โรคและภัย":
                case "infographic":
                case "สื่อเผยแพร่":
                case "อินโฟกราฟฟิค":
                


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
                                            'https://cloud.ddc.moph.go.th/index.php/apps/files_sharing/ajax/publicpreview.php?x=1366&y=226&a=true&file=journal%2520copy.jpg&t=NSAVej1qSEVi6Pp&scalingup=0',
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

            case "วารสารสื่อสารความเสี่ยง":
            case "วารสารออนไลน์":
            case "วารสาร":
            case "สิ่งพิมพ์ล่าสุด":
            case "โปสเตอร์":
            case "แผ่นพับ/แผ่นปลิว":
            case "สติ๊กเกอร์":
            case "แบนเนอร์/powerpoint":
            case "คู่มือ/หนังสือ":
            case "roll up":
            case "หนังสือพิมพ์/นิตยสาร":
            case "จุลสาร":
            case "สิ่งพิมพ์อื่นๆ":
            case "โรลอัพ":
                            $actionBuilder1 = array(
                              new UriTemplateActionBuilder(
                                    'สิ่งพิมพ์ล่าสุด', // ข้อความแสดงในปุ่ม
                                    'https://www.riskcomthai.org/th/media/publication/lastest.php'
                                  )
                              );
                            $actionBuilder2 = array(
                                new UriTemplateActionBuilder(
                                      'โปสเตอร์', // ข้อความแสดงในปุ่ม
                                      'https://www.riskcomthai.org/th/media/publication/poster.php'
                                  )
                              );
                              $actionBuilder3 = array(
                                  new UriTemplateActionBuilder(
                                        'แผ่นพับ/แผ่นปลิว', // ข้อความแสดงในปุ่ม
                                        'https://www.riskcomthai.org/th/media/publication/brochure.php'
                                  )
                              );
                              $actionBuilder4 = array(
                                    new UriTemplateActionBuilder(
                                          'สติ๊กเกอร์', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/sticker.php'
                                  )
                              );
                              $actionBuilder5 = array(
                                    new UriTemplateActionBuilder(
                                          'แบนเนอร์/powerpoint', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/banner.php'
                                  )
                              );
                              $actionBuilder6 = array(
                                    new UriTemplateActionBuilder(
                                          'คู่มือ/หนังสือ', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/manual.php'
                                  )
                              );
                              $actionBuilder7 = array(
                                    new UriTemplateActionBuilder(
                                          'roll up', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/roll-up.php'
                                  )
                              );
                              $actionBuilder8 = array(
                                    new UriTemplateActionBuilder(
                                          'หนังสือพิมพ์/นิตยสาร', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/newspaper.php'
                                  )
                              );
                              $actionBuilder9 = array(
                                    new UriTemplateActionBuilder(
                                          'จุลสาร', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/booklet.php'
                                  )
                              );
                              $actionBuilder10 = array(
                                    new UriTemplateActionBuilder(
                                          'สิ่งพิมพ์อื่นๆ', // ข้อความแสดงในปุ่ม
                                          'https://www.riskcomthai.org/th/media/publication/other.php'
                                  )
                              );


                            $replyData = new TemplateMessageBuilder('Carousel',
                                         new CarouselTemplateBuilder(
                                            array(
                                                new CarouselColumnTemplateBuilder(
                                                    'สิ่งพิมพ์ล่าสุด',
                                                    'รายละเอียด-สิ่งพิมพ์ล่าสุด',
                                                    'https://cloud.ddc.moph.go.th/index.php/apps/files_sharing/ajax/publicpreview.php?x=1366&y=226&a=true&file=info%2520copy.jpg&t=or85ojZnVE5BolT&scalingup=0',
                                                    $actionBuilder1
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'โปสเตอร์',
                                                    'รายละเอียด-โปสเตอร์',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/epidemic-bg.jpg',
                                                    $actionBuilder2
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'แผ่นพับ/แผ่นปลิว',
                                                    'รายละเอียด-แผ่นพับ/แผ่นปลิว',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/health-bg.jpg',
                                                    $actionBuilder3
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'สติ๊กเกอร์',
                                                    'รายละเอียด-สติ๊กเกอร์',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                    $actionBuilder4
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'แบนเนอร์/powerpoint',
                                                    'รายละเอียด-แบนเนอร์/powerpoint',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                    $actionBuilder5
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'คู่มือ/หนังสือ',
                                                    'รายละเอียด-คู่มือ/หนังสือ',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                    $actionBuilder6
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'roll up',
                                                    'รายละเอียด-roll up',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                    $actionBuilder7
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'หนังสือพิมพ์/นิตยสาร',
                                                    'รายละเอียด-หนังสือพิมพ์/นิตยสาร',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                    $actionBuilder8
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'จุลสาร',
                                                    'รายละเอียด-จุลสาร',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                    $actionBuilder9
                                                ),
                                                new CarouselColumnTemplateBuilder(
                                                    'สิ่งพิมพ์อื่นๆ',
                                                    'รายละเอียด-สิ่งพิมพ์อื่นๆ',
                                                    'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                     $actionBuilder10

                                                ),
                                          )
                                      )
                                  );

                            break;

                                                case "คลิป โรคและภัย":
                                                case "clipโรคและภัย":
                                                case "mediaโรคและภัย":
                                                case "videoโรคและภัย":
                                                case "vdoโรคและภัย":
                                                case "วีดีโอโรคและภัย":
                                                case "ภาพเคลื่อนไหว โรคและภัย":
                                                case "มีเดียร์ โรคและภัย":
                                                case "มีเดีย โรคและภัย":
                                                case "สื่อโทรทัศน์ล่าสุด":
                                                case "สารคดีทางโทรทัศน์":
                                                case "สปอตโทรทัศน์":
                                                case "รายการโทรทัศน์":
                                                case "สกู๊ปข่าว":
                                                case "ข่าวโทรทัศน์":
                                                case "สื่อโทรทัศน์อื่นๆ":
                                                case "สื่อวิทยุล่าสุด":
                                                case "สปอตวิทยุ":
                                                case "สนทนาทางวิทยุ":
                                                case "สารคดีทางวิทยุ":
                                                case "สื่อวิทยุอื่นๆ":
                                                case "vdo":
                                                case "สื่อมัลติมีเดีย":


                                                    $actionBuilder1 = array(
                                                      new UriTemplateActionBuilder(
                                                            'สื่อโทรทัศน์ล่าสุด', // ข้อความแสดงในปุ่ม
                                                            'https://www.riskcomthai.org/th/media/tv/lastest.php'
                                                          )
                                                      );
                                                      $actionBuilder2 = array(
                                                        new UriTemplateActionBuilder(
                                                              'สารคดีทางโทรทัศน์', // ข้อความแสดงในปุ่ม
                                                              'https://www.riskcomthai.org/th/media/tv/documentary.php'
                                                          )
                                                        );
                                                      $actionBuilder3 = array(
                                                          new UriTemplateActionBuilder(
                                                                'สปอตโทรทัศน์', // ข้อความแสดงในปุ่ม
                                                                'https://www.riskcomthai.org/th/media/tv/spot.php'
                                                            )
                                                          );
                                                      $actionBuilder4 = array(
                                                            new UriTemplateActionBuilder(
                                                                  'รายการโทรทัศน์', // ข้อความแสดงในปุ่ม
                                                                  'https://www.riskcomthai.org/th/media/tv/tv.php'
                                                              )
                                                            );

                                                      $actionBuilder5 = array(
                                                            new UriTemplateActionBuilder(
                                                                  'สกู๊ปข่าว', // ข้อความแสดงในปุ่ม
                                                                  'https://www.riskcomthai.org/th/media/tv/news-scoop.php'
                                                              )
                                                            );
                                                      $actionBuilder6 = array(
                                                            new UriTemplateActionBuilder(
                                                                  'ข่าวโทรทัศน์', // ข้อความแสดงในปุ่ม
                                                                  'https://www.riskcomthai.org/th/media/tv/tv-news.php'
                                                              )
                                                            );
                                                      $actionBuilder7 = array(
                                                            new UriTemplateActionBuilder(
                                                                  'สื่อวิทยุล่าสุด', // ข้อความแสดงในปุ่ม
                                                                  'https://www.riskcomthai.org/th/media/radio/lastest.php'
                                                              )
                                                            );

                                                      $actionBuilder8 = array(
                                                                new UriTemplateActionBuilder(
                                                                      'สปอตวิทยุ', // ข้อความแสดงในปุ่ม
                                                                      'https://www.riskcomthai.org/th/media/radio/spot.php'
                                                                  )
                                                                );
                                                      $actionBuilder9 = array(
                                                                  new UriTemplateActionBuilder(
                                                                        'สนทนาทางวิทยุ', // ข้อความแสดงในปุ่ม
                                                                        'https://www.riskcomthai.org/th/media/radio/conversations.php'
                                                                    )
                                                                  );

                                                      $actionBuilder10 = array(
                                                                  new UriTemplateActionBuilder(
                                                                        'สารคดีทางวิทยุ', // ข้อความแสดงในปุ่ม
                                                                        'https://www.riskcomthai.org/th/media/radio/documentary.php'
                                                                    )
                                                                  );
                                                      // $actionBuilder11 = array(
                                                      //             new UriTemplateActionBuilder(
                                                      //                   'สื่อวิทยุอื่นๆ', // ข้อความแสดงในปุ่ม
                                                      //                   'https://www.riskcomthai.org/th/media/radio/other.php'
                                                      //               )
                                                      //             );


                                                      $replyData = new TemplateMessageBuilder('Carousel',
                                                                   new CarouselTemplateBuilder(
                                                                    array(
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สื่อโทรทัศน์ล่าสุด',
                                                                            'รายละเอียด-สื่อโทรทัศน์ล่าสุด',
                                                                            'https://cloud.ddc.moph.go.th/index.php/apps/files_sharing/ajax/publicpreview.php?x=1366&y=226&a=true&file=info%2520copy.jpg&t=or85ojZnVE5BolT&scalingup=0',
                                                                            $actionBuilder1
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สารคดีทางโทรทัศน์',
                                                                            'รายละเอียด-สารคดีทางโทรทัศน์',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/epidemic-bg.jpg',
                                                                            $actionBuilder2
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สปอตโทรทัศน์',
                                                                            'รายละเอียด-สปอตโทรทัศน์',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/health-bg.jpg',
                                                                            $actionBuilder3
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'รายการโทรทัศน์',
                                                                            'รายละเอียด-รายการโทรทัศน์',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                            $actionBuilder4
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สกู๊ปข่าว',
                                                                            'รายละเอียด-สกู๊ปข่าว',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                            $actionBuilder5
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'ข่าวโทรทัศน์',
                                                                            'รายละเอียด-ข่าวโทรทัศน์',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                            $actionBuilder6
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สื่อวิทยุล่าสุด',
                                                                            'รายละเอียด-สื่อวิทยุล่าสุด',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                            $actionBuilder7
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สปอตวิทยุ',
                                                                            'รายละเอียด-สปอตวิทยุ',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/health-bg.jpg',
                                                                            $actionBuilder8
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สนทนาทางวิทยุ',
                                                                            'รายละเอียด-สนทนาทางวิทยุ',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                            $actionBuilder9
                                                                        ),
                                                                        new CarouselColumnTemplateBuilder(
                                                                            'สารคดีทางวิทยุ',
                                                                            'รายละเอียด-สารคดีทางวิทยุ',
                                                                            'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                            $actionBuilder10
                                                                        )
                                                                        // new CarouselColumnTemplateBuilder(
                                                                        //     'สื่อวิทยุอื่นๆ',
                                                                        //     'รายละเอียด-สื่อวิทยุอื่นๆ',
                                                                        //     'https://www.riskcomthai.org/images/theme2/page/home/media-bg.jpg',
                                                                        //     $actionBuilder11
                                                                        // )
                                                                    )
                                                                )
                                                          );


                                                      break;

                case "i":
                    $picFullSize = 'https://www.mywebsite.com/imgsrc/photos/f/simpleflower';
                    $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/simpleflower/240';
                    $replyData = new ImageMessageBuilder($picFullSize,$picThumbnail);
                    break;
                case "v":
                    $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/240';
                    $videoUrl = "https://www.mywebsite.com/simplevideo.mp4";
                    $replyData = new VideoMessageBuilder($videoUrl,$picThumbnail);
                    break;
                case "a":
                    $audioUrl = "https://www.mywebsite.com/simpleaudio.mp3";
                    $replyData = new AudioMessageBuilder($audioUrl,27000);
                    break;
                case "l":
                    $placeName = "ที่ตั้งร้าน";
                    $placeAddress = "แขวง พลับพลา เขต วังทองหลาง กรุงเทพมหานคร ประเทศไทย";
                    $latitude = 13.780401863217657;
                    $longitude = 100.61141967773438;
                    $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);
                    break;
                case "s":
                    $stickerID = 22;
                    $packageID = 2;
                    $replyData = new StickerMessageBuilder($packageID,$stickerID);
                    break;
                case "im":
                    $imageMapUrl = 'https://www.mywebsite.com/imgsrc/photos/w/sampleimagemap';
                    $replyData = new ImagemapMessageBuilder(
                        $imageMapUrl,
                        'This is Title',
                        new BaseSizeBuilder(699,1040),
                        array(
                            new ImagemapMessageActionBuilder(
                                'test image map',
                                new AreaBuilder(0,0,520,699)
                                ),
                            new ImagemapUriActionBuilder(
                                'http://www.ninenik.com',
                                new AreaBuilder(520,0,520,699)
                                )
                        ));
                    break;
                case "tm":
                    $replyData = new TemplateMessageBuilder('Confirm Template',
                        new ConfirmTemplateBuilder(
                                'Confirm template builder',
                                array(
                                    new MessageTemplateActionBuilder(
                                        'Yes',
                                        'Text Yes'
                                    ),
                                    new MessageTemplateActionBuilder(
                                        'No',
                                        'Text NO'
                                    )
                                )
                        )
                    );
                    break;
                case "สถานการณ์โรค":
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder1 = array(
                          new UriTemplateActionBuilder(
                                'สถานการณ์โรค', // ข้อความแสดงในปุ่ม
                                'https://flu.ddc.moph.go.th/bot/chart.php?disease_code=26-27-66'
                            ),
                          new UriTemplateActionBuilder(
                                'อาการของโรค', // ข้อความแสดงในปุ่ม
                                'https://ddc.moph.go.th/th/site/disease/detail/44/symptom'
                            ),
                        );
                        $actionBuilder2 = array(
                              // new PostbackTemplateActionBuilder(
                              //     'สถาณการณ์โรค', // ข้อความแสดงในปุ่ม
                              //     http_build_query(array(
                              //         'disease_code'=>'11',
                              //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                              //     'สถานการณ์-โรคมือเท้าปาก'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                              // ),
                              new UriTemplateActionBuilder(
                                    'สถานการณ์โรค', // ข้อความแสดงในปุ่ม
                                    'https://flu.ddc.moph.go.th/bot/chart.php?disease_code=71'
                                ),
                              new UriTemplateActionBuilder(
                                    'อาการของโรค', // ข้อความแสดงในปุ่ม
                                    'https://ddc.moph.go.th/th/site/disease/detail/11/symptom'
                                ),
                        );
                        $actionBuilder3 = array(
                                  // new PostbackTemplateActionBuilder(
                                  //     'สถาณการณ์โรค', // ข้อความแสดงในปุ่ม
                                  //     http_build_query(array(
                                  //         'disease_code'=>'13',
                                  //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                                  //     'สถานการณ์โรค'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                                  // ),
                                  new UriTemplateActionBuilder(
                                        'สถานการณ์โรค', // ข้อความแสดงในปุ่ม
                                        'https://flu.ddc.moph.go.th/bot/chart.php?disease_code=15'
                                    ),
                                  new UriTemplateActionBuilder(
                                        'อาการของโรค', // ข้อความแสดงในปุ่ม
                                        'https://ddc.moph.go.th/th/site/disease/detail/13/symptom'
                                    )
                        );
                        $replyData = new TemplateMessageBuilder('Carousel',
                            new CarouselTemplateBuilder(
                                array(
                                    new CarouselColumnTemplateBuilder(
                                        'โรคไข้เลือดออก',
                                        'รายละเอียด-โรคไข้เลือดออก',
                                        'https://flu.ddc.moph.go.th/image-line/dhf_c.jpg',
                                        $actionBuilder1
                                    ),
                                    new CarouselColumnTemplateBuilder(
                                        'โรคมือเท้าปาก',
                                        'รายละเอียด-โรคมือเท้าปาก',
                                        'https://flu.ddc.moph.go.th/image-line/hfm_c.jpg',
                                        $actionBuilder2
                                    ),
                                    new CarouselColumnTemplateBuilder(
                                        'โรคไข้หวัดใหญ่',
                                        'รายละเอียด-โรคไข้หวัดใหญ่',
                                        'https://flu.ddc.moph.go.th/image-line/flu_c.jpg',
                                        $actionBuilder3
                                    )
                                )
                            )
                        );
                    break;



                // // $textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
                // // $replyData = new TextMessageBuilder($textReplyMessage);
                // break;


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
  $response = $bot->replyMessage($replyToken,$replyData); //token to see who is ..
}

echo "OK";
