<?php

namespace OptinBee;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The MailerLite integration class.
 */
class Mailerlite_Handler extends AbstractIntegrations
{
    protected $api_key;
    protected $api_url = 'https://connect.mailerlite.com/api';

    /**
     * MailerLite constructor.
     *
     * @param string $api_key The API key
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Make a request to the API.
     *
     * @param string $method The HTTP method
     * @param string $endpoint The endpoint to make the request to
     * @param mixed $request_body The request body
     *
     * @throws \Exception If the request is not successful
     *
     * @return array The response
     */
    public function request($method = 'GET', $endpoint = '', $request_body = null)
    {
        $url = $this->api_url . $endpoint;
        $args = [
            'method'  => $method,
            'timeout' => 30,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key
            ],
        ];

        if ($request_body) {
            $args['body'] = json_encode($request_body);
        }

        $response = wp_remote_request($url, $args);
        $response_code = (int) wp_remote_retrieve_response_code($response);

        if (is_wp_error($response) || 200 !== $response_code) {
            throw new \Exception('Rest Client Error: response code ' . $response_code);
        }

        $response_body = json_decode(wp_remote_retrieve_body($response), true);

        return [
            'code' => $response_code,
            'body' => $response_body
        ];
    }

    /**
     * Subscribe to the given endpoint.
     *
     * @param string $endpoint The endpoint to subscribe to
     * @param mixed $data The data
     *
     * @return array The response
     */
    public function subscribe($endpoint = '', $data = null)
    {
        $request_body = wp_json_encode($data);

        return $this->request('POST', $endpoint, $request_body);
    }
}
