<?php

/**
 * Copyright 2018 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace App\LIFF;

use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\Uri\AltUriBuilder;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Constant\Flex\BubleContainerSize;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpanComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FlexYoyakups
{
    /**
     * Create sample restaurant flex message
     *
     * @return \LINE\LINEBot\MessageBuilder\FlexMessageBuilder
     */
    // public static function get(
    //     $yoyaku_yoyaku_date, $yoyaku_yoyaku_time,
    //     $app_date, $type, $your_name, $your_kana, $your_email,
    //     $postal_code, $address_line, $tel, $pet_name, $pet_type, $pet_message, $pet_message2, 
    //     $pet_message3, $pet_message4, $pet_message5
    // )
    public static function get($yoyakuuser, $headerText = '診察予約 完了')
    {
        return FlexMessageBuilder::builder()
            ->setAltText($headerText)
            ->setContents(
                BubbleContainerBuilder::builder()
                    ->setHeader(self::createHeaderBlock($headerText))
                    ->setBody(self::createBodyBlock($yoyakuuser))
                    ->setSize('giga')
            );
    }

    private static function createHeaderBlock($headerText)
    {
        $title = TextComponentBuilder::builder()
            ->setText($headerText)
            ->setColor('#ffffff')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::LG);

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setBackgroundColor('#f69c9e')
            ->setContents([$title]);
    }

    private static function createHeroBlock()
    {
        return ImageComponentBuilder::builder()
            ->setUrl('https://happyplace.pet/Ver1.5/wp/wp-content/uploads/2022/12/eriri-mama-topimg.png')
            ->setSize(ComponentImageSize::FULL)
            ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
            ->setAspectMode(ComponentImageAspectMode::COVER)
            ->setAction(
                new UriTemplateActionBuilder(
                    null,
                    'https://happyplace.pet',
                    new AltUriBuilder('https://happyplace.pet')
                )
            );
    }

    private static function createBodyBlock($yoyakuuser)
    {
        $msg[] = TextComponentBuilder::builder()
            ->setText('以下の通りご予約を受け付けました。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $msg[] = TextComponentBuilder::builder()
            ->setText($yoyakuuser->yoyakujikan->yoyakubi->title.' '.$yoyakuuser->yoyakujikan->start_time_only)
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $msg[] = BoxComponentBuilder::builder()
                    ->setLayout(ComponentLayout::VERTICAL)
                    ->setMargin(ComponentMargin::MD)
                    ->setContents([]);

        $line = config('services.yoyaku_content_line');
        $text = str_replace('</p>', '', $line);
        $text = str_replace('<br>', '', $text);
        $array = explode('<p>', $text);
        array_shift($array);
        foreach($array as $item) {
            if(!empty(trim($item))) {
                $msg[] = TextComponentBuilder::builder()
                        ->setText(strip_tags(trim($item)))
                        ->setWeight(ComponentFontWeight::BOLD)
                        ->setSize(ComponentFontSize::SM);
            }else {
                $msg[] = BoxComponentBuilder::builder()
                        ->setLayout(ComponentLayout::VERTICAL)
                        ->setMargin(ComponentMargin::MD)
                        ->setContents([]);
            }
        }

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setBackgroundColor('#fafafa')
            ->setPaddingAll('8%')
            ->setContents($msg);

            //old from here
        
        

        $title103 = TextComponentBuilder::builder()
            ->setText('「ワンぱくHallowe’en撮影会」へのご予約')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title104 = TextComponentBuilder::builder()
            ->setText('誠にありがとうございます！')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);
        

        $title201 = TextComponentBuilder::builder()
            ->setText('当日はたくさんのワンちゃんがいらっしゃいます')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title202 = TextComponentBuilder::builder()
            ->setText('お時間には余裕を持って')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title203 = TextComponentBuilder::builder()
            ->setText('お集まりいただけますと幸いです。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title204 = TextComponentBuilder::builder()
            ->setText('⋆┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈⋆')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title205 = TextComponentBuilder::builder()
            ->setText('・木場公園内KIBACOカフェへお越しいただき 、')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title206 = TextComponentBuilder::builder()
            ->setText('  予約情報をスタッフへお伝えください。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title207 = TextComponentBuilder::builder()
            ->setText('・基本料金2,200円（税込）をお支払いください。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title208 = TextComponentBuilder::builder()
            ->setText('・その後、購入レシートを持って、')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title209 = TextComponentBuilder::builder()
            ->setText('　　ハピプレ撮影ブースまでお越しください。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title210 = TextComponentBuilder::builder()
            ->setText('・ワンドリンク、わんちゃんパンは')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);
        
        $title211 = TextComponentBuilder::builder()
            ->setText('”撮影後”の受け取りになります。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);


        $title301 = TextComponentBuilder::builder()
            ->setText('通常プラン「追加特典付き」又は')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title302 = TextComponentBuilder::builder()
            ->setText('プレミアムプラン(先着予約制)をご利用の方は')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title303 = TextComponentBuilder::builder()
            ->setText('別途、追加料金分を撮影ブースにて頂戴いたします。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title304 = TextComponentBuilder::builder()
            ->setText('⋆┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈⋆')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title401 = TextComponentBuilder::builder()
            ->setText('持ち込み小物！ハロウィン仮装！大歓迎です🎃✨')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title4011 = TextComponentBuilder::builder()
            ->setText('やむを得ない事情が発生し、')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title4012 = TextComponentBuilder::builder()
            ->setText('時間変更やキャンセルがある場合は ')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title402 = TextComponentBuilder::builder()
            ->setText('LINEトークルーム')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title403 = TextComponentBuilder::builder()
            ->setText('または')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title404 = TextComponentBuilder::builder()
            ->setText('07031061227')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title405 = TextComponentBuilder::builder()
            ->setText('「木場公園イベントスタッフ宛」')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title406 = TextComponentBuilder::builder()
            ->setText('までご連絡ください。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);


        $title501 = TextComponentBuilder::builder()
            ->setText('当日、天候によってはやむおえず撮影を')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title502 = TextComponentBuilder::builder()
            ->setText('中止とさせていただく場合がございますので')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title503 = TextComponentBuilder::builder()
            ->setText('ご了承ください。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);


        $title601 = TextComponentBuilder::builder()
            ->setText('その際はご連絡をさせていただきます。 ')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $title602 = TextComponentBuilder::builder()
            ->setText('お会いできることを楽しみにお待ちしております')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::SM);

        $setMargin = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setMargin(ComponentMargin::MD)
            ->setContents([]);

            
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setBackgroundColor('#fafafa')
            ->setPaddingAll('8%')
            ->setContents([$title101, $title102, $setMargin, $title103, $title104, $setMargin,
                $title201, $title202, $title203, $setMargin, $title204, $title205, $title206, $title207, $title208, 
                $title209, $title210, $title211, $setMargin,
                $title301, $title302, $title303, $title304, $setMargin,
                $title401, $setMargin, $title4011, $title4012, $title402, $title403, $title404, $title405, $title406, $setMargin,
                $title501, $title502, $title503, 
                $title601, $setMargin, $title602,
            ]);
    }

    private static function createFooterBlock($yoyakuuser)
    {
        $footer = TextComponentBuilder::builder()
            ->setText('やむを得ない理由でのキャンセルはこちら')
            ->setColor('#aaaaaa')
            ->setWrap(true)
            ->setAlign('center')
            ->setSize(ComponentFontSize::XS);

     
        $cancelButton = ButtonComponentBuilder::builder()
            ->setStyle(ComponentButtonStyle::SECONDARY)
            ->setHeight(ComponentButtonHeight::SM)
            ->setMargin(ComponentMargin::MD)
            ->setAction(
                new UriTemplateActionBuilder(
                    'キャンセル',
                    'https://liff.line.me/'.config('services.line.message.liffId').'/appointment-cancel/'.$yoyakuuser->token_id,
                    new AltUriBuilder('https://liff.line.me/'.config('services.line.message.liffId').'/appointment-cancel/'.$yoyakuuser->token_id)
                )
            );
       
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$footer, $cancelButton]);
    }
}
