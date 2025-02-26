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
class FlexYoyaku
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
                    ->setFooter(self::createFooterBlock($yoyakuuser))
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
        $title1 = TextComponentBuilder::builder()
            ->setText('ご予約ありがとうございます。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::MD);
        $title2 = TextComponentBuilder::builder()
            ->setText('下記の日程にて、お待ちしております。')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::MD);
        $setMargin = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setMargin(ComponentMargin::MD)
            ->setContents([]);

        $yoyaku_app_date = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ご予約お時間')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText(' ')
                    ->setWrap(true)
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
                    ->setContents([
                        SpanComponentBuilder::builder()
                            ->setText($yoyakuuser->yoyakujikan->yoyakubi->title),
                        SpanComponentBuilder::builder()
                            ->setText(' ')
                            ->setSize(ComponentFontSize::XS),
                        SpanComponentBuilder::builder()
                            ->setText($yoyakuuser->yoyakujikan->format_time),
                    ])
            ]);
        $yoyaku_type = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('予約の種類')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->yoyakutype->title)
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_your_name = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('お名前')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->your_name)
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_your_kana = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('フリガナ')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->your_kana)
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_your_email = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('メールアドレス')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                     ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->your_email!=NULL?$yoyakuuser->your_email:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_postal_code = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('郵便番号')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                     ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->postal_code)
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_address_line = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('住所')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->address_line!=null?$yoyakuuser->address_line:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_tel = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('電話番号')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->tel != null? $yoyakuuser->tel:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_name = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ペットのお名前')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_name != NULL?$yoyakuuser->pet_name:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_type = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ペットの種類')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_type != NULL ? $yoyakuuser->pet_type:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_message = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ペットの種類詳細')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_message != NULL ? $yoyakuuser->pet_message:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_message2 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('症状')
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setWrap(true)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_message2 != NULL?$yoyakuuser->pet_message2:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_message3 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('既往歴')
                    ->setWrap(true)
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_message3 != NULL ? $yoyakuuser->pet_message3:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_message4 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('現在使用している薬')
                    ->setWrap(true)
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_message4 != NULL?$yoyakuuser->pet_message4:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

        $yoyaku_pet_message5 = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('ご要望・その他')
                    ->setWrap(true)
                    ->setWeight(ComponentFontWeight::BOLD)
                    ->setSize(ComponentFontSize::SM)
                    ->setColor('#666666')
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText($yoyakuuser->pet_message5 != NULL?$yoyakuuser->pet_message5:'なし')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(2)
            ]);

            $yoyaku_info = BoxComponentBuilder::builder()
                ->setLayout(ComponentLayout::VERTICAL)
                ->setMargin(ComponentMargin::LG)
                ->setSpacing(ComponentSpacing::SM)
                ->setContents([$yoyaku_app_date, $yoyaku_type, $yoyaku_your_name, $yoyaku_your_kana, $yoyaku_your_email, $yoyaku_postal_code, $yoyaku_address_line, $yoyaku_tel, 
                    $yoyaku_pet_name, $yoyaku_pet_type, 
                    $yoyaku_pet_message, $yoyaku_pet_message2, $yoyaku_pet_message3, $yoyaku_pet_message4, $yoyaku_pet_message5]);
        

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setBackgroundColor('#fafafa')
            ->setPaddingAll('8%')
            ->setContents([$title1, $title2, $setMargin, $yoyaku_info]);
    }

    private static function createFooterBlock($yoyakuuser)
    {
        $footer = TextComponentBuilder::builder()
            ->setText('日程の変更やキャンセルの場合、')
            ->setColor('#aaaaaa')
            ->setWrap(true)
            ->setAlign('center')
            ->setSize(ComponentFontSize::XS);

        $changeButton = ButtonComponentBuilder::builder()
            ->setStyle(ComponentButtonStyle::PRIMARY)
            ->setHeight(ComponentButtonHeight::SM)
            ->setMargin(ComponentMargin::MD)
            ->setAction(
                new UriTemplateActionBuilder(
                    '変更',
                    'https://liff.line.me/'.config('services.line.message.liffId').'/appointment-update/'.$yoyakuuser->token_id,
                    new AltUriBuilder('https://liff.line.me/'.config('services.line.message.liffId').'/appointment-update/'.$yoyakuuser->token_id)
                )
            );
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
        $footer2 = TextComponentBuilder::builder()
            ->setText('電話かメールでご連絡ください。')
            ->setColor('#aaaaaa')
            ->setWrap(true)
            ->setAlign('center')
            ->setSize(ComponentFontSize::XS);
    
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$footer, $changeButton, $cancelButton]);
    }
}
