<?php

/**
 * Plugin Name: OptinBee
 * Plugin URI: https://optinbee.com/
 * Description: Build Your Email List and Customer Engagement
 * Version: 1.0.beta1
 * Author: OptinBee
 * Author URI: https://optinbee.com/
 * Text Domain: optinbee
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

// Prevent direct access if the file is called directly
if (!defined('ABSPATH')) {
    exit;
}

use OptinBee\Loaded;

// Include the autoloader
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main OptinBee Class.
 *
 * @since 1.0.0
 */
final class OptinBee
{
    /**
     * The single instance of the class.
     *
     * @since 1.0.0
     * @var OptinBee
     */
    protected static $instance = null;

    /**
     * Get main OptinBee Instance.
     *
     * @since 1.0.0
     * @return OptinBee - Main instance.
     */
    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * OptinBee Constructor.
     *
     * @since 1.0.0
     */
    private function __construct()
    {
        // Run this on plugin activation
        register_activation_hook(__FILE__, [$this, 'activate']);

        // Define constants
        $this->define_constants();

        // Load plugin textdomain
        add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);

        Loaded::get_instance();
    }

    /**
     * Load Plugin Textdomain.
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain()
    {
        $domain = 'optinbee';
        load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }


    /**
     * Define OptinBee Constants.
     *
     * @since 1.0.0
     */
    private function define_constants()
    {
        define('OPTINBEE_VERSION', '1.0.beta1');
        define('OPTINBEE_APP_NAME', 'Optinbee');
        define('OPTINBEE_PREFIX', 'optinbee');
        define('OPTINBEE_TEXT_DOMAIN', 'optinbee');
        define('OPTINBEE_FILE', __FILE__);
        define('OPTINBEE_ROOT_PATH', plugin_dir_path(OPTINBEE_FILE));
        define('OPTINBEE_ROOT_URL', plugin_dir_url(OPTINBEE_FILE));
        define('OPTINBEE_ASSETS_URL', OPTINBEE_ROOT_URL . 'assets/');
    }

    /**
     * Run on plugin activation.
     *
     * @since 1.0.0
     */
    public function activate()
    {
        $installed = get_option(OPTINBEE_PREFIX . '_installed');

        // Set installed time if not already set
        if (!$installed) {
            update_option(OPTINBEE_PREFIX . '_installed', time());
        }

        // Update plugin version
        update_option(OPTINBEE_PREFIX . '_version', OPTINBEE_VERSION);
    }

    /**
     * Prohibit cloning of this class
     *
     * @since 1.0.0
     * @throws \Exception
     */
    private function __clone()
    {
        throw new \Exception("Cloning is not allowed for singleton class OptinBee.");
    }

    /**
     * Prohibit unserializing of this class
     *
     * @since 1.0.0
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Unserializing is not allowed for singleton class OptinBee.");
    }
}

/**
 * Function to get main instance of OptinBee.
 *
 * @since 1.0.0
 * @return OptinBee
 */
function optinbee()
{
    return OptinBee::get_instance();
}

// Run the plugin
optinbee();
