<?php
/*
Plugin Name: About Me widget 0.98
Plugin URI: http://samdevol.com/about-me-widget-for-wordpress
Description: Adds an "About Me" widget to your sidebar
Author: Samuel Devol
Version: 0.98
Author URI: http://samdevol.com
Tips: Having problems with your image? Make sure it is in /wp-content/uploads/ 
*/

function widget_aboutme_init() {
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;	
	function widget_aboutme_control() {
		$options = $newoptions = get_option('widget_aboutme');
		if ( !is_array($newoptions) )
			$newoptions = array(
				'title'=>'About Me', 
				'imguri'=>'http://samdevol.com/wp-content/uploads/sam_smallbw.png',
				'imgw' => '120',
				'imgh' => '150',
				'imgtitle'=>'Sams Portrait',
				'fontcolor'=>'#888',
				'blurb'=>'Who the Hell are you?', 
				'moreabout'=>'http://samdevol.com/about-sam', 
				'moretitle'=>'Work Background', 
				'contactme'=>'http://samdevol.com/contact', 
				'contacttitle'=>'Contact Me', 
				'alignall'=>'center',
				'imgalign'=>'display:block;');
			if ( $_POST['aboutme-submit'] ) {
				$newoptions['title'] = strip_tags(stripslashes($_POST['aboutme-title']));
				$newoptions['imguri'] = strip_tags(stripslashes($_POST['aboutme-imguri']));
					$imguri = $newoptions['imguri']; 
					
					/* Following is a hack for people on servers with safe_mode. If the cURL extension is present
					   it creates a relative path for the getimagesize function. It will require the image be placed
					   in /wp-content/uploads/ */
						if ( !extension_loaded('curl')) $size = getimagesize($imguri);
						else {
							preg_match('|(wp-content/.*)|', $imguri, $ans);
							$relpath = '../'.$ans[1]; 
							$size = getimagesize($relpath);
							}
					/* End of safe_mode hack  */
					
				$newoptions['imgw'] = $size[0];
				$newoptions['imgh'] = $size[1];
				$newoptions['imgtitle'] = strip_tags(stripslashes($_POST['aboutme-imgtitle']));
				$newoptions['fontcolor'] = strip_tags(stripslashes($_POST['aboutme-fontcolor']));
				$newoptions['blurb'] = stripslashes($_POST['aboutme-blurb']);
				$newoptions['moreabout'] = strip_tags(stripslashes($_POST['aboutme-moreabout']));
				$newoptions['moretitle'] = strip_tags(stripslashes($_POST['aboutme-moretitle']));
				$newoptions['contactme'] = strip_tags(stripslashes($_POST['aboutme-contactme']));
				$newoptions['contacttitle'] = strip_tags(stripslashes($_POST['aboutme-contacttitle']));
				$newoptions['alignall'] = strip_tags(stripslashes($_POST['aboutme-alignall']));
					$alignall = $newoptions['alignall'];
					if ($alignall == "left")       {$imgalign = 'float:left;margin:5px;';}
					elseif ($alignall == "center") {$imgalign = 'display:block;margin:5px auto 0 auto;';}
					elseif ($alignall == "right")  {$imgalign = 'float:right;margin:5px;';}
					else echo 'Pick alignment again...';
				$newoptions['imgalign'] = $imgalign;
				}

			if ( $options != $newoptions ) {
				$options = $newoptions;
				update_option('widget_aboutme', $options);
			}
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$imguri = htmlspecialchars($options['imguri'], ENT_QUOTES);
		$imgw = htmlspecialchars($options['imgw'], ENT_QUOTES);
		$imgh = htmlspecialchars($options['imgh'], ENT_QUOTES);
		$imgtitle = htmlspecialchars($options['imgtitle'], ENT_QUOTES);
		$fontcolor = htmlspecialchars($options['fontcolor'], ENT_QUOTES);
		$blurb = htmlspecialchars($options['blurb'], ENT_QUOTES);
		$moreabout = htmlspecialchars($options['moreabout'], ENT_QUOTES);
		$moretitle = htmlspecialchars($options['moretitle'], ENT_QUOTES);
		$contactme = htmlspecialchars($options['contactme'], ENT_QUOTES);		
		$contacttitle = htmlspecialchars($options['contacttitle'], ENT_QUOTES);		
		$alignall = htmlspecialchars($options['alignall'], ENT_QUOTES);
		$imgalign = htmlspecialchars($options['imgalign'], ENT_QUOTES);
		echo '<ul><li style="text-align:center;list-style: none;"><label for="aboutme-title">About Me v0.98 -- A simple About Me widget<br />by <a href="http://samdevol.com">Samuel Devol</a></label></li>';		
		echo '<li style="list-style: none;"><label for="aboutme-title">Title: <input style="width: 100%;" id="aboutme-title" name="aboutme-title" type="text" value="'.$title.'" /> </label></li>';
		echo '<li style="list-style: none;"><label for="aboutme-alignall">Alignment: (left, center, right)<input style="width: 100%;" id="aboutme-title" name="aboutme-alignall" type="text" value="'.$alignall.'" /> </label></li>';
		echo '<input type="hidden" id="aboutme-title" name="aboutme-imgalign" value="'.$imgalign.'" />';
		echo '<li style="list-style: none;"><label for="aboutme-imguri">Image: (URL)<input style="width: 100%;" id="aboutme-title" name="aboutme-imguri" type="text" value="'.$imguri.'" /> </label></li>';
		echo '<li style="list-style: none; text-align:right;font-size:0.7em;"> Image size: '.$imgw.' x '.$imgh.' </li>';
		echo '<li style="list-style: none;"><label for="aboutme-imgtitle">Image title/text: <input style="width: 100%;" id="aboutme-title" name="aboutme-imgtitle" type="text" value="'.$imgtitle.'" /> </label></li>';
		echo '<li style="list-style: none;"><label for="aboutme-fontcolor">Font color: (black, #888, #98A8BB) <input style="width: 100%;" id="aboutme-title" name="aboutme-fontcolor" type="text" value="'.$fontcolor.'" /> </label></li>';
		echo '<li style="list-style: none;"><label for="aboutme-blurb">Blurb: <textarea rows="7" cols="35" id="aboutme-title" name="aboutme-blurb" type="text" value="'.$blurb.'" />'.$blurb.' </textarea> </label> </li>';		
		echo '<li style="list-style: none;"><label for="moreabout-link">More about me link: (URL)<input style="width: 100%;" id="aboutme-title" name="aboutme-moreabout" type="text" value="'.$moreabout.'" /> </label> </li>';
		echo '<li style="list-style: none;"><label for="moreabout-title">More about me title: <input style="width: 100%;" id="aboutme-title" name="aboutme-moretitle" type="text" value="'.$moretitle.'" /> </label> </li>';
		echo '<li style="list-style: none;"><label for="contactme-link">Contact Me: (URL or mailto:)<input style="width: 100%;" id="aboutme-title" name="aboutme-contactme" type="text" value="'.$contactme.'" /> </label> </li>';
		echo '<li style="list-style: none;"><label for="contactme-title">Contact Me title: <input style="width: 100%;" id="aboutme-title" name="aboutme-contacttitle" type="text" value="'.$contacttitle.'" /> </label> </li></ul>';
		echo '<input type="hidden" id="aboutme-submit" name="aboutme-submit" value="1" />';
	}

/* Everything before this is setup and config. widget_aboutme($args) is what is actually called on each page load */
function widget_aboutme($args) {
	extract($args);
	$options = get_option('widget_aboutme');
	$title = $options['title'];
	$imguri = $options['imguri'];
	$imgw = $options['imgw'];
	$imgh = $options['imgh'];
	$imgtitle = $options['imgtitle'];
	$fontcolor = $options['fontcolor'];
	$blurb = $options['blurb'];
	$moreabout = $options['moreabout'];
	$moretitle = $options['moretitle'];
	$contactme = $options['contactme'];
	$contacttitle = $options['contacttitle'];
	$alignall = $options['alignall'];
	$imgalign = $options['imgalign'];
	
/* If you need to do manual style changes, do them below. Carefully ;') */
	echo '<!-- Start About Me widget -->';
	echo $before_widget . $before_title . $title . $after_title;
	echo '<ul><li><img  style="'.$imgalign.'" src="'.$imguri.'" alt="'.$imgtitle.'" title="'.$imgtitle.'" width="'.$imgw.'px" height="'.$imgh.'px" /></li>';
	echo '<li style="display:block;color: '.$fontcolor.';margin: 0 0 1em 0;font-size: 0.8em;font-weight: normal;line-height: 125%;text-align:'.$alignall.';"><br />'.nl2br($blurb).'</li>';
	echo '<li style="color: '.$fontcolor.';margin: 1em 0 0 0;font-size: 0.8em;font-weight: normal;line-height: 125%;text-align:'.$alignall.';"><a href="'.$moreabout.'">'.$moretitle.'</a></li>';
	echo '<li style="color: '.$fontcolor.';margin:0;font-size: 0.8em;font-weight: normal;line-height: 125%;text-align:'.$alignall.';"><a href="'.$contactme.'">'.$contacttitle.'</a></li></ul>';
	echo $after_widget;
	echo '<!-- Stop About Me widget -->';
	}	
register_sidebar_widget('About Me', 'widget_aboutme');
register_widget_control('About Me', 'widget_aboutme_control', 345, 620);
}
add_action('plugins_loaded', 'widget_aboutme_init');
?>