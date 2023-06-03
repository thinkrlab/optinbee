<?php

namespace OptinBee;

use OptinBee\Mailerlite;

class AjaxHandler
{

    protected static $instance = null;

    public function __construct()
    {
        add_action('init', [$this, 'setup_ajax']);
        add_action('wp_ajax_optinbee_handle_subscribe', [$this, 'handle_subscribe']);
        add_action('wp_ajax_nopriv_optinbee_handle_subscribe', [$this, 'handle_subscribe']);
    }

    public function setup_ajax()
    {
        if (isset($_GET['optinbee-ajax']) && !defined('DOING_AJAX')) {
            define('DOING_AJAX', true);
            @ini_set('display_errors', 0);
        }
    }

    public function handle_subscribe()
    {
        try {
            if (!wp_verify_nonce($_POST['nonce'], 'optinbee-nonce')) {
                wp_send_json_error('Invalid nonce');
            }

            $email = sanitize_email($_POST['email']);

            if (!is_email($email)) {
                wp_send_json_error('Invalid email address');
            }

            $handler = new Mailerlite('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZWQzYzU2ZjI2MzcwMDk3ZWI0ZTk2M2E3ZTIyM2E5N2VlYmRhZGExN2YwNDdmMDYzODIxNTRhZDk3ODIzZWM4Mzg3ZDUwZTQ1NGUxOWI1YmEiLCJpYXQiOjE2ODQ3OTIyNjUuNTMyMDMsIm5iZiI6MTY4NDc5MjI2NS41MzIwMzIsImV4cCI6NDg0MDQ2NTg2NS41MjY4NTEsInN1YiI6IjQ3ODY3MyIsInNjb3BlcyI6W119.nCea0UgT7TCSj0-MyKt5fBXq6wjfdkQGpoRclqcbGqiOD1a-H8i3sLDjFkjohb7FJsGO6mQSGVjvR-rM6XRis4cW948_a8aC5CdTdF0c8Wb9RQilGk1UrRCSMOg2wEH1Dk-wgv31YJcOBJvEpOT--s0DJaYEcV40FSoqibP2K2R4riCYqtGaUGGVm4bKKcKM1lYGFodslGsuC_i04qSBCrU5aA9VZTOyukJ4AwnmfGdJoNa64cXJKi6n2A-yyjGPhLmnaZF9xJ3DCTR0IlI0ESrpwzcyIQcua-37PgdoYC7NDER055qAG47wrRfAYLaZ7HiJGwDocRi7b8I3WsuJz5VMi_LzPc6pvc-MmtAjPAb9CVOvRuB4c1BG2Fb9SOt1kAk8SRGCE-V5p3U5Zw_5VKhvdcsitPgTtKR3L8atUpQzwoCsC8mrT5Yk0uRr6lx1dc545CPDodeWU-oiVb5rkNjlYoQkGxtWbMH0bQLYZUicmU-1UG5d6q69Qjmfv8zHVLamWGR1TUWl5kLdqjIgNp_5zZvwXzJGWsX1DDh0W4kEHQxSPIv0zZwMjKKpVoeFXXcRNxi312BMrVz1HcOu9CyAqTPkXUNFFIH0_7kU65Ji-Rawqu_HIfjDRPVU2hd_4PCY5wFCOV1ok_09gMkS8mWjYO4zCsyoTbhEvUD5-J4');

            $response = $handler->create_subscribe(['email' => $email]);

            wp_send_json($response);
        } catch (\Exception $e) {
            wp_send_json_error($e->getMessage());
        }
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
