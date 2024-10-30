<?php
// File: includes/class-linkcreator.php

if (!defined('ABSPATH')) {
    exit;
}

class LinkCreator
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Initialization code here
    }

    /**
     * Run the plugin.
     */
    public function run()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('save_post', array($this, 'send_webhook_on_post_save'), 10, 3);
        add_action('rest_api_init', array($this, 'register_plugin_route'));
    }

    public function add_admin_menu()
    {
        add_menu_page(
            esc_html__('LinkCreator AI', 'linkcreator-ai'),
            esc_html__('LinkCreator AI', 'linkcreator-ai'),
            'manage_options',
            'linkcreator-welcome',
            array($this, 'welcome_screen')
        );
        add_submenu_page(
            'linkcreator-welcome',
            esc_html__('Settings', 'linkcreator-ai'),
            esc_html__('Settings', 'linkcreator-ai'),
            'manage_options',
            'linkcreator-settings',
            array($this, 'settings_page')
        );
    }

    public function welcome_screen()
    {
        include_once('welcome.php');
    }

    public function settings_page()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $api_token = get_option('linkcreator_api_token', '');
        $is_connected = get_option('linkcreator_is_connected', false);

        if (isset($_POST['linkcreator_settings_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['linkcreator_settings_nonce'])), 'update_settings')) {
            $api_token = isset($_POST['api_token']) ? sanitize_text_field($_POST['api_token']) : '';
            update_option('linkcreator_api_token', $api_token);

            $verification_result = $this->verify_api_token($api_token);

            if (is_array($verification_result) && isset($verification_result['status']) && isset($verification_result['message'])) {
                $is_connected = $verification_result['status'];
                $message = $verification_result['message'];

                update_option('linkcreator_is_connected', $is_connected);

                $this->send_all_posts_and_pages_to_api($api_token);

                $notice_type = $is_connected ? 'notice-success' : 'notice-error';
                $notice_message = $is_connected ? esc_html__('Connected successfully.', 'linkcreator-ai') : esc_html__('Failed to connect. ', 'linkcreator-ai') . esc_html($message);
                echo "<div class='notice " . esc_attr($notice_type) . " is-dismissible'><p>" . esc_html($notice_message) . "</p></div>";
            } else {
                error_log('Verification result is not in the expected format');
                echo "<div class='notice error is-dismissible'><p>" . esc_html__('Verification result is not in the expected format', 'linkcreator-ai') . "</p></div>";
            }
        }

?>
        <div class="wrap">
            <h2><?php esc_html_e('LinkCreator AI Settings', 'linkcreator-ai'); ?></h2>
            <div class="about-text">
                <?php esc_html_e('Welcome to LinkCreator AI, your ultimate content modeling platform for WordPress websites. With LinkCreator AI, you can effortlessly generate compelling text and content for your blog posts. Say goodbye to writer’s block and hello to endless inspiration!', 'linkcreator-ai'); ?>
            </div>
            <p><?php esc_html_e('Thank you for installing LinkCreator AI plugin!', 'linkcreator-ai'); ?></p>
            <p><?php esc_html_e('LinkCreator AI empowers you to create and manage engaging content using cutting-edge artificial intelligence technology. Whether you’re a seasoned blogger or just starting out, LinkCreator AI will revolutionize the way you create content for your WordPress website.', 'linkcreator-ai'); ?></p>
            <p><?php esc_html_e('Get started by entering your LinkCreator AI API Token and unlock a world of possibilities for your website.', 'linkcreator-ai'); ?></p>
            <form method="post" action="">
                <?php wp_nonce_field('update_settings', 'linkcreator_settings_nonce'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e('Linkcreator AI Token', 'linkcreator-ai'); ?></th>
                        <td><input type="text" name="api_token" value="<?php echo esc_attr($api_token); ?>" /></td>
                    </tr>
                </table>
                <?php submit_button(esc_html__('Save Changes', 'linkcreator-ai')); ?>
            </form>
            <?php if ($is_connected) : ?>
                <div><strong><?php esc_html_e('Status:', 'linkcreator-ai'); ?></strong> <i class="fa fa-check"></i> <span><?php esc_html_e('Connected', 'linkcreator-ai'); ?></span></div>
            <?php endif; ?>
        </div>
<?php
    }

    private function verify_api_token($api_token)
    {
        $response = wp_remote_post('https://api.linkcreator.ai/api/v1/websites/verify-website-token/', array(
            'body' => wp_json_encode(array('api_token' => $api_token)),
            'headers' => array('Content-Type' => 'application/json'),
        ));

        if (is_wp_error($response)) {
            error_log('Error in API request: ' . $response->get_error_message());
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        error_log('API response body: ' . $body);
        $data = json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Error decoding JSON: ' . json_last_error_msg());
            return false;
        }

        if (isset($data->status) && $data->status === true) {
            return array('status' => true, 'message' => 'API key is valid');
        } else {
            $message = isset($data->message) ? $data->message : 'Unknown error';
            return array('status' => false, 'message' => $message);
        }
    }

    public function send_webhook_on_post_save($post_id, $post, $update)
    {
        if ($update) {
            $post_title = $post->post_title;
            $post_slug = $post->post_name; // Corrected to post_name
            $post_content = $post->post_content;
            $post_type = $post->post_type;
            $post_author_id = $post->post_author;
            $post_author = get_the_author_meta('display_name', $post_author_id);
            $post_permalink = get_permalink($post_id);
            $api_token = get_option('linkcreator_api_token', '');
            $hook_type = 'post';

            $webhook_data = array(
                'post_id' => $post_id,
                'post_title' => $post_title,
                'post_slug' => $post_slug,
                'post_content' => $post_content,
                'post_type' => $post_type,
                'post_author' => $post_author,
                'post_permalink' => $post_permalink,
            );

            $this->send_webhook_notification($webhook_data, $api_token, $hook_type);
        }
    }

    private function send_webhook_notification($data, $api_token, $hook_type)
    {
        $api_token = get_option('linkcreator_api_token', '');
        $plugin_status = get_option('linkcreator_is_connected', false);

        $webhook_url = 'https://api.linkcreator.ai/wp-webhook/';

        $data['api_token'] = $api_token;
        $data['event'] = $hook_type;
        $data['domain'] = home_url();

        $response = wp_remote_post($webhook_url, array(
            'body' => wp_json_encode($data),
            'headers' => array('Content-Type' => 'application/json'),
        ));

        if (is_wp_error($response)) {
            error_log('Webhook failed: ' . $response->get_error_message());
        }
    }

    private function send_all_posts_and_pages_to_api($api_token)
    {
        $args = array(
            'post_type' => array('post', 'page'),
            'posts_per_page' => -1,
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $post_id = get_the_ID();
                $post_title = get_the_title();
                $post_content = get_the_content();
                $post_type = get_post_type();
                $post_author = get_the_author();
                $post_permalink = get_permalink();

                $webhook_data = array(
                    'post_id' => $post_id,
                    'post_title' => $post_title,
                    'post_content' => $post_content,
                    'post_type' => $post_type,
                    'post_author' => $post_author,
                    'post_permalink' => $post_permalink,
                );

                $this->send_webhook_notification($webhook_data, $api_token, 'post');
            }
            wp_reset_postdata();
        }
    }

    public function register_plugin_route()
    {
        register_rest_route('linkcreator-ai/v1', '/plugins', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_plugins_list'),
        ));
    }

    public function get_plugins_list()
    {
        $plugins = get_plugins();

        $plugins_list = array();

        foreach ($plugins as $plugin_path => $plugin_data) {
            $plugins_list[] = array(
                'name'        => $plugin_data['Name'],
                'version'     => $plugin_data['Version'],
                'text_domain' => $plugin_data['TextDomain'],
                'description' => $plugin_data['Description'],
                'author'      => $plugin_data['Author'],
            );
        }

        return rest_ensure_response($plugins_list);
    }
}
