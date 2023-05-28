<?php

namespace OptinBee;

if (!defined('WPINC')) {
    die;
}

class Loaded
{
    /**
     * The unique instance of the class.
     *
     * @var PluginLoaded
     */
    private static $instance = null;

    /**
     * Gets the unique instance of the class.
     *
     * @return PluginLoaded
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Private constructor to enforce the use of getInstance()
     */
    private function __construct()
    {
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Core plugin initialization
     *
     * @return void
     */
    public function init_plugin()
    {
        load_plugin_textdomain('optinbee', false, dirname(plugin_basename(__FILE__)) . '/languages/');

        if (is_admin()) {
        } else {
            new EnqueueScripts();
        }
    }

    /**
     * Prevent cloning the instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Prevent unserializing the instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}
