<?php get_header(); ?>

<!--start side central-->
<div class="SC">

<!--SL Start-->
<div class="SL">

<?php if (have_posts()) : ?>
<h1 class="title">Search Results</h1>

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
<h1 class="title">Search Results</h1>
<div class="p-con">
<p style="color:#F30">Your search - did not match any documents.  </p>
<h3>Suggestions: </h3>
<ul>    
  <li>Make sure all words are spelled correctly.</li>
  <li>Try different keywords.</li>
  <li>Try more general keywords.</li>
</ul>
</div>
<?php endif; ?>
</div>
<!--SL End -->

<?php get_sidebar(); ?>

 </div>
<!--end SC-->

<?php get_footer(); ?>

