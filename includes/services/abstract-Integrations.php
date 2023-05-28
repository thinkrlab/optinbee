<?php

namespace OptinBee;

abstract class AbstractIntegrations
{

    public $api_url = '';

    /**
     * Initialize the integration.
     *
     * @param $api_key
     * 
     * @throws \Exception
     */
    public function __construct($api_key)
    {
    }

    /**
     * Add a subscriber to the group.
     * 
     * @param $group The group ID.
     * @param $subscriber_data The subscriber data.
     * 
     * @return bool Whether the subscriber was added.
     */
    public function subscriber($group = '', $subscriber_data = [])
    {
    }


    /**
     * Validate the API key.
     *
     * @return bool Whether the API key is valid.
     */
    public function ajax_validate_api_key()
    {
    }

    /**
     * Check if the integration is correctly set up and can be used.
     *
     * @return bool Whether the integration is valid.
     */
    public function is_valid()
    {
    }
}
