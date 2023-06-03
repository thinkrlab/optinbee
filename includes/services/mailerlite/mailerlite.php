<?php

namespace OptinBee;

class Mailerlite
{
    protected $api_key;
    protected $api_url = 'https://connect.mailerlite.com/api/';

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function make_request($method = 'GET', $endpoint = '', $request_body = null)
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

    public function create_subscribe($data = null)
    {
        return $this->make_request('POST', 'subscribers', $data);
    }
}
