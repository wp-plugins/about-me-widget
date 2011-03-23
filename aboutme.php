<?php
/*
Plugin Name: About Me widget
Plugin URI: http://samdevol.com/about-me-widget-for-wordpress
Description: Adds an "About Me" widget to your sidebar.
Author: Samuel Devol & John BouAntoun
Version: 2.2
Author URI: http://samdevol.com ; http://jbablog.com
Support forum: http://samdevol.com/wp-content/myforums/viewforum.php?id=3
*/
//if(!current_user_can('manage_options'))
//    die (__("Verboten!"));
/**
 * About_Me_Widget Class
 */
class About_Me_Widget extends WP_Widget {
	
	// hold the version value
	var $tinyMCEVersion;
	
    /** constructor */
    function About_Me_Widget() {
        parent::WP_Widget(false, $name = 'About Me Widget');	
		$this->tinyMCEVersion = '3241';
    }
	
	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title']);
		$abouturl = empty($instance['url']) ? '' : $instance['url'];
		$aboutmehtml = empty($instance['aboutmehtml']) ? '&nbsp;' : $instance['aboutmehtml'];

		if($abouturl != '') {
			$abouturlopentag = '<a href="'.$abouturl.'">';
			$abouturlclosetag = '</a>';
		}
		else {
			$abouturlopentag = '';
			$abouturlclosetag = '';
		}

		echo "<!-- Start About Me widget -->\n";
		echo $before_widget . '<div id="aboutmewidget' . $this->number . '">' . $before_title ;
		echo $abouturlopentag . $title . $abouturlclosetag. $after_title . $aboutmehtml .'</div>' . $after_widget;
		echo "\t<!-- Stop About Me widget -->\n";		
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		$instance['aboutmehtml'] = $new_instance['aboutmehtml'];
 
