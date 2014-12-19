<?php get_header(); ?>

<div class="mp-single-bar"></div>


<!--Start Side Central (SC)-->
<div class="SC">

<!--Start Side Left-->
<div class="SL">

<?php if (have_posts()) : ?>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<h2 class="title">Archive for the &#8216;<strong><?php single_cat_title(); ?></strong>&#8217; Category</h2>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h2 class="title">Posts Tagged &#8216;<strong><?php single_tag_title(); ?></strong>&#8217;</h2>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="title">Archive for <strong><?php the_time('F jS, Y'); ?></strong></h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="title">Archive for <strong><?php the_time('F, Y'); ?></strong></h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="title">Archive for <strong><?php the_time('Y'); ?></strong></h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="title">Author Archive</h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="title">Blog Archives</h2>
<?php } ?>

<?php while (have_posts()) : the_post(); ?>
 <div class="post" style="padding: 15px 0px;">
 <div class="p-head">
   <p class="p-date-cat"><?php the_time('F j, Y') ?> | In: <?php the_category(', ') ?></p>
   <h3><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h3>
  </div>
 <div class="p-con">
 <p><?php echo truncate($post->post_content,256); ?></p>
 </div>
 <ul class="p-det">   
  <li class="p-det-com"><?php comments_popup_link('No Comments', '(1) Comment', '(%) Comments'); ?></li>
<?php if (function_exists('the_tags')) { ?> <?php the_tags('<li class="p-det-tags">Tags: ', ', ', '</li>'); ?> <?php } ?>
 </ul>
</div>
<?php endwhile; ?>
 <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>  
<?php else : ?>
<h1 class="title">Error 404</h1>
<p style="color:#F30">404 Error: The page you are looking for can't be found. Sorry!</p>
<br />
<div class="p-con">
<h3>There could be a few different reasons for this:</h3>
<ul>
  <li>The page was moved or renamed.</li>
  <li>The page no longer exists on this site.</li>
  <li>The URL is incorrect.</li>
</ul>
<br />
<h3>To get you back on track, I'd suggest one of the following:</h3>
<ul>
  <li><a href="/about/">About <? bloginfo('name'); ?></a></li>
  <li><a href="/contact/">Report a broken link</a></li>
</ul>
<?php endif; ?>
</div>
<!--Start Side Right-->
<?php include 'sidebar.php'; ?>
<!--End Side Right-->

</div>
<!--End Side Central (SC)-->

<?php get_footer(); ?>
