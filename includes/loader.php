<?php

namespace OptinBee;

defined('ABSPATH') or die('No script kiddies please!');

use OptinBee\AjaxHandler;
use OptinBee\Recaptcha;

class Loaded
{
    private static $instance = null;
    private $recaptcha;

    private function __construct()
    {
        $this->recaptcha = new Recaptcha('6LfX3lImAAAAAKtunPZ7OPKv-8qATdrd5WmyfM0P', '6LfX3lImAAAAAJhNJthBIs48nh6l3tSre1EgdYR7', 'v3');

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_footer', [$this, 'render_popup']);

        AjaxHandler::get_instance();
    }

    /**
     * Enqueue scripts and styles
     * 
     * @return void
     */
    public function enqueue_scripts()
    {

        $this->recaptcha->enqueue_scripts();

        $file = OPTINBEE_ROOT_PATH . 'assets/frontend/optinbee.asset.php';

        if (!file_exists($file)) {
            return;
        }

        $asset = require_once $file;

        if (!isset($asset)) {
            return;
        }

        wp_enqueue_script(
            'optinbee-js',
            OPTINBEE_ASSETS_URL . 'frontend/optinbee.js',
            array_merge($asset['dependencies']),
            $asset['version'],
            true
        );

        wp_localize_script(
            'optinbee-js',
            'optinbee_vars',
            $this->get_localized_array()

        );

        wp_enqueue_style(
            'optinbee-css',
            OPTINBEE_ASSETS_URL . 'frontend/style-optinbee.css',
            [],
            $asset['version']
        );
    }

    /**
     * Prepares and returns the localized array
     * 
     * @return array
     */
    private function get_localized_array()
    {
        // $settings = get_option('optinbee_settings') ?: (object) [];

        return apply_filters('optinbee_localize_vars', [
            // 'settings' => wp_json_encode($settings),
            'nonce'    => wp_create_nonce('optinbee-nonce'),
            'ajaxurl'  => esc_url(admin_url('admin-ajax.php')),

        ]);
    }

    /**
     * Render the popup
     */
    public function render_popup()
    {
?>
        <div id="optinbee-1" class="optinbee-overlay">
            <div class="optinbee-modal">
                <h2 class="optinbee-modal-title">Download Free</h2>
                <p class="optinbee-modal-subtitle">Stay updated with our latest news</p>
                <form id="optinbee-modal-form" class="optinbee-form" action="javascript:void(0);" method="post">
                    <div class="optinbee-form-field">
                        <input id="optinbee-email" placeholder="Type your email" class="optinbee-input" type="email" name="email" required />
                    </div>
                    <div class="optinbee-form-field">
                        <input id="optinbee-submit" class="optinbee-button" type="submit" value="Subscribe" />
                    </div>

                    <div class="optinbee-form-field">
                        <span class="optinbee-text"><a href="https://wppaw.com/thank-you/">No Thanks! I Just Want to Download</a></span>
                    </div>
                    <div class="optinbee-form-field">
                        <?php echo $this->recaptcha->render_field(); ?>
                    </div>

                    <div id="optinbee-message" class="optinbee-message"></div>
                </form>
                <button class="optinbee-close">x</button>
            </div>
        </div>

<?php
    }

    /**
     * Get the single instance of this class
     *
     * @return Loaded
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
