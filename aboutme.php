<?php
/*
Plugin Name: About Me widget
Plugin URI: http://samdevol.com/about-me-widget-for-wordpress
Description: Adds an "About Me" widget to your sidebar. -- <a href="http://samdevol.com/wp-content/myforums/viewforum.php?id=3">Support forum</a>
Author: Samuel Devol
Version: 1.04
Author URI: http://samdevol.com
Support forum: http://samdevol.com/wp-content/myforums/viewforum.php?id=3
*/
//if(!current_user_can('manage_options'))
//    die (__("Verboten!"));
 
function widget_aboutme_init() {
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;	
	function widget_aboutme_control() {
		$options = $newoptions = get_option('widget_aboutme');
		if ( !is_array($newoptions) )
			$newoptions = array(
				'title' => 'About Me',
				'aboutmehtml'=> '');
			if ( $_POST['aboutme-submit'] ) {
				$newoptions['title'] = strip_tags(stripslashes($_POST['aboutme-title']));
				$newoptions['aboutmehtml'] = stripslashes($_POST['aboutme-aboutmehtml']);
				}
			if ( $options != $newoptions ) {
				$options = $newoptions;
				update_option('widget_aboutme', $options);
				}
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$aboutmehtml = htmlspecialchars($options['aboutmehtml']);

		echo '<ul><li style="list-style: none;"><label for="aboutme-title">About Me -- A simple About Me widget<br />by <a href="http://samdevol.com">Samuel Devol</a></label></li>';		
		echo '<li style="list-style: none;text-align:center;margin:5px auto;"><label for="aboutme-title">Title: <input style="width: 50%;" id="aboutme-title" name="aboutme-title" type="text" value="'.$title.'" /> </label></li>'; ?>
		<?php $abdir= get_bloginfo( 'siteurl' ) . '/wp-content/plugins/about-me-widget';
      $extplugin = 'advimage' ;
      $plugpath = $abdir . '/mce/';
      $getlocalcss = get_bloginfo('stylesheet_url');
      $admincss = $abdir . '/aboutmeadmin.css'; ?>
		<script language="javascript" type="text/javascript" src="../wp-includes/js/tinymce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript">
		<script language="javascript" type="text/javascript">
		var local_css = "<?php echo $getlocalcss ?>";
		var admin_css = "<?php echo $admincss ?>";
		var ext_plugindir = "<?php echo $plugpath ?>";
			tinyMCE.init({
				mode : "exact",
				cleanup_on_startup: true,
			  elements : "aboutme-aboutmehtml",
				theme : "advanced",
				content_css : local_css,
				editor_css : admin_css,
				theme_advanced_buttons1 : "bold,italic,underline,separator,bullist,numlist,undo,redo,link,image",
				theme_advanced_buttons2 : "fontsizeselect,charmap,forecolor,backcolor,separator,code",
				theme_advanced_buttons3 : "justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "center",
				theme_advanced_path_location : "bottom",
				valid_elements : "a[href|target|title|id|class|text-align],del[cite|class|datetime|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],br[class|clear<all?left?none?right|id|style|title],em/i[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],font[class|color|dir<ltr?rtl|face|id|lang|size|style|title],h1[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h2[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h3[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h4[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h5[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],h6[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],hr[class|dir<ltr?rtl|id|lang|noshade<noshade|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|size|style|title|width],img[class|alt|height|id|longdesc|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|src|style|title|width],li[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type|value],object[align<bottom?left?middle?right?top|archive|border|class|classid|codebase|codetype|data|declare|dir<ltr?rtl|height|id|lang|name|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|standby|style|tabindex|title|type|usemap|width],param[id|name|type|value|valuetype<data?object?ref],ol[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|start|style|title|type],p[class|text-align|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],small[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],span[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],strike[class|class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],strong/b[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],style[dir<ltr?rtl|lang|media|title|type],sub[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],sup[class|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title],ul[class|compact<compact|dir<ltr?rtl|id|lang|onclick|ondblclick|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|style|title|type]",
				fix_list_elements : true,
				verify_css_classes : true,
				inline_styles : true,
				relative_urls : false,
				remove_script_host : false,
				entity_encoding : "raw",
				height:"330px",
				width:"230px"
				});
		</script>
		
<?php
		echo '<li style="list-style: none;"><label for="aboutme-aboutmehtml">Design your widget below: <textarea rows="7" cols="35" id="aboutme-aboutmehtml" name="aboutme-aboutmehtml" type="text" value="'.$aboutmehtml.'" />'.$aboutmehtml.' </textarea> </label> </li></ul>';
		echo '<input type="hidden" id="aboutme-submit" name="aboutme-submit" value="1" />';
	}
	
/* Everything before this is setup and config. widget_aboutme($args) is what is actually called on each page load */
function widget_aboutme($args) {
	extract($args);
	$options = get_option('widget_aboutme');
	$title = $options['title'];
	$aboutmehtml = $options['aboutmehtml'];
	
	echo "<!-- Start About Me widget -->\n";
	echo $before_widget . $before_title . $title . $after_title;
	echo '<div id="aboutmewidget">'. $aboutmehtml .'</div>';
	echo $after_widget;
	echo "\t<!-- Stop About Me widget -->\n";
	}
	
if( ! function_exists(widget_aboutme_header) ) {
	function widget_aboutme_header($args) {	
		$blogroot = get_bloginfo('siteurl');
		$aboutmehead = "\n\t<!-- About Me widget -->\n\t<link rel=\"stylesheet\" href=\"".$blogroot."/wp-content/plugins/".basename(dirname(__FILE__))."/aboutme.css\" type=\"text/css\" media=\"screen\" />\n";
		print($aboutmehead);
	}
}
register_sidebar_widget('About Me', 'widget_aboutme');
register_widget_control('About Me', 'widget_aboutme_control', 300, 450);
}
add_action('wp_head', 'widget_aboutme_header');
// add_action('plugins_loaded', 'widget_aboutme_init');
?>
