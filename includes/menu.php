<?php

namespace OptinBee;

defined('ABSPATH') or die('No script kiddies please!');

// This is the class for the functionality that is specific to the admin area.
class menu
{
    private static $instance = null;

    // Get the single instance of this class
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        // Add an item to the menu in the admin area
        add_action('admin_menu', [$this, 'admin_menu']);

        // Add settings link to the plugin
        add_filter('plugin_action_links_' . plugin_basename(OPTINBEE_FILE), [$this, 'add_settings_link']);
    }

    /** 
     * Function to add an item to the menu in the admin area
     * 
     * @return void
     */
    public function admin_menu()
    {
        $page_title = apply_filters('ob_menu_page_title', esc_html__('OptinBee', 'Optinbee'));
        $logo = file_get_contents(plugin_dir_path(OPTINBEE_FILE) . 'assets/images/OBLogo.svg');

        add_menu_page(
            $page_title,
            $page_title,
            'manage_options',
            'optinbee',
            [$this, 'menu_callback'],
            'data:image/svg+xml;base64,' . base64_encode($logo),
            30.5000
        );
    }

    // Function to redirect user after activation
    public function redirect_after_activation()
    {
        $is_redirect = get_transient('ob-redirect-after-activation');
        if ($is_redirect) {
            delete_transient('ob-redirect-after-activation');
            $url = get_admin_url() . 'admin.php?page=optinbee';
            wp_safe_redirect($url);
            die;
        }
    }

    // Function to get localized data
    private function get_localized_array()
    {
        $current_user = wp_get_current_user();

        $data = [];

        if (current_user_can('manage_options')) {
        }

        $settings = get_option('optinbee_settings');

        if (empty($settings)) {
            $settings = (object) [];
        }

        $data['settings']     = wp_json_encode($settings);
        $data['nonce'] = wp_create_nonce('optinbee-nonce');
        $data['ajaxurl']      = esc_url(admin_url('admin-ajax.php', 'relative'));

        return apply_filters('optinbee_localize_vars', $data);
    }

    public function add_settings_link($links)
    {
        $url = get_admin_url() . 'admin.php?page=optinbee';
        $settings_link = '<a href="' . $url . '">' . __('Settings', 'optinbee') . '</a>';
        $links[] = $settings_link;
        return $links;
    }
}
