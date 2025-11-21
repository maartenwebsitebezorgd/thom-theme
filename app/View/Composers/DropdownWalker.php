<?php

namespace App\View\Composers;

use Walker_Nav_Menu;

class DropdownWalker extends Walker_Nav_Menu
{
    public $dropdown_id = 0;

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $this->dropdown_id++;
            $popover_id = 'desktop-menu-' . $this->dropdown_id;

            $output .= '<el-popover id="' . $popover_id . '" anchor="bottom" popover class="w-screen max-w-md overflow-hidden rounded-small bg-[var(--theme-bg)] shadow-lg outline-1 outline-[var(--theme-border)] transition transition-discrete [--anchor-gap:--spacing(3)] backdrop:bg-transparent open:block data-closed:translate-y-1 data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">';
            $output .= '<div class="p-u-2">';
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</div></el-popover>';
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $current = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes);
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0) {
            // Top level items
            if ($has_children) {
                $popover_id = 'desktop-menu-' . ($this->dropdown_id + 1);

                $output .= '<div class="relative" data-dropdown-trigger="' . $popover_id . '">';
                $output .= '<button popovertarget="' . $popover_id . '" data-popover-button="' . $popover_id . '" class="flex items-center gap-x-1 text-main/6 font-medium text-[var(--theme-text)] hover:text-[var(--theme-text)] transition-colors duration-200">';
                $output .= esc_html($item->title);
                $output .= '<svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 flex-none text-[var(--theme-text)]/60">';
                $output .= '<path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />';
                $output .= '</svg>';
                $output .= '</button>';
            } else {
                $class_names = 'text-main/6 font-medium transition-colors duration-200 ' .
                    ($current ? 'text-[var(--theme-accent)]' : 'text-[var(--theme-text)] hover:text-[var(--theme-accent)]');

                $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
                $output .= esc_html($item->title);
                $output .= '</a>';
            }
        } else {
            // Dropdown items
            $output .= '<div class="group relative flex items-center gap-x-u-3 rounded-lg p-u-2 text-sm/6 hover:bg-[var(--theme-text)]/5">';

            // Icon - use custom icon or default
            $output .= '<div class="flex size-u-6 flex-none items-center justify-center rounded-lg bg-[var(--theme-text)]/5 group-hover:bg-[var(--theme-text)]/10">';
            $output .= '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-u-4 text-[var(--theme-text)]/60 group-hover:text--[var(--theme-text)]/100">';

            // Use custom icon path if available, otherwise use default
            if (!empty($item->icon)) {
                $output .= '<path ' . $item->icon . ' />';
            } else {
                // Default icon
                $output .= '<path d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" stroke-linecap="round" stroke-linejoin="round" />';
            }

            $output .= '</svg>';
            $output .= '</div>';

            $output .= '<div class="flex-auto">';
            $output .= '<a href="' . esc_url($item->url) . '" class="block font-medium text-[var(--theme-text)]">';
            $output .= esc_html($item->title);
            $output .= '<span class="absolute inset-0"></span>';
            $output .= '</a>';

            // Use subtitle if available, fallback to description
            $subtitle_text = !empty($item->subtitle) ? $item->subtitle : $item->description;
            if ($subtitle_text) {
                $output .= '<p class="mt-1 u-text-style-small text-[var(--theme-text)]/70">' . esc_html($subtitle_text) . '</p>';
            }

            $output .= '</div>';
            $output .= '</div>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0 && $has_children) {
            $output .= '</div>';
        }
    }
}

class MobileWalker extends Walker_Nav_Menu
{
    public $mobile_accordion_id = 0;

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            // Start of disclosure content (will be wrapped in el-disclosure)
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</el-disclosure>';
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $current = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes);
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0) {
            if ($has_children) {
                $this->mobile_accordion_id++;
                $disclosure_id = 'products-' . $this->mobile_accordion_id;

                $output .= '<div class="-mx-3">';
                $output .= '<button type="button" command="--toggle" commandfor="' . $disclosure_id . '" class="flex w-full items-center justify-between rounded-lg py-2 pr-3.5 pl-3 text-base/7 font-medium text-[var(--theme-text)] hover:bg-[var(--theme-text)]/5">';
                $output .= esc_html($item->title);
                $output .= '<svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 flex-none in-aria-expanded:rotate-180">';
                $output .= '<path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />';
                $output .= '</svg>';
                $output .= '</button>';
                $output .= '<el-disclosure id="' . $disclosure_id . '" hidden class="mt-2 block space-y-2">';
            } else {
                $class_names = '-mx-3 block rounded-lg px-3 py-2 text-base/7 font-medium transition-colors duration-200 ' .
                    ($current ? 'text-[var(--theme-accent)] bg-[var(--theme-bg)]/10' : 'text-[var(--theme-text)] hover:bg-[var(--theme-text)]/5');

                $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
                $output .= esc_html($item->title);
                $output .= '</a>';
            }
        } else {
            // Sub-menu items
            $class_names = 'block rounded-lg py-2 pr-3 pl-6 text-sm/7 font-medium transition-colors duration-200 ' .
                ($current ? 'text-[var(--theme-accent)] hover:bg-[var(--theme-text)]/5' : 'text-[var(--theme-text)] hover:bg-[var(--theme-text)]/5');

            $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
            $output .= esc_html($item->title);
            $output .= '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0 && $has_children) {
            // Close the wrapper div for the disclosure button
            $output .= '</div>';
        }
    }
}
