=== About Me widget ===
Contributors: Sam Devol, John BouAntoun
Donate link: http://samdevol.com/
Tags: about me, widget, sidebar, bio, tinyMCE
Requires at least: 3.1
Tested up to: 3.1
Stable tag: 2.2

Add an "About Me" widget to your sidebar.

== Description ==

Since I don't consider my blog anonymous or 'seekrit' I grabbed a text widget and started adding an "About Me" to my sidebar. After trying to get things aligned, formatted, and adding a few links I started thinking a widget might be nice for this. Et voila. This was my first-ever widget, so I appreciate your patience ;')

Now, with over 8000 downloads I am releasing what I hope to be a more friendly widget. The biggest issues previously were related to path(s), layout and alignment. This left me wanting to re-design the configuration interface, keeping in mind a lot of users know little about HTML/CSS and validity issues, yet allowing the geekier to get into details/code if so desired.

After a lot of hours designing, testing and uttering quite a few curses, my head finally popped out of my sphincter and I decided to use what WordPress uses: TinyMCE. WordPress users are at least somewhat familiar with it, it's already 'built-in' (no extra libraries/scripts) and I soon discovered it was easily configurable. Actually it's easily configurable AFTER you've learned how. Before, it's a bitch.

So here it is. The New King Hell Deluxe About Me Widget Supreme (ymmv)

!!Note!!
This version is not backwards compatible with versions of wordpress older than 3.1
If you are upgrading to version 2.0 from an older version be sure to copy the old about me text out before upgrading, as the new API creates new values for the title and text in the wordpress database.

== Installation ==

To install:

1. Drop the about-me-widget folder into your wp-content/plugins folder

2. Go to your Administration:Plugins page and activate the About Me Widget


To configure:

1. Go to Admin:Appearance:Widgets

2. Move (drag and drop) the widget to where you would like it in your active sidebar.

3. Click on the config button for the About Me widget (little notepad icon thingy on the right)

4. Enter the title you want visitors to see on the sidebar

5. Enter a url you would like the title to take you to (if you have more detailed 'About Me' page

6. Click in the editor window and start designing your own widget!!!


To put together a generic 'about me' design:

1. Select the image icon above the editor (looks like a tree)
     
2. Enter the URL (path) to the image (relative is fine, e.g.; /wp-content/uploads/portrait.jpg)
     
3. Enter Image Description, Title
     
4. Select the appearance tab and use the pull-down menu to apply an alignment class
     
5. Click the Update button
     
6. Back in the editor now, type some text (a blurb about yourself or your site).
     
7. Hi-lite the text and use the pull-down styles menu to apply alignment class/style
     
8. Add some links, if you wish, then repeat #7 to the link/anchor text.
     
9. Close the config window when you're finished and hit the Save Changes button 
     
== Screenshots ==

1. Configuration interface 
2. ta-da!

== Changelog ==

= 2.2 =
* Fixed the about me widget admin form button binding on admin widgets screen to make it work in WP 3.1 +
Be aware that this uses an even nastier trick to bind every click event of all widgets on the widget form in order to find out if the tinyMCE editor has been clicked and as such probably makes it incompatible with any other widgets that override the widget save ajax event.

= 2.1 =
* Fixed the about me widget admin form button binding on admin widgets screen to make it work in WP 2.9 +
* removed some un-need old version lang files for the advimage plugin
* added a needed lang file for the advimage plugin en_dlg.js

= 2.0 =
* Updates widget to work with new WordPress Widget API as of WP version 2.8.2. 
* Added ability to have the adbout me title be clickable link to a wordpress page
* Updated the tinymce advimage plugin to be compatible with latested tinyMCE version
* Breaks backwards compatibility!!!!
* Many thanks to John BouAntoun, without whom this version would not have been possible,  -Sam

= 1.02 = 
* Fixes an issue that arises when installing from http://wordpress.org/extend/plugins/about-me-widget. 
* Top directory name no longer is hard-coded (Editor appears with no buttons).
 
= 1.03 =
* fixes an issue that arises when installing from http://wordpress.org/extend/plugins/about-me-widget. 
* Parent directory name no longer contains 'backward' slash (Was still having problems on IIS servers?).
 
== Feedback == 
http://samdevol.com/about-me-widget-for-wordpress/

== Support Forum ==
http://www.samdevol.com/wp-content/myforums/viewforum.php?id=3
