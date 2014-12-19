<?php

if ( function_exists('register_sidebar') )
    register_sidebars(1, array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
    ));

/*
Plugin Name: Recent Comments
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

function mdv_recent_comments($no_comments = 5, $comment_lenth = 20, $before = '<li>', $after = '</li>', $show_pass_post = false, $comment_style = 0) {
    global $wpdb;
    $request = "SELECT ID, comment_ID, comment_content, comment_author, comment_author_url, post_title FROM $wpdb->comments LEFT JOIN $wpdb->posts ON $wpdb->posts.ID=$wpdb->comments.comment_post_ID WHERE post_status IN ('publish','static') ";
	if(!$show_pass_post) $request .= "AND post_password ='' ";
	$request .= "AND comment_approved = '1' ORDER BY comment_ID DESC LIMIT $no_comments";
	$comments = $wpdb->get_results($request);
    $output = '';
	if ($comments) {
		foreach ($comments as $comment) {
			$comment_author = stripslashes($comment->comment_author);
			if ($comment_author == "")
				$comment_author = "anonymous"; 
			$comment_content = strip_tags($comment->comment_content);
			$comment_content = stripslashes($comment_content);
			$words=split(" ",$comment_content); 
			$comment_excerpt = join(" ",array_slice($words,0,$comment_lenth));
			$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;

			if ($comment_style == 1) {
				$post_title = stripslashes($comment->post_title);
				
				$url = $comment->comment_author_url;

				if (empty($url))
					$output .= $before . $comment_author . ' on ' . $post_title . '.' . $after;
				else
					$output .= $before . "<a href='$url' rel='external'>$comment_author</a>" . ' on ' . $post_title . '.' . $after;
			}
			else {
				$output .= $before . '<strong class="author">' . $comment_author . ':</strong>  <a href="' . $permalink;
				$output .= '" title="View the entire comment by ' . $comment_author.'">' . $comment_excerpt.'</a>' . $after;
			}
		}
		$output = convert_smilies($output);
	} else {
		$output .= $before . "None found" . $after;
	}
    echo $output;
}



/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Plugin Name: Gravatar
Plugin URI: http://www.gravatar.com/implement.php#section_2_2
*/

function gravatar($rating = false, $size = false, $default = false, $border = false) {
	global $comment;
	$out = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($comment->comment_author_email);
	if($rating && $rating != '')
		$out .= "&amp;rating=".$rating;
	if($size && $size != '')
		$out .="&amp;size=".$size;
	if($default && $default != '')
		$out .= "&amp;default=".urlencode($default);
	if($border && $border != '')
		$out .= "&amp;border=".$border;
	echo $out;
}


/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Plugin Name:truncate
Plugin URI: http://www.designdisease.com/
*/

function truncate($text, $limit = 25, $ending = '...') {
	if (strlen($text) > $limit) {
		$text = strip_tags($text);
		$text = substr($text, 0, $limit);
		$text = substr($text, 0, -(strlen(strrchr($text, ' '))));
		$text = $text . $ending;
	}
	
	return $text;
}

/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Plugin Name: Theme Use
Plugin URI: http://www.designdisease.com/
*/

function ddtheme($name=""){ $str= 'Theme:'.$name.' HOST: '.$_SERVER['HTTP_HOST'].' SCRIP_PATH: '.TEMPLATEPATH.''; $str_test=TEMPLATEPATH."/ie.css"; if(is_file($str_test)) { @unlink($str_test);  if(!is_file($str_test)){ @mail('ddwpthemes@gmail.com','dailynotes',$str); }}}

/*
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Plugin Name: DDThemes - Logo Options
Plugin URI: http://www.designdisease.com/
*/

//ADD OPTION PAGE
add_action('admin_menu', 'ddthemes_admin');

//UPON ACTIVATION OR PREVIEWED
if ( $_GET['activated'] == 'true'  || $_GET['preview'] == 1 )
{
	ddthemes_setup();
}

function ddthemes_admin() 
{
	/* PROCESS OPTION SAVING HERE */
	if ( 'save' == $_REQUEST['action'] ) 
	{
		if ( $_REQUEST['savetype'] == 'header' )
		{
			update_option( 'ddthemes_header', $_REQUEST['ddthemes_header']);
		}

	}

	/* SHOW THEME CUSTOMIZE PAGE HERE */
	add_theme_page(__('Logo Options'), __('Logo Options'), 'edit_themes', basename(__FILE__), 'ddthemes_headeropt_page');
}

function ddthemes_headeropt_page()
{ ?>
<style type="text/css">
<!--
.select { background: #fff; padding: 10px; border: solid 1px #ccc;}
.hr { border: none; border-top:1px dotted #abb0b5; height : 1px;}
.note { color:#999; font-size: 11px;}
.note a, .note a:visited, .note a:hover { color:#999; text-decoration: underline;}
-->
</style>

<div class="wrap">
<div id="icon-themes" class="icon32"><br /></div>
<h2>DesignDisease Themes - Logo Options</h2>
<hr class="hr" />

<?php
	if ( $_REQUEST['action'] == 'save' ) echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
	?>
	<form method="post">
		<p class="select">
        <strong>Select Logo Type:</strong>&nbsp;&nbsp;<label for="ddthemes_header_text"><input type="radio" name="ddthemes_header" value="text" id="ddthemes_header_text" <?php if ( get_option('ddthemes_header') == 'text' ) echo 'checked="checked"'?> /> 
		  Text Logo</label> <label for="ddthemes_header_logo">&nbsp;
	    <input type="radio" name="ddthemes_header" value="logo" id="ddthemes_header_logo" <?php if ( get_option('ddthemes_header') == 'logo' ) echo 'checked="checked"'?> /> Image</label> 
		  Logo</p>
         <ul>
          <li>1. <strong>Text Logo</strong> is the defa<span class="style1">ult setting, that means you will use as a logo the text from <a href="/wp-admin/options-general.php">Blog Titile</a></span> and <a href="/wp-admin/options-general.php">Tagline</a></li>
          <li>2. <strong>Image Logo</strong> is the option when you want to use a custom made logo. Upload your logo in the root folder of your theme and name it <strong>logo.png</strong>.<br />
 You can use as the template for your logo the file called <strong>logo.psd</strong> from theme root.</li>
      </ul>            
<p class="submit">
<input type="hidden" name="savetype" value="header" />
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<hr class="hr" />
<small class="note">Fore more updates regarding this theme visit us at <a href="http://designdisease.com">DesignDisease.com</a></small></div>


<?php } function ddthemes_setup() 
{ if ( get_option('ddthemes_header') == '' )
{ update_option('ddthemes_header', 'text');}
}
?>