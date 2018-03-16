=== SX Photo Gallery ===
Contributors: skynix
# Donate link: do not have yet
Tags: photo, photo gallery, inline gallery, free gallery, wordpress gallery, gallery plugin, sx gallery, skynix
Requires at least: 4.6
Tested up to: 4.9.4
Stable tag: 1.0.0
Requires PHP: 5.6 or later
License: GPL3
License URI: https://www.gnu.org/licenses/gpl.html

SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.

== Description ==

SX Photo Gallery is FREE inline photo gallery. Allows easily run a photogallery on any wordpress site in minutes.
All You need is to install it, create a gallery and upload photos.
After that You will be able to put a shortcode in any wordpress content section and the gallery will appear on that page.

Guide on how to use this plugin:

First of all install the plugin as described in "Installation".
After that new menu item "SX Photo Gallery" will be added to admin menu.
It contains subpages like Settings where you can set up the plugin for Your needs.
* All photos - view and manage all photos
* Add New Photo
* Manage SX Galleries - manage all galleries ( view, add new, delete, edit )
* Settings - here you can manage some options, like select galleries skin, for example

Before uploading photos You should create at least one gallery.
To do this go to SX Photo Gallery -> Manage SX Galleries and enter name for new gallery. You can also add some description (optional)
and specify slug (unique). If you don't specify a slug it will be generated from gallery name. Slug is used when you output the gallery.

After some galleries where created You can add photos.
It is similar to how you create ordinary post in WordPress:
1. navigate to SX Photo Gallery -> Add New Photo, or SX Photo Gallery -> All Photos and press button "Add New Photo".
2. Enter photo name in "Title" field.
3. On the right side of screen You can choose to which galleries should photo be added.
4. And lower in same screen area click "Set featured image".
5. Select desired image from existing photos in media library or upload some new and add them.
6. Press "Publish" and photo will be added to the gallery.

After these actions Your gallery will be ready to use.
You can output the gallery multiple ways:
* Use a shortcode "SXPhotoGallery" in a page content. Example: [SXPhotoGallery gallery-slug] where "gallery-slug" is
a slug of Your gallery.
* Another way to add a gallery is simply go to edit page where you want to add a gallery.
Above the editor section there will be a button "Insert SX Photo Gallery". Press it and select a gallery from the list.
Than press "Insert" and a shortcode will be added to editor. Save the changes and gallery will be added to the page.
Only one gallery can be used per shortcode, but You can use multiple shortcodes in same content area.
So, You can display multiple galleries or same gallery multiple times on one page.

== Installation ==
1. Install the plugin through the WordPress plugins screen directly or Upload the plugin files to the `/wp-content/plugins/plugin-name` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress

== Frequently Asked Questions ==

= How to create a gallery? =

1. Go to SX Photo Gallery -> Manage SX Galleries.
2. Enter name for new gallery.
3. If needed - fill other fields.
4. Press "Add New Gallery" and new gallery will appear in the table-list of galleries.

= How to upload a photo? =

You should have at least one gallery created. When You do, follow these steps:
1. Navigate to SX Photo Gallery -> Add New Photo.
2. Enter photo name in "Title" field.
3. On the right side of screen choose a gallery(ies) for the photo.
4. Click "Set featured image".
5. Select desired image from existing photos in media library or upload some new and select them.
6. Press "Publish" and photo will be added to the gallery.

= How to display gallery? =

There are two ways:
First is to add [SXPhotoGallery gallery-slug] to content of a post or page, where "gallery-slug" is a slug of Your gallery and save changes.
Second is to follow these steps:
1. Go to edit screen of the page or post where you want to place a gallery.
2. Press "Insert SX Photo Gallery" button. Popup window will appear.
3. Select a desired gallery from a list and press "Insert". Shortcode will be added to content.
4. Save changes and gallery will appear on the page.

= How to find out a gallery slug? =

Go to SX Photo Gallery -> Manage SX Galleries.
There will be a table with list of created galleries on the right.
One of the columns in that table is called "Slug", and that is where You can find out slug of any gallery.

= How to find out what photos are in a gallery? =

You can either:
1. Go to SX Photo Gallery -> Manage SX Galleries.
2. In the table find column "Count". It will show how many photos each gallery has.
3. By pressing on the number You will be redirected to SX Photo Gallery -> All Photos
and there will be listed photos from only that particular gallery.

Or, You can do it this way:
1. Go to SX Photo Gallery -> All Photos.
2. On the filter bar You will see an option to filter by gallery. By default it says "Show All SX Galleries".
3. Press it, select desired gallery and press "Filter". All photos related to selected gallery will be listed.

= How to change gallery style? =

1. Go to SX Photo Gallery -> Settings.
2. Choose one of available styles from "SX Photo Gallery Skin" option.
3. Press "Save".

== Screenshots ==

1. SX Photo Gallery skin setting.
2. "All Photos" screen.
3. Add new gallery.
4. List of galleries.
5. Gallery example.

== Changelog ==

= 1.0.0 =
Plugin uploaded.

== Upgrade Notice ==

= 1.0.0 =
Plugin has default "SkynixDark" skin for galleries.
