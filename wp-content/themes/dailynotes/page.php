<?php get_header(); ?>
<!--Start Side Central (SC)-->
<div class="SC">

<!--Start Side Left-->
<div class="SL">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<!--Start Post-->
<div class="post">
<div class="p-head">
 <h1><?php the_title(); ?></h1>
</div>
  <div class="p-con">
  <?php the_content('Read the rest of this entry &raquo;'); ?>  
</div>
</div>
<!--End Post-->
<?php //comments_template(); ?>	
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
