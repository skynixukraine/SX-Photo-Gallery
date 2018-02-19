=== SX Photo Gallery ===
Contributors: skynix
Donate link: do not have yet
Tags: photo, gallery, simple, inline, free, wordpress, plugin, skynix
Requires at least: 4.6
Tested up to: 4.9.4
Stable tag: 1.0.0
Requires PHP: 5.5
License: GPL3
License URI: https://www.gnu.org/licenses/gpl.html

SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.

== Description ==

SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.
All You need is to install it, create a gallery and upload photos. After that You will be able to put a shortcode in any wordpress content section and
and gallery will appear on that page.

Guide on how to use this plugin:
First of all install the plugin as described in "Installation".
After that new items will be added to admin menu:
* SX Photo Gallery - menu item with plugin logo on side of it.
It contains pages like Settings where you can set up the plugin for Your needs.
For example, you can choose a galleries skin.
* SX Photo Galleries - menu item with wordpress default "posts" icon next to it.
It contains subpages:
* All photos - view and manage all photos
* Add New Photo
* All SX Photo Galleries - manage all galleries ( view, add new, delete, edit )

Before uploading photos You should create at least one gallery.
To do this go to SX Photo Galleries -> All SX Photo Galleries and enter name for new gallery. You can also add some description (optional)
and specify slug (unique). If you don't specify a slug it will be generated from it's name. Slug is used when you output the gallery.
For outputting the gallery use a shortcode "SXPhotoGallery" in a page content. Example: [SXPhotoGallery gallery-slug] where "gallery-slug" is
a slug of Your gallery. Only one gallery can be used in one shortcode, but You can use multiple shortcodes in same content area.
So, You can display multiple galleries or same gallery multiple times on one page.

After some galleries where created You can add photos.
It is similar to how you create ordinary post in WordPress:
1. navigate to SX Photo Galleries -> Add New Photo, or SX Photo Galleries -> All Photos and press button "Add New Photo".
2. Enter photo name in "Title" field.
3. On the right side of screen You can choose to which galleries should photo be added.
4. And lower in same screen area press "Set featured image". Select desired image from existing photos in media library or upload some new and add them.

After these actions Your gallery will be ready to use.

== Installation ==
1. Install the plugin through the WordPress plugins screen directly or Upload the plugin files to the `/wp-content/plugins/plugin-name` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= How to create a gallery? =

1. Go to SX Photo Galleries -> All SX Photo Galleries.
2. Enter name for new gallery.
3. If needed - fill other fields.
4. Press "Add New Gallery". New gallery will appear in the table-list of galleries.

= How to upload a photo? =

You should have at least one gallery created. When You do, follow these steps:
1. navigate to SX Photo Galleries -> Add New Photo, or SX Photo Galleries -> All Photos and press button "Add New Photo".
2. Enter photo name in "Title" field.
3. On the right side of screen choose a gallery(ies) for the photo.
4. Press "Set featured image". Select desired image from existing photos in media library or upload some new and select them.

= How to display gallery? =

Add [SXPhotoGallery gallery-slug] to content of a post or page, where "gallery-slug" is a slug of Your gallery.

= How to find out a gallery slug? =

Go to SX Photo Galleries -> All SX Photo Galleries.
There will be a table with list of created galleries on the right.
One of the columns in that table is called "Slug", and that is where You can find out slug of any gallery.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0.0 =
Plugin uploaded.
