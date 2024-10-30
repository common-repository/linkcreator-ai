<?php
/**
 * @package LinkCreator AI
 */
/**
 * Plugin Name: LinkCreator AI
 * Description: One single connect to Linkcreator AI.
 * Tags: link management, link building, AI content modeling, content generation, content optimization
 * Version: 1.0.0
 * Author: LinkCreator AI
 * Author URI: https://linkcreator.ai
 * Text Domain: linkcreator-ai
 * License: GPL-2.0-or-later
 */

/*
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 51 Franklin
 * Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * For any questions, please contact: Info@linkcreator.ai
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load plugin class files.
require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-linkcreator.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0
 */
define( 'LINKCREATOR_VERSION', '1.0.0' );

/**
 * Enqueue styles and scripts
 */

function enqueue_linkcreator_admin_styles()
{
    wp_enqueue_style(
        'linkcreator-ai-style',
        plugins_url('css/style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'css/style.css')
    );
    wp_enqueue_script(
        'linkcreator-ai-script',
        plugins_url('js/script.js', __FILE__),
        array('jquery'),  // Dependencies (optional)
        filemtime(plugin_dir_path(__FILE__) . 'js/script.js'),
        true  // Load script in the footer
    );
}
add_action('admin_enqueue_scripts', 'enqueue_linkcreator_admin_styles');


function run_linkcreator() {
    $plugin = new LinkCreator();
    $plugin->run();
}

run_linkcreator();
