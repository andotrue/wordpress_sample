<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p>This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = ' alt';
?>

<!-- You can start editing here. -->

<div id="comments" class="comments-list">
<?php if ($comments) : ?>
<h2><?php comments_number('No Responses', '1 Response', '% Responses' ); ?> to <?php the_title(); ?></h2>
<?php foreach ($comments as $comment) : ?>
 <div class="entry <?php echo $oddcomment; ?>" id="comment-<?php comment_ID(); ?>">
 <p class="avt"><img src="<?php gravatar("R", 40); ?>" alt="Avatar" /></p> 
 <p class="name"><?php comment_author_link(); ?></p>
 <p class="date"><a href="#comment-<?php comment_ID() ?>"><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></a>  <?php edit_comment_link('edit','|&nbsp;',''); ?></p>
<?php if ($comment->comment_approved == '0') : ?>
 <p><em style=" font-style: normal; color:#FF0000;">Your comment is awaiting moderation.</em></p>
 <?php endif; ?>
 <div class="con"><?php comment_text() ?></div>
</div>

<?php $oddcomment = ( empty( $oddcomment ) ) ? ' alt ' : ''; ?>
<?php endforeach; ?>
							
<?php elseif ('open' != $post->comment_status) : ?>
<p class="note">Comments are closed.</p>
<?php endif; ?>
</div>

	
				
<?php if ('open' == $post->comment_status) : ?>
<div class="comments-form">
<h3 id="respond">Comment Form</h3>
<form id="comment-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
								
<?php if ( $user_ID ) : ?>
<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a></p><br />

<?php else : ?>
<p class="formbg"><input id="comment-name" value="<?php echo $comment_author; ?>" name="author"  type="text" class="formid" /> <label for="comment-name">Your Name  <span>*required</span></label></p>
<p class="formbg"><input id="comment-email" name="email" value="<?php echo $comment_author_email; ?>" type="text" class="formemail" /> <label for="comment-name">Your Email <span>*required</span></label></p>
<p class="formbg"><input id="comment-url" name="url" value="<?php echo $comment_author_url; ?>" type="text" class="formuri"/> <label for="comment-name">Your URL</label></p>
<?php endif; ?>								
<p class="formtxt"><textarea name="comment" cols="55" rows="4" style="width: 470px; height: 81px;"></textarea></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" class="button" value="Post" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php endif; ?>
</form>
</div>
<?php endif; ?>
