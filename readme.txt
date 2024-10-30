=== LinkCreator ===
Contributors: linkcreatorai
Tags: link management, link building, AI content modeling, content generation, content optimization
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
One single connect to Linkcreator AI.


== Description ==

LinkCreator AI is a powerful plugin that connects your WordPress site with the Linkcreator AI service. It automates link creation and optimization for better SEO and site management.

**Important Notice**: This plugin communicates with an external service hosted at `https://api.linkcreator.ai`. For more details, please refer to the "External Service Communication" section below.

== External Service Communication ==

This plugin communicates with the external service managed by LinkCreator at `https://api.linkcreator.ai` under the following circumstances:

1. **Website Token Verification**:  
   - **URL**: `https://api.linkcreator.ai/api/v1/websites/verify-website-token/`  
   - **Data Sent**: API token  
   - **Purpose**: To verify the authenticity of the website token.

2. **Webhook Execution**:  
   - **URL**: `https://api.linkcreator.ai/wp-webhook/`  
   - **Data Sent**: JSON-encoded data
   - **Purpose**: To trigger certain actions via webhooks.

### Links to Service Terms and Privacy Policies

- [LinkCreator Service Terms of Use](https://linkcreator.ai/terms-of-use)
- [LinkCreator Privacy Policy](https://linkcreator.ai/privacy-policy)

By using this plugin, you agree to the terms and conditions of these external services.

== Installation ==

1. Upload the `linkcreator` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin settings via the 'Settings' menu in WordPress.

== Frequently Asked Questions ==

= How do I connect my site to Linkcreator AI? =

Navigate to the plugin settings and follow the instructions to connect your site to Linkcreator AI using your API key.

= Is there a free version of Linkcreator AI? =

Currently, Linkcreator AI offers a trial period. For continued use, a subscription is required.

== Screenshots ==

1. Add your website view screenshot-1.jpg
2. Model for website view screenshot-2.jpg
3. Article to link view screenshot-3.jpg

== Changelog ==

= 1.0.0 =
* Initial release of LinkCreator AI.
* Added new settings page for better customization.
* Improved error handling and logging.
* Improved performance and stability.
* Added new AI link optimization features.
* Fixed bugs related to API connectivity.
* Fixed security issues.
* Handled future API changes.
* Upgrade to benefit from the new AI link optimization features and improved performance.
* Release date: May 15, 2024

== Upgrade Notice ==

== License ==

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc., 51 Franklin
Street, Fifth Floor, Boston, MA 02110-1301, USA.

For any questions, please contact: Info@linkcreator.ai
