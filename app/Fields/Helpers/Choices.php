<?php

namespace App\Fields\Helpers;

class Choices
{
    public static function theme()
    {
        return [
            'inherit' => 'Inherit',
            'light' => 'Light',
            'grey' => 'Grey',
            'accent-light' => 'Accent Light',
            'accent' => 'Accent',
            'dark' => 'Blue',
        ];
    }

    public static function cardTheme()
    {
        return [
            'auto' => 'Auto (Opposite of Section)',
            'inherit' => 'Inherit',
            'light' => 'Light',
            'grey' => 'Grey',
            'accent-light' => 'Accent Light',
            'accent' => 'Accent',
            'dark' => 'Blue',
        ];
    }

    public static function paddingTop()
    {
        return [
            'pt-section-none' => 'None',
            'pt-section-even' => 'Even',
            'pt-section-tiny' => 'Tiny',
            'pt-section-small' => 'Small',
            'pt-section-main' => 'Main',
            'pt-section-medium' => 'Medium',
            'pt-section-large' => 'Large',
        ];
    }

    public static function paddingBottom()
    {
        return [
            'pb-section-none' => 'None',
            'pb-section-even' => 'Even',
            'pb-section-tiny' => 'Tiny',
            'pb-section-small' => 'Small',
            'pb-section-main' => 'Main',
            'pb-section-medium' => 'Medium',
            'pb-section-large' => 'Large',
        ];
    }

    public static function buttonStyle()
    {
        return [
            'primary' => 'Primary',
            'secondary' => 'Secondary',
            'outline' => 'Outline',
        ];
    }

    public static function aspectRatio()
    {
        return [
            'aspect-square' => '1:1 (Square)',
            'aspect-[3/2]' => '3:2 (Standard)',
            'aspect-[4/5]' => '4:5 (Portrait)',
            'aspect-[5/4]' => '5:4 (Wide)',
            'aspect-[4/3]' => '4:3 (Wide)',
            'aspect-[3/4]' => '3:4 (Portrait',
            'aspect-[16/9]' => '16:9 (Wide)',
            'aspect-[21/9]' => '21:9 (Ultra Wide)',
        ];
    }

    public static function gridColumnsDesktop()
    {
        return [
            'grid-cols-2' => '2 Columns',
            'grid-cols-3' => '3 Columns',
            'grid-cols-4' => '4 Columns',
        ];
    }

    public static function gridColumnsTablet()
    {
        return [
            'grid-cols-1' => '1 Column',
            'grid-cols-2' => '2 Columns',
            'grid-cols-3' => '3 Columns',
        ];
    }

    public static function gridColumnsMobile()
    {
        return [
            'grid-cols-1' => '1 Column',
            'grid-cols-2' => '2 Columns',
        ];
    }

    public static function gapSize()
    {
        return [
            'gap-u-2' => 'Tiny',
            'gap-u-3' => 'Small',
            'gap-u-4' => 'Main',
            'gap-u-5' => 'Medium',
            'gap-u-6' => 'Large',
            'gap-u-8' => 'Extra Large',
        ];
    }
    public static function spacing()
    {
        return [
            'gap-u-2' => 'Tiny',
            'gap-u-3' => 'Extra Small',
            'gap-u-4' => 'Small',
            'gap-u-6' => 'Main',
            'gap-u-7' => 'Medium',
            'gap-u-8' => 'Large',
            'gap-u-9' => 'Extra Large',
        ];
    }

    public static function headingTextStyle()
    {
        return [
            'display' => 'Display',
            'u-text-style-h1' => 'H1 Style',
            'u-text-style-h2' => 'H2 Style',
            'u-text-style-h3' => 'H3 Style',
            'u-text-style-h4' => 'H4 Style',
            'u-text-style-h5' => 'H5 Style',
            'u-text-style-h6' => 'H6 Style',
        ];
    }

    public static function paragraphTextStyle()
    {
        return [
            'u-text-style-small' => 'Small Style',
            'u-text-style-main' => 'Main Style',
            'u-text-style-medium' => 'Medium Style',
            'u-text-style-large' => 'Large Style',
        ];
    }

    public static function iconSize()
    {
        return [
            'size-u-3' => 'Small',
            'size-u-4' => 'Main',
            'size-u-5' => 'Medium',
            'size-u-6' => 'Large',
        ];
    }

    public static function maxWidth()
    {
        return [
            '' => 'None',
            'u-max-width-12ch' => '12ch (Very Narrow)',
            'u-max-width-15ch' => '15ch',
            'u-max-width-20ch' => '20ch',
            'u-max-width-30ch' => '30ch',
            'u-max-width-40ch' => '40ch',
            'u-max-width-50ch' => '50ch',
            'u-max-width-60ch' => '60ch',
            'u-max-width-70ch' => '70ch',
            'u-max-width-80ch' => '80ch (Very Wide)',
        ];
    }

    public static function marginBottom()
    {
        return [
            'mb-0' => 'None',
            'mb-u-2' => 'Tiny',
            'mb-u-3' => 'Small',
            'mb-u-4' => 'Medium',
            'mb-u-6' => 'Main',
            'mb-u-7' => 'Large',
            'mb-u-8' => 'Extra Large',
        ];
    }
}
