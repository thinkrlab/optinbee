<?php

/**
 * Plugin Name: OptinBee
 * Plugin URI: https://optinbee.com/
 * Description: OptinBee converts and monetizes your website traffic by providing powerful pop-up builder features.
 * Version: 1.0.0
 * Author: Fahim Reza
 * Author URI: https://optinbee.com/
 * Text Domain: optinbee
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

use OptinBee\Loaded;

require_once __DIR__ . '/vendor/autoload.php';

final class OptinBee
{
    /**
     * The single instance of the class.
     *
     * @var OptinBee
     */
    protected static $instance = null;

    /**
     * Main OptinBee Instance.
     *
     * Ensures only one instance of OptinBee is loaded or can be loaded.
     *
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
     */
    public function __construct()
    {
        $this->define_constants();
        register_activation_hook(__FILE__, [$this, 'activate']);

        Loaded::getInstance();
    }

    /**
     * Define OptinBee Constants.
     */
    private function define_constants()
    {
        define('OPTINBEE_VERSION', '1.0.beta2');
        define('OPTINBEE_APP_NAME', 'Optinbee');
        define('OPTINBEE_PREFIX', 'optinbee');
        define('OPTINBEE_TEXT_DOMAIN', 'optinbee');
        define('OPTINBEE_PLUGIN_REL_URL', dirname(plugin_basename(__FILE__)));
        define('OPTINBEE_ROOT_URL', plugin_dir_url(__FILE__));
        define('OPTINBEE_ASSETS_URL', OPTINBEE_ROOT_URL . 'assets/');
        define('OPTINBEE_ASSETS_PATH', plugin_dir_path(__FILE__));
        define('OPTINBEE_ADMIN_VIEWS_URL', OPTINBEE_ASSETS_PATH . 'inc/Admin/views/');
        define('OPTINBEE_FRONTEND_VIEWS_URL', OPTINBEE_ASSETS_PATH . 'inc/Frontend/views/');
    }

    /**
     * Run action on plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installed = get_option(OPTINBEE_PREFIX . '_installed');

        if (!$installed) {
            update_option(OPTINBEE_PREFIX . '_installed', time());
        }

        update_option(OPTINBEE_PREFIX . '_version', OPTINBEE_VERSION);
    }
}

/**
 * Main instance of OptinBee.
 *
 * Returns the main instance of OptinBee.
 *
 * @return OptinBee
 */
function optinbee()
{
    return OptinBee::get_instance();
}

// Global for backwards compatibility.
optinbee();
