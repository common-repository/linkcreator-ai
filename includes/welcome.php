<?php
// File: includes/welcome.php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Our Welcome Page
 */

/** WordPress Administration Bootstrap */
require_once(ABSPATH . 'wp-load.php');
require_once(ABSPATH . 'wp-admin/admin.php');
require_once(ABSPATH . 'wp-admin/admin-header.php');

global $linkcreator_plugin_version;
$linkcreator_plugin_version = '1.0.0';
?>

<div class="wrap about-wrap">
    <div class="logo-container">
        <img src="<?php echo esc_url(plugins_url('../img/logo.jpg', __FILE__)); ?>" alt="<?php esc_attr_e('Linkcreator AI Logo', 'linkcreator-ai'); ?>" class="logo-image" />
    </div>
    <h1 class="text-center bold"><?php esc_html_e('Welcome to LinkCreator AI Model Plugin.', 'linkcreator-ai'); ?></h1>
    <p class="text-center"><?php esc_html_e('Version:', 'linkcreator-ai'); ?> <?php echo esc_html($linkcreator_plugin_version); ?></p>

    <div class="about-text">
        <?php esc_html_e('Welcome to LinkCreator AI, your ultimate content modeling platform for WordPress websites. With LinkCreator AI, you can effortlessly generate compelling text and content for your blog posts. Say goodbye to writer’s block and hello to endless inspiration!', 'linkcreator-ai'); ?>
    </div>

    <p><?php esc_html_e('Thank you for installing LinkCreator AI plugin!', 'linkcreator-ai'); ?></p>
    <p><?php esc_html_e('LinkCreator AI empowers you to create and manage engaging content using cutting-edge artificial intelligence technology. Whether you’re a seasoned blogger or just starting out, LinkCreator AI will revolutionize the way you create content for your WordPress website.', 'linkcreator-ai'); ?></p>
    <p><?php esc_html_e('Get started by configuring your LinkCreator AI settings and unlock a world of possibilities for your website.', 'linkcreator-ai'); ?></p>

    <div class="changelog">
        <h3><?php esc_html_e('Unlock the Power of Content Modeling', 'linkcreator-ai'); ?></h3>

        <div class="feature-section images-stagger-right">
            <h4><?php esc_html_e('Unleash Your Creativity', 'linkcreator-ai'); ?></h4>
            <p><?php esc_html_e('LinkCreator AI is more than just a tool – it’s your creative companion. Say goodbye to writer’s block and hello to a world of inspiration. With LinkCreator AI, you can effortlessly generate compelling text and content for your blog posts.', 'linkcreator-ai'); ?></p>

            <h4><?php esc_html_e('Optimize Your Content', 'linkcreator-ai'); ?></h4>
            <p><?php esc_html_e('In addition to text generation, LinkCreator AI helps you optimize your content with auto-generated hashtags and links. Enhance your SEO efforts and attract more visitors to your website with targeted keywords and relevant links.', 'linkcreator-ai'); ?></p>
        </div>
    </div>

    <a href="<?php echo esc_url(admin_url('admin.php?page=linkcreator-settings')); ?>" class="button button-primary"><?php esc_html_e('Go to Settings', 'linkcreator-ai'); ?></a>
</div>

<?php include(ABSPATH . 'wp-admin/admin-footer.php'); ?>