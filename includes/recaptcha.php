<?php

namespace OptinBee;

class Recaptcha
{
    private $secretKey;
    private $siteKey;
    private $version;

    public function __construct($secretKey, $siteKey, $version = 'v2')
    {
        $this->secretKey = $secretKey;
        $this->siteKey = $siteKey;
        $this->version = $version;
    }

    public function verify($response, $remoteIp = '')
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            'secret'   => $this->secretKey,
            'response' => $response,
            'remoteip' => $remoteIp
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result)->success;
    }

    public function enqueue_scripts()
    {
        if (empty($this->siteKey) || empty($this->secretKey)) {
            return;
        }

        add_action('wp_enqueue_scripts', function () {
            $src = 'https://www.google.com/recaptcha/api.js?onload=optinbeeRecaptchaLoadCallback&render=explicit';
            if ($this->version === 'v3') {
                $src = 'https://www.google.com/recaptcha/api.js?onload=optinbeeRecaptchaLoadCallback&render=' . $this->siteKey;
            }

            wp_enqueue_script('optinbee-recaptcha-script', $src, array(), null, true);
            wp_add_inline_script('optinbee-recaptcha-script', '
                var optinbeeRecaptchaLoadCallback = function() {
                    grecaptcha.render("optinbee-recaptcha", {
                        sitekey: "' . $this->siteKey . '",
                        callback: function() {
                            console.log("Recaptcha ready");
                        }
                    });
                };
            ', 'before');
        });
    }

    public function render_field()
    {
        if ($this->version == 'v2') {
            return '<div id="optinbee-recaptcha" class="g-recaptcha" data-sitekey="' . $this->siteKey . '"></div>';
        }
        return '<div id="optinbee-recaptcha"></div>';
    }
}
