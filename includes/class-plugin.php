<?php
// File: includes/class-plugin.php

if (!defined('ABSPATH')) {
    exit;
}

class LinkCreator_PluginReloader
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Initialization code here
        add_action('rest_api_init', array($this, 'register_plugin_route'));
    }

    /**
     * Register REST API route to get list of plugins.
     */
    public function register_plugin_route()
    {
        register_rest_route('linkcreator-ai/v1', '/plugins', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_plugins_list'),
        ));
    }

    /**
     * Callback function to retrieve list of plugins.
     */
    public function get_plugins_list()
    {
        $plugins = get_plugins();

        $plugins_list = array();

        foreach ($plugins as $plugin_path => $plugin_data) {
            $plugins_list[] = array(
                'name'        => $plugin_data['Name'],
                'version'     => $plugin_data['Version'],
                'text_domain' => $plugin_data['TextDomain'], // Changed from 'Text Domain' to 'TextDomain'
                'description' => $plugin_data['Description'],
                'author'      => $plugin_data['Author'],
            );
        }

        return rest_ensure_response($plugins_list);
    }
}

// Instantiate the class
new LinkCreator_PluginReloader();
