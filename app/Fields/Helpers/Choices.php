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
            'aspect-[4/3]' => '4:3',
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
            'gap-u-3' => 'Small',
            'gap-u-4' => 'Medium',
            'gap-u-6' => 'Large',
            'gap-u-8' => 'Extra Large',
        ];
    }
    public static function spacing()
    {
        return [
            'gap-u-3' => 'Small',
            'gap-u-4' => 'Medium',
            'gap-u-6' => 'Large',
            'gap-u-8' => 'Extra Large',
        ];
    }
}
