=== ACF Engine ===
Contributors: eatbuildplay
Donate link: https://eatbuildplay.com/donate/
Tags: acf, custom post types, custom taxonomies, blocks, builder
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

The free version of ACF Engine provides the following Object Types.

* Custom Post Types. Register custom post types using the Post Type Editor. All options supported including the new "template" and "template_lock" arguments used to setup Gutenberg. Support for turning on/off Gutenberg editor, setup of WP archive page, REST settings and more.
* Custom Taxonomies. Supports all available WordPress taxonomy options including setup of either tags or categories (hierarchal taxonomies). Custom taxonomies can be associated with one or more post types, including both existing or newly registered ACF Engine Post Types.
* Options Pages. These are WP Admin pages created using ACF's page registration feature. These pages are then available as ACF field locations allowing you to build a sophisticated settings page for your site, plugin or theme.
* Block Types. Register ACF block types and associate field groups to create powerful dynamic custom blocks.
* Templates. ACF Engine has a template registry system similar to that found in Elementor and other page builders where you can add a template and assign it to work with given post types. This feature is in early stages of progression, but already supports "Single Post Templates" and "Archive Templates". These templates use dynamic Gutenberg blocks to load content, such as our ACF Field block.

# Core Block Types

ACF Engine provides core block types (in addition to providing a UX for registering custom blocks). The library of block types drafted is currently 55, however only a small number are considered "fully functional". These are being built at a rate of approximately 3-4 per week and will be uploaded to WP in the form of weekly block releases.

Notable core block types for rendering ACF fields include:

* ACF Field block. This will render any ACF field including repeater fields, it uses a "default render template" for each of the approx. 28 ACF field types.
* ACF Image block. This block is more specifically for image rendering of an image field and contains some image specific settings.
* ACF Template. This block renders a registered ACF Engine template. This enables nesting of templates inside of other templates.

# Development Roadmap

We are currently working primarily on ACF Engine Pro features such as front-end ACF forms and post queries. The forms will likely remain a pro-only feature, but there will be some trickle-down of the query features used to support post filtering and to power some of the more advanced block types. The main work specifically for the open source free version hosted at WordPress.org will be block type rendering. We're also working on documentation at https://acfengine.com and setting up demo sites to help users learn the common functionality and workflow of using ACF Engine to build data-driven sites.

== Frequently Asked Questions ==

= Is this plugin similar to JetEngine by Crocoblocks? =

Yes it is modelled after the JetEngine approach and was inspired by the comprehensive building tools provided by JetEngine. However ACF Engine diverges from JetEngine in two primary ways, first by using ACF exclusively as the meta field hander and secondly by taking a Gutenberg block first approach to rendering.

= How does ACF Engine store JSON definitions of objects? =

ACF Engine parses all the data settings for a given object such as a custom post type, converts this into JSON and stores it under the "/acfengine" directory which is located at /wp-content/uploads/acfengine/. If you have 2 sites with ACF Engine running, you should find you can easily drop a JSON object definition file from one site to another and have that object load automatically.

== Screenshots ==

1. Main Menu - ACF Engine free version has 5 primary object types that are fully supported including Post Types, Taxonomies, Options Pages, Block Types and Templates.
2. ACF Engine Dashboard - the simple ACF Engine dashboard currently provides only an overview of all the objects you've created with ACF Engine and links to manage your objects.
3. Post Type Editor - ACF Engine provides a beautiful user-friendly ACF tabbed interface. All options for registering custom post types are provided. With minimal settings a post type can be created in under 15-seconds.
4. Taxonomy Editor - ACF Engine provides an ACF tabbed UX for registering custom taxonomies. All options for taxonomy registration are provided. With minimal settings a taxonomy can be setup and associated with your custom post types in under 10-seconds.
5. Options Page Editor - ACF Engine provides an ACF tabbed UX for registering options pages. These are ACF pages that will appear in the WP admin, ACF field groups can then be associated with them. Previously this feature was only available for developers using code to register their options pages.

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
