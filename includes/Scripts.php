<?php

namespace OptinBee;

if (!defined('WPINC')) {
    die;
}

class EnqueueScripts
{
    /**
     * The unique instance of the class.
     *
     * @var EnqueueScripts
     */
    private static $instance = null;

    /**
     * Gets the unique instance of the class.
     *
     * @return EnqueueScripts
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
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Function to enqueue scripts
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script('optinbee-js', OPTINBEE_ASSETS_URL . 'index.js', ['jquery'], OPTINBEE_VERSION, true);
        wp_enqueue_style('optinbee-css', OPTINBEE_ASSETS_URL . 'index.css', [], OPTINBEE_VERSION);
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
