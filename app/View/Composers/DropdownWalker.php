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
            $output .= '<div class="dropdown-menu absolute left-1/2 z-10 mt-3 w-screen max-w-md -translate-x-1/2 transform px-2 sm:px-0 hidden" id="dropdown-' . $this->dropdown_id . '">';
            $output .= '<div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">';
            $output .= '<div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8 dark:bg-gray-800">';
        }
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</div></div></div>';
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
                $class_names = 'group flex items-center gap-x-1 text-sm font-semibold leading-6 transition-colors duration-200 ' . 
                             ($current ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400');
                
                $output .= '<div class="relative">';
                $output .= '<button type="button" class="' . $class_names . '" data-dropdown="dropdown-' . ($this->dropdown_id + 1) . '">';
                $output .= esc_html($item->title);
                $output .= '<svg class="h-5 w-5 flex-none text-gray-400 group-hover:text-gray-500 transition-colors duration-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
                $output .= '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />';
                $output .= '</svg>';
                $output .= '</button>';
            } else {
                $class_names = 'text-sm font-semibold leading-6 transition-colors duration-200 ' . 
                             ($current ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400');
                
                $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
                $output .= esc_html($item->title);
                $output .= '</a>';
            }
        } else {
            // Dropdown items
            $class_names = 'block rounded-md p-3 transition duration-150 ease-in-out hover:bg-gray-50 dark:hover:bg-gray-700 ' . 
                         ($current ? 'bg-indigo-50 dark:bg-indigo-900/20' : '');
            
            $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
            $output .= '<div class="font-medium text-gray-900 dark:text-white">' . esc_html($item->title) . '</div>';
            
            // Add description if available
            if ($item->description) {
                $output .= '<div class="mt-1 text-sm text-gray-500 dark:text-gray-400">' . esc_html($item->description) . '</div>';
            }
            
            $output .= '</a>';
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
            $output .= '<div class="ml-6 mt-2 space-y-2 border-l border-gray-200 pl-4 dark:border-gray-700">';
        }
    }
    
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '</div>';
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
                $accordion_id = 'mobile-accordion-' . $this->mobile_accordion_id;
                
                $output .= '<div class="-mx-3">';
                $output .= '<button type="button" class="flex w-full items-center justify-between rounded-lg py-2 pr-3.5 pl-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5 transition-colors duration-200" onclick="toggleMobileAccordion(\'' . $accordion_id . '\')">';
                $output .= esc_html($item->title);
                $output .= '<svg class="h-5 w-5 flex-none transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" id="' . $accordion_id . '-icon">';
                $output .= '<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />';
                $output .= '</svg>';
                $output .= '</button>';
                $output .= '<div class="hidden" id="' . $accordion_id . '">';
            } else {
                $class_names = '-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 transition-colors duration-200 ' . 
                             ($current ? 'text-indigo-600 bg-indigo-50 dark:text-indigo-400 dark:bg-indigo-900/20' : 'text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-white/5');
                
                $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
                $output .= esc_html($item->title);
                $output .= '</a>';
            }
        } else {
            // Sub-menu items
            $class_names = 'block rounded-lg py-2 pr-3 pl-6 text-sm font-semibold leading-7 transition-colors duration-200 ' . 
                         ($current ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400');
            
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
            $output .= '</div></div>';
        }
    }
}