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
class FlexJunban
{
    /**
     * Create sample restaurant flex message
     *
     * @return \LINE\LINEBot\MessageBuilder\FlexMessageBuilder
     */
    public static function get(
        $your_name,
        $junban_num,
        $yoyaku_date,
        $id
    )
    {
        return FlexMessageBuilder::builder()
            ->setAltText('順番待ち受付システム')
            ->setContents(
                BubbleContainerBuilder::builder()
                    ->setHeader(self::createHeaderBlock())
                    ->setBody(self::createBodyBlock(
                        $your_name, $junban_num, $yoyaku_date
                    ))
                    ->setFooter(self::createFooterBlock($id))
                    ->setSize('giga')
            );
    }

    private static function createHeaderBlock()
    {
        $title = TextComponentBuilder::builder()
            ->setText('順番待ち受付システム')
            ->setColor('#ffffff')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::LG);

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setBackgroundColor('#f69c9e')
            ->setContents([$title]);
    }

    private static function createBodyBlock(
        $your_name,
        $junban_num,
        $yoyaku_date
    )
    {
        $junban_your_name = TextComponentBuilder::builder()
            ->setText($your_name.'　様、')
            ->setWrap(true)
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::XL);

        $junban_title = TextComponentBuilder::builder()
            ->setText('受付ました。')
            ->setWrap(true)
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::XL);
        
        $setMargin = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setMargin(ComponentMargin::MD)
            ->setContents([]);
        
        $junban_counter_text = TextComponentBuilder::builder()
            ->setText('受付番号')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setAlign('center')
            ->setSize(ComponentFontSize::XL);

        $junban_junba_num = TextComponentBuilder::builder()
            ->setText($junban_num)
            ->setMargin(ComponentMargin::MD)
            ->setWeight(ComponentFontWeight::BOLD)
            ->setAlign('center')
            ->setSize(ComponentFontSize::XXXXL);

        $junban_time_text = TextComponentBuilder::builder()
            ->setText('受付')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setMargin(ComponentMargin::MD)
            ->setAlign('center')
            ->setSize(ComponentFontSize::XL);

        $junban_time = TextComponentBuilder::builder()
            ->setText($yoyaku_date)
            ->setWeight(ComponentFontWeight::BOLD)
            ->setAlign('center')
            ->setMargin(ComponentMargin::SM)
            ->setSize(ComponentFontSize::XL);

        $junban_info = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setPaddingAll('10%')
            ->setBackgroundColor('#eeeeee')
            ->setMargin(ComponentMargin::LG)
            ->setContents([$junban_counter_text, $junban_junba_num, $junban_time_text, $junban_time]);

        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setBackgroundColor('#fafafa')
            ->setContents([$junban_your_name, $junban_title, $junban_info]);
    }

    private static function createFooterBlock($id)
    {
        $footer = TextComponentBuilder::builder()
            ->setText('順番が近づいたらLINEの通知でお知らせします。')
            ->setColor('#aaaaaa')
            ->setWrap(true)
            ->setAlign('center')
            ->setSize(ComponentFontSize::MD);

        $junbanButton = ButtonComponentBuilder::builder()
            ->setStyle(ComponentButtonStyle::PRIMARY)
            ->setHeight(ComponentButtonHeight::MD)
            ->setMargin(ComponentMargin::MD)
            ->setAction(
                new UriTemplateActionBuilder(
                    '順番を確認',
                    'https://liff.line.me/'.config('services.line.message.liffId_waiting').'/junban-uketsuke/'.$id,
                    new AltUriBuilder('https://liff.line.me/'.config('services.line.message.liffId_waiting').'/junban_uketsuke/'.$id)
                )
            );
    
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$footer, $junbanButton]);
    }
}
