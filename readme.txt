=== Related Posts By SearchIQ ===
Contributors: searchiq, findmsharma
Tags: related posts, sementic related posts, similar posts, related
Donate link: http://www.searchiq.co/
Requires at least: 3.7
Requires PHP: 5.3
Tested up to: 6.6.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Our FREE plugin uses our unique semantic search engine to display related posts on your website with our customizable grid or list layouts.

== Description ==

Related Posts By SearchIQ provides an enhanced related posts experience to your Wordpress site by adding related posts widgets to the posts and other choosen post types. You can configure how you want your related posts to show on your website. We provide different filters to allow you to show related posts only on your selected content.

## KEY Features

* Easy to setup - gets installed and configured with a few seconds.
* Customizable widgets and shortcode.
* Relevant related posts returned based on the post content.
* Filter categories and tags to show related posts
* A passionate, support available (nearly all hours) at support@searchiq.co
* Widgets for Gutenberg editor.

## Pricing

Related Posts By SearchIQ is absolutely free to get started with.

## Installation Video

[youtube https://www.youtube.com/watch?v=lT6jnC-nHeA]


## More Information

Visit [http://www.SearchIQ.co](http://www.SearchIQ.co) or contact us at [contact@searchiq.co](mailto:contact@searchiq.co)

== Installation ==
 
**SearchIQ related posts requires a partner key in order to activate and use the plugin.**

= Get your SearchIQ Partner Key =
1. Create an account on [SearchIQ](https://pubadmin.searchiq.co/signup.html).
2. Contact the SearchIQ team to register yourself as a partner.
3. Once you are confirmed as a partner, you'll get your Partner Key.


= Install and configure Related Posts By SearchIQ plugin =

You can use any of the methods mentioned below to install and activate **Related Posts By SearchIQ** plugin.

= 1. Install From Your Website = 

* Go to your website's admin area and select Plugins->Add New Plugin menu item
* In **Search Plugins** box search for **Related Posts By SearchIQ**
* Click on **Install Now** and **Activate** the plugin.



= 2. Install By Downloading From Wordress.org =

* Go to [https://wordpress.org/plugins/related-posts-by-searchiq/](https://wordpress.org/plugins/related-posts-by-searchiq/) and use the download button to download the plugin zip file.
* Go to your website's admin area and select Plugins->Add New Plugin menu item
* Click on **Upload Plugin** button and select the zip file you have downloaded.
* Click on **Install Now** and **Activate** the plugin.



= 3. Install Using WP-CLI =

* If you have WP-CLI installed on your server you can use the following command to install and activate the plugin:
`wp plugin install related-posts-by-searchiq --activate`


= STEPS AFTER INSTALLATION =
1. After you activate the plugin navigate to Related Posts Menu item in the wordpress admin dashboard.
2. On the plugin settings page enter your **Partner Key**.
3. After your partner key is verified you can setup the plugin further.
4. After the initial setup use the plugin block, widgets, shortcode to use the plugin on your site.

= Gutenberg Block =

Go to your post's Gutenberg editor and search for "SearchIQ Related Posts" block to install it. Configuration options are visible under **Block** settings.

= Shortcode =
Use the following shortcode to add related posts on any post.
`[siqrp template="list" heading="Layout Heading" limit="2"]`

**Shortcode options explained**
1. **template**: Use this option to to show the related posts in your preffered layout style. Allowed values **grid** or **list**.
2. **heading**: Use this option to add the layout heading text.
3. **limit**: Use this option to set the number of related posts to show.

= SearchIQ Related Posts Widget =

Go to your website's widget selection screen under **wp-admin->Appearance->Widgets** and search for **SearchIQ Related Posts** block to install it. Configuration options are visible under **Block** settings.

If you are facing any issues then please email at [support@searchiq.co](mailto:support@searchiq.co)

== Frequently Asked Questions ==

= How does the semantic engine determine related posts?
The semantic engine analyzes the content of your posts, including titles and body text. It identifies key concepts and relationships between words to understand the context and meaning. Based on this analysis, it matches posts with similar themes, topics, and concepts to display as related posts.

= Will the plugin affect my site's performance?
The plugin is designed to be efficient and lightweight, minimizing its impact on your site's performance. It uses optimized algorithms to process content and retrieve related posts quickly. Additionally, caching mechanisms are in place to reduce server load and improve response times.

= Can I customize the appearance of the related posts?
Yes, the plugin offers various customization options. You can choose from different layouts, adjust the number of related posts displayed, and style the appearance to match your site's design. Advanced users can also use custom CSS for more precise control over the look and feel.

= Is the plugin compatible with other WordPress themes and plugins?
The plugin is built to be compatible with most WordPress themes and plugins. It adheres to WordPress coding standards and best practices to ensure smooth integration. However, if you encounter any compatibility issues, the support team is available to help resolve them.

= How often does the semantic engine update the related posts?
The semantic engine updates the related posts dynamically. Whenever you publish a new post or update existing content, the engine re-evaluates the relationships and adjusts the related posts accordingly. This ensures that the related posts are always relevant and up-to-date.

== Screenshots ==

1. SearchIQ Related Posts Plugin - Grid View
2. SearchIQ Related Posts Plugin - List View
3. SearchIQ Related Posts Plugin - Grid View - 3 related posts view
4. SearchIQ Related Posts Plugin - Grid View - 2 related posts view
5. SearchIQ Related Posts Plugin - Wordpress Admin Plugin settings
6. SearchIQ Related Posts Plugin - Wordpress Admin Plugin settings - Template selection
7. SearchIQ Related Posts Plugin - Wordpress Post Editor - Widget

== Changelog ==

= Additional Information =

Information about source code for minified js/css files, external endpoints and third party libraries used by the **Related Posts By SearchIQ** plugin.

**Endpoints**

* Endpoint `https://content.searchiq.io/recommend`  to fetch related posts from the SearchIQ Related Posts API.
* Endpoint `https://content.searchiq.io/validate` to validate the partner key from the SearchIQ Related Posts API.
* Endpoint `https://content.searchiq.io/api/plugin_surveys` to collect data about reasons for deactivation of the plugin by presenting a simple survey form to the users when they deactivate the plugin.

Privacy policy for SearchIQ can be viewed here [SearchIQ Privacy Policy](https://www.searchiq.co/privacy-policy.html)

**Third Party Libraries**

* Plugin uses http://vodkabears.github.io/remodal/ library to present the survey form on plugin deactivation.

**Source Code For Minified CSS/JS**

* This plugin uses minified css and javascript files in order to make use of smaller file sizes for better performance. The source code for these files is also supplied with the plugin under `related-posts-by-searchiq/assets/src` folder.

= Changelog =

= 1.0.0 =
* Initial Release


== Upgrade Notice ==
= 1.0.0 =
Related Posts By SearchIQ is under constant development and improvement. Please update to the latest version if the plugin to use it to full potential.
