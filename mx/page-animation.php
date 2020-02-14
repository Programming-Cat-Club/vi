<?php get_header();?>
<div class="g">
	<div class="row">
		<?php
		if(have_posts()){
			while(have_posts()){
				the_post();
				?>
				<div id="main" class="main g-desktop-3-4">
					<?php theme_functions::page_content();?>
					
					<?php comments_template();?>
				</div>
				<?php include __DIR__ . '/sidebar.php';?>
			<?php 
			}
		}else{ 
			?>
			
		<?php } ?>
	</div>
</div>
<?php get_footer();?>
<?php
    $cats = get_categories();
    foreach ( $cats as $cat ) {
    query_posts( 'showposts=10&cat=' . $cat->cat_ID );
?>
    <h3><?php echo $cat->cat_name; ?></h3>
    <ul class="sitemap-list">
        <?php while ( have_posts() ) { the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php } wp_reset_query(); ?>
    </ul>
<?php } ?>