		return $instance;
	}	
	
	function form($instance) {
		// set the Defaults
		$instance = wp_parse_args( (array) $instance, array('url'=>'', 'title'=>'About Me', 'aboutmehtml'=>'') );		
		$abouturl = $instance['url'];
		$title = htmlspecialchars($instance['title'], ENT_QUOTES);			
		$aboutmehtml = $instance['aboutmehtml'];

		// now render the form
		echo '<ul class="aboutmewidget"><li style="list-style: none;"><label for="' .$this->get_field_id('title') . '">About Me -- A simple About Me widget<br />by <a href="http://samdevol.com">Samuel Devol</a> and <a href="http://jbablog.com">John BouAntoun</a></label></li>';	
		echo '<li style="list-style: none;text-align:center;margin:5px auto;"><label for="' .$this->get_field_id('title') . '">Title: <input style="width: 50%;" id="' .$this->get_field_id('title') . '" name="' .$this->get_field_name('title') . '" type="text" value="'.$title.'" /> </label></li>';
		echo '<li style="list-style: none;text-align:center;margin:5px auto;"><label for="' .$this->get_field_id('url') . '">About URL: <input style="width: 50%;" id="' .$this->get_field_id('url') . '" name="' .$this->get_field_name('url') . '" type="text" value="'.$abouturl.'" /> </label></li>';		
		echo '<li style="list-style: none;"><label for="' . $this->get_field_id('aboutmehtml') . '">Design your widget below: <textarea rows="7" cols="35" id="' . $this->get_field_id('aboutmehtml') . '" name="' . $this->get_field_name('aboutmehtml') . '" type="text">'.$aboutmehtml.' </textarea> </label> </li></ul>';	
		// and the rich edit control
		$mce_options = $this->initialiseTinyMCEWidget('tinyMCEPreInit_' . $this->number, $this->get_field_id('aboutmehtml'));		
		$ver = apply_filters('tiny_mce_version', $this->tinyMCEVersion);
		
		// register some helper functions
		if(!is_numeric($this->number)) {
			echo "
				<script type='text/javascript'>
				/* <![CDATA[ */			
				// function to fix the save event of a control
				function fixWidgetSaveEvent() {
/* this code in widgets.dev.js (therefore widgets.js needs to be undone
		$('input.widget-control-save').live('click', function(){
			wpWidgets.save( $(this).closest('div.widget'), 0, 1, 0 );
			return false;
		});
*/					
					// unbind old click event
					jQuery('input.widget-control-save').die('click');
					
					//
					// DIRTY! DIRTY! DIRTY. As of WP 2.9 the devs use a live('click) event on the all save buttons which means I can't override it
					// 
					// So we just add a bind('click') call to the button itself and return false which runs before the button's live('click') event and cancels it. dirty but it works so long as we return true
					//				
					// rebind new click event
					jQuery('input.widget-control-save').live('click', function(){
						// detect if we are a normal widget or the about me widget and trigger a tinymce save if we are the about me widget 
						if(jQuery('ul.aboutmewidget', jQuery(this).closest('form')).length > 0) {							
							// the tinymce widget's id is the same as the textarea's using replacement														
							var editorID = jQuery('textarea', jQuery(this).closest('form')).get(0).id;							
							tinyMCE.get(editorID).save();
						}
						// call old click event functionality
						wpWidgets.save( jQuery(this).closest('div.widget'), 0, 1, 0 );
						return false;
						});			
				}
				
				// replace the click bindings
				fixWidgetSaveEvent();
				
				// actually bind another method on the click event of the open arrow to remove/readd the mce editor to work around a ajax issue
				function fixWidgetOpenEvent(button, mceEditorID, mceInitObject) {
					
					//
					// DIRTY! DIRTY! DIRTY. As of WP 2.9 the devs use a live('click) event on all edit widget buttons which means I can't override it
					// 
					// So we just add a bind('click') call to the button's parent which runs before the child's live('click') event. dirty but it works so long as we return true
					//
					// register the pre-save function to trigger an mce save
					button.parent().bind('click', function(){						
						var inside = jQuery('#' + mceEditorID).parents('.widget').children('.widget-inside');
						if(inside.is(':hidden')) {
							//
							// DIRTY! DIRTY! DIRTY. For some reason after a re-sort of the sidebar there are two rich editor elements with the same parent id even though jQuery says there is only one, 
							// 
							// So we just remove them all and readd, everytime the panel is opened
							//
							var editorCount = jQuery('.mceEditor', jQuery('#' + mceEditorID).closest('form')).length;							
							
							for(i = 0; i < editorCount; i++) {
								jQuery('#' + mceEditorID + '_parent').remove();
							}
							
							tinyMCE.init(mceInitObject.mceInit);
							tinyMCE.get(mceEditorID).show();
						}
						return true;						
					});
				}
				/* ]]> */
				</script>
			";
		}
		
		echo "
			<script type='text/javascript'>
			// initialise the editor
			tinyMCEPreInit_" . $this->number . " = {					
					base : '" . get_bloginfo('wpurl') . "/wp-includes/js/tinymce',
					suffix : '',
					query : '" . $ver ."',
					mceInit : {" .$mce_options . "},
					load_ext : function(url,lang){var sl=tinymce.ScriptLoader;sl.markDone(url+'/langs/'+lang+'.js');sl.markDone(url+'/langs/'+lang+'_dlg.js');sl.markDone(url+'/themes/advanced/langs/'+lang+'.js');}
				};			
			tinyMCEPreInit_" . $this->number . ".load_ext(tinyMCEPreInit_" . $this->number . ".base, 'en');			
			tinyMCE.init(tinyMCEPreInit_" . $this->number . ".mceInit);
			
			// workaround to make the sorting not break the tinyMCEeditor
			fixWidgetOpenEvent(jQuery('a.widget-action', jQuery('#" .$this->get_field_id('title') . "').parents('.widget')), '" . $this->get_field_id('aboutmehtml') . "',tinyMCEPreInit_" . $this->number . ");
			
			/* ]]> */
			</script>
			";
	}
	
	function initialiseTinyMCEWidget($tinyMCEEditorID, $elementID) {
		$abdir= get_bloginfo( 'wpurl' ) . '/wp-content/plugins/about-me-widget';
		$extplugin = 'advimage' ;
		$plugpath = $abdir . '/mce/';
		$getlocalcss = get_bloginfo('stylesheet_url');
		$admincss = $abdir . '/aboutmeadmin.css';
		
		// load the plugins for the editor
		// add the external advimage plugin
		$plugin_array[$extplugin] = $plugpath . $extplugin . '/editor_plugin.js';
		add_filter("mce_external_plugins", $plugin_array);
		
		// add the custom init array
		$initSettingsArray = array (
			'mode' => 'exact',
			'elements' => $elementID,
			'cleanup_on_startup' => true,
			'language' => 'en',
			'theme' => 'advanced',
			'plugins' => '-advimage',
			'content_css' => $local_css,
			'editor_css' => $admin_css,
			'theme_advanced_buttons1' => 'bold,italic,underline,separator,bullist,numlist,undo,redo,link,image',
			'theme_advanced_buttons2' => 'fontsizeselect,charmap,forecolor,backcolor,separator,code',
			'theme_advanced_buttons3' => 'justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect',
			'theme_advanced_toolbar_location' => 'top',
			'theme_advanced_toolbar_align' => 'left',
			'theme_advanced_path' => true,
			'theme_advanced_statusbar_location' => 'bottom',
			'valid_elements' => 'a[href|target|title|id|class|text-align],del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],br[class|clear<all?left?none?right|id|style|title],em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],h1[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h2[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h3[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h4[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h5[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h6[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],hr[class|dir<ltr?rtl|id|lang|noshade<noshade|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style|title|width],img[class|alt|height|id|longdesc|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|src|style|title|width],li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type|value],object[align<bottom?left?middle?right?top|archive|border|class|classid|codebase|codetype|data|declare|dir<ltr?rtl|height|id|lang|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap|width],param[id|name|type|value|valuetype<data?object?ref],ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|start|style|title|type],p[class|text-align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],span[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],style[dir<ltr?rtl|lang|media|title|type],sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type]',
			'fix_list_elements' => true,
			'verify_css_classes' => true,
			'convert_fonts_to_spans' => true,
			'inline_styles' => true,
			'relative_urls' => false,
			'remove_script_host' => false,
			'entity_encoding' => 'raw',
			'add_form_submit_trigger' => false,
			'height' =>"330px",
			'width' =>"230px"
		);		
		
		add_filter("tiny_mce_before_init", $initSettingsArray);
		
		$mce_options = '';
		foreach ( $initSettingsArray as $k => $v )
			$mce_options .= $k . ':"' . $v . '", ';
		$mce_options = rtrim( trim($mce_options), '\n\r,' );
		
		return $mce_options;
	}
}

function hookTinyMCEScriptCall($hook_suffix) {
	wp_enqueue_script('tinymce', get_bloginfo('wpurl') . "/wp-includes/js/tinymce/tiny_mce.js", array('common', 'admin-widgets', 'jquery','wp-ajax-response', 'jquery-color'), false , false);	 	
	wp_enqueue_script('about-me-widget-admin-langs', get_bloginfo('wpurl') . "/wp-includes/js/tinymce/langs/wp-langs-en.js", array('tinymce'), false , false);		
}

/**
* Register About me widget.
*
* Calls 'widgets_init' action after the Hello World widget has been registered.
*/
function AboutMeInit() {
	register_widget('About_Me_Widget');
}

add_action( "admin_print_scripts-$pagenow", 'hookTinyMCEScriptCall' );
add_action('widgets_init', 'AboutMeInit');
?>