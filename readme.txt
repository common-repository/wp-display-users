=== Display Users ===
Contributors: Devnath verma
Plugin Name: Display Users
Tags: widget, users, author, subscriber, editors.						
Requires at least: 4.8.0 
Tested up to: 5.5.1
Stable tag: 1.0.0
Version: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin provides that allows you to display **Users** in any custom template, page and widgetized sidebar.

= Features = 

* Create multiple roles
* Choose user role which you want to display 
* Option to display users as selected order by name, id, etc...
* Option to display users as selected order asc, desc
* Set limit of user display
* Display name, description, email or URL in frontend side
* Include or exclude user by user IDs
* Display avatar on frontend
* Change avatar Size, Align, Shape
* Fully Responsive

= shortcode =

[wp_display_user id=role-id]

You can use the <code>[wp_display_user id=role-id]</code> shortcode to display users lisiting in page.

You can also use this shortcode for custom template.

`<?php echo do_shortcode("[wp_display_user id=role-id]"); ?>`

== Installation ==

= Minimum Requirements =

* WordPress 4.0 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

**This section describes how to install the plugin and get it working**

= Manual installation =

1. Download the plugin and extract its contents.
2. Upload the `wp-display-users` folder to the `/wp-content/plugins/` directory.
3. Activate **WP Display Users** plugin through the "Plugins" menu in WordPress.
4. After activating check the side menu -> "WP Display Users".
5. In your admin console, go to Appearance > Widgets, drag the "Display Users" to wherever you want it to be and click on Save.

That's it!


== Screenshots ==

1. Add role Display users Page.
2. Manage roles Display users Page.
3. Display users on posts or pages in frontend with avatar (Square).
4. Display users on posts or pages in frontend with avatar (Rounded).
5. Appearence widget menu screen.
6. Display users in sidebar with left side avatar.
7. Display users in sidebar with right side avatar.

== Changelog ==