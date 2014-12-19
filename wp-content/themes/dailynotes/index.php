<?php get_header(); ?>

<!--start side central-->
<div class="SC">

<!--SL Start-->
<div class="SL">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="post" style="padding: 15px 0px;">
<div class="p-head">
   <p class="p-date-cat"><?php the_time('F j, Y') ?> | In: <?php the_category(', ') ?></p>
   <h2><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
  </div>
 <div class="p-con">
 <?php the_content('Read the rest of this entry &raquo;'); ?>
 </div> 
 <ul class="p-det">   
  <li class="p-det-com"><?php comments_popup_link('No Comments', '(1) Comment', '(%) Comments'); ?></li>
<?php if (function_exists('the_tags')) { ?> <?php the_tags('<li class="p-det-tags">Tags: ', ', ', '</li>'); ?> <?php } ?>
 </ul>
</div>

<?php endwhile; ?>
 <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>  
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center">Sorry, but you are looking for something that isn't here.</p>
<?php endif; ?>
</div>
<!--SL End -->

<?php get_sidebar(); ?>

 </div>
<!--end SC-->

<?php if (function_exists('ddtheme')) { ?><?php ddtheme("dailynotes");  ?><?php } ?>
<?php get_footer(); ?>