<?php get_header();?>
<div id="content" class="site-content">	
	<div class="clear"></div>
	<?php if (get_option('ygj_ddad') == '关闭') { ?>
	<?php { echo ''; } ?>
	<?php } else { include(TEMPLATEPATH . '/inc/ad/ad_dhl.php'); } ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php if (get_option('ygj_hdpkg') == '关闭') { ?>
		<?php { echo ''; } ?>
		<?php } else { include (TEMPLATEPATH . '/inc/slider.php');} ?>
	<div id="post_list_box" class="border_gray">
	<?php
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'cat' => get_option('ygj_new_exclude'),
			'orderby' => date,
			'paged' => $paged
		);
		query_posts( $args );
 	?>
		<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" class="archive-list">
		<figure class="thumbnail">		
			<?php get_template_part( 'inc/thumbnail' ); ?>					
		</figure>
		<header class="entry-header">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h2>		
		</header><!-- .entry-header -->
		
		<div class="entry-content">
			
			<span class="entry-meta">
				<span class="post_cat">
				<?php the_category( ' | ' ) ?>
			</span>
				<span class="post_spliter">•</span>
				<span class="date" title="<?php the_time( 'Y/m/d H:i');?>"><?php
        echo timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s'))) ?></span>			
			</span>		
			
			<div class="archive-content">			 				
				<?php if (has_excerpt()){ echo wp_trim_words( get_the_excerpt(), 80, '...' );} else { echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 160,"..."); } ?>
			</div>
			<div class="archive-tag"><span class="views"><?php if( function_exists( 'the_views' ) ) { print '  阅读 '; the_views(); print ' 次  ';  } ;?></span><?php the_tags('', '', '');?></div>
			<div class="clear"></div>
		</div><!-- .entry-content -->
	</article><!-- #post -->

 	<!-- ad -->
	<?php if ($wp_query->current_post == 1) : ?>
	<?php if (get_option('ygj_adh') == '关闭') { ?>
	<?php { echo ''; } ?>
	<?php } else { include(TEMPLATEPATH . '/inc/ad/ad_h.php'); } ?>
	<?php endif; ?>	
	<?php if ($wp_query->current_post == 5) : ?>
	<?php if (get_option('ygj_adhx') == '关闭') { ?>
	<?php { echo ''; } ?>
	<?php } else { include(TEMPLATEPATH . '/inc/ad/ad_hx.php'); } ?>
	<?php endif; ?>	
	<!-- end: ad -->
<?php endwhile; ?>
		<?php else : ?>
		<section class="content">
			<p>目前还没有文章！</p>
			<p><a href="<?php echo get_option('siteurl'); ?>/wp-admin/post-new.php">点击这里发布您的第一篇文章</a></p>
		</section>
		<?php endif; ?>	
		<?php if (get_option('ygj_gdjz')) { ?>
			<?php if ( !is_paged() ) { ?><?php ality_page_nav( 'nav-below' ); ?><?php } ?>
		<?php } ?>
</div>		
		</main><!-- .site-main -->		
		<?php pagenavi(); ?>
	</section><!-- .content-area -->
<?php get_sidebar();?>
<div class="clear"></div>
</div><!-- .site-content -->
<?php get_footer();?>