<?php

namespace App\Helpers;

/**
 * Add custom fields to menu items (icon and subtitle)
 */
class MenuItemFields
{
    public function __construct()
    {
        add_action('wp_nav_menu_item_custom_fields', [$this, 'addCustomFields'], 10, 4);
        add_action('wp_update_nav_menu_item', [$this, 'saveCustomFields'], 10, 2);
        add_filter('wp_setup_nav_menu_item', [$this, 'loadCustomFields']);
    }

    /**
     * Add custom fields to menu item edit screen
     */
    public function addCustomFields($item_id, $item, $depth, $args)
    {
        $icon = get_post_meta($item_id, '_menu_item_icon', true);
        $subtitle = get_post_meta($item_id, '_menu_item_subtitle', true);
        ?>
        <p class="field-icon description description-wide">
            <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
                <?php _e('Icon SVG Path', 'sage'); ?><br />
                <textarea
                    id="edit-menu-item-icon-<?php echo $item_id; ?>"
                    class="widefat"
                    rows="3"
                    name="menu-item-icon[<?php echo $item_id; ?>]"
                    style="font-family: monospace; font-size: 12px;"
                ><?php echo esc_textarea($icon); ?></textarea>
                <span class="description"><?php _e('Enter SVG path data (e.g., from Heroicons). Leave empty for default icon.', 'sage'); ?></span>
            </label>
        </p>

        <p class="field-subtitle description description-wide">
            <label for="edit-menu-item-subtitle-<?php echo $item_id; ?>">
                <?php _e('Subtitle/Description', 'sage'); ?><br />
                <input
                    type="text"
                    id="edit-menu-item-subtitle-<?php echo $item_id; ?>"
                    class="widefat"
                    name="menu-item-subtitle[<?php echo $item_id; ?>]"
                    value="<?php echo esc_attr($subtitle); ?>"
                />
                <span class="description"><?php _e('Short description shown in dropdown menus', 'sage'); ?></span>
            </label>
        </p>
        <?php
    }

    /**
     * Save custom fields
     */
    public function saveCustomFields($menu_id, $menu_item_db_id)
    {
        if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
            $icon = sanitize_textarea_field($_POST['menu-item-icon'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_menu_item_icon', $icon);
        } else {
            delete_post_meta($menu_item_db_id, '_menu_item_icon');
        }

        if (isset($_POST['menu-item-subtitle'][$menu_item_db_id])) {
            $subtitle = sanitize_text_field($_POST['menu-item-subtitle'][$menu_item_db_id]);
            update_post_meta($menu_item_db_id, '_menu_item_subtitle', $subtitle);
        } else {
            delete_post_meta($menu_item_db_id, '_menu_item_subtitle');
        }
    }

    /**
     * Load custom fields into menu item object
     */
    public function loadCustomFields($menu_item)
    {
        $menu_item->icon = get_post_meta($menu_item->ID, '_menu_item_icon', true);
        $menu_item->subtitle = get_post_meta($menu_item->ID, '_menu_item_subtitle', true);
        return $menu_item;
    }
}
