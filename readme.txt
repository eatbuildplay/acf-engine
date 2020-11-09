=== ACF Engine ===
Contributors: eatbuildplay
Donate link: https://eatbuildplay.com/donate/
Tags: acf, post types, taxonomies, blocks, builder
Requires at least: 5.0
Tested up to: 5.5
Stable tag: 1.0
Requires PHP: 7.3
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

ACF Engine is a toolkit for building dynamic WP sites and leveraging ACF (Advanced Custom Fields). ACF Engine provides interfaces for registering site assets including custom post types, taxonomies, options pages and Gutenberg blocks.

== Description ==

ACF Engine is a toolkit for building dynamic WP sites and leveraging ACF (Advanced Custom Fields). ACF Engine provides interfaces for registering site assets including custom post types, taxonomies, options pages and Gutenberg blocks.

All assets that you register with ACF Engine are stored as JSON files and can be easily migrated to any other website powered by ACF Engine.

== Frequently Asked Questions ==

= Is this plugin similar to JetEngine by Crocoblocks? =

Yes it is modelled after the JetEngine approach and was inspired by the comprehensive building tools provided by JetEngine. However ACF Engine diverges from JetEngine in two primary ways, first by using ACF exclusively as the meta field hander and secondly by taking a Gutenberg block first approach to rendering.

= How does ACF Engine store JSON definitions of objects? =

ACF Engine parses all the data settings for a given object such as a custom post type, converts this into JSON and stores it under the "/acfengine" directory which is located at /wp-content/uploads/acfengine/. If you have 2 sites with ACF Engine running, you should find you can easily drop a JSON object definition file from one site to another and have that object load automatically.

== Screenshots ==

1. Main Menu
2. ACF Engine Dashboard, provides an overview of all the objects you've created with ACF Engine and links to manage your objects.

== Changelog ==

= 1.0.3 =
* Fixed incorrect PHP version requirement listing 
* Added new screenshots for the directory listing
* Optimized loading of core block types
* Removed RenderCode objects in favor of focusing on more Template options

= 1.0.2 =
* Updates Freemius WP API to latest version
* Fix to call order for admin settings pages

= 1.0.1 =
* Initial public version submitted to WP plugin directory

= 1.0.0 =
* First release of ACF Engine.

== Upgrade Notice ==

= 1.0 =
No upgrade available yet, we just built it!
