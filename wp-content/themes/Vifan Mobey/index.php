<?php get_header(); ?>
<style>
.zbt{
	border:2px solid;
padding:10px;
border-color:red;
border-bottom-right-radius:1em;
border-top-right-radius:1em;
border-bottom-left-radius:1em;
border-top-left-radius:1em;
margin-left:10px;
margin-right:10px
}

a:link {color: blue; text-decoration:none;} //未访问：蓝色、无下划线 
a:active:{color: red; } //激活：红色 
a:visited {color:purple;text-decoration:none;} //已访问：紫色、无下划线 
a:hover {color: red; text-decoration:underline;} //鼠
</style>
		<!-- RIGHTPART -->
		<div class="arlo_tm_rightpart">
			<div class="rightpart_inner">
				<div class="arlo_tm_section" id="home">
					<div class="arlo_tm_hero_header_wrap">
						<div class="arlo_tm_universal_box_wrap">
							<div class="bg_wrap" >
								<div class="overlay_image hero jarallax" data-speed="0.1"></div>
								<div class="overlay_color hero"></div>
							</div>
							<div class="content hero" id="bg" style="background-image: url(http://boey.coding.me/vifanapp/Mobey/<?php echo rand(1,24);?>.jpg);background-repeat:no-repeat ;
background-size:100% 100%;
background-attachment: fixed;">
								<div class="inner_content">
									<div class="image_wrap">
										<img src="http://q.qlogo.cn/headimg_dl?bs=qq&dst_uin=2991883280&src_uin=www.jlwz.cn&fid=blog&spec=100">
									</div>
									<div class="name_holder">
										<h3><?php bloginfo('name'); ?></h3>
									</div>
									<div class="text_typing">
										<p><?php bloginfo('description'); ?></p>
									</div>
								</div>
							</div>
						<div class="arlo_tm_arrow_wrap bounce anchor">
								<a href="#contact"><img src="<?php bloginfo('template_url'); ?>/img/down1.png" width="40px" height="40px"></a>
							</div>

						</div>
						
					</div>
				</div>
		
		<?php if (have_posts()) :
		while (have_posts()) : the_post(); ?>
		
			
		
		<!-- CONTACT & FOOTER -->
				<div class="arlo_tm_section" id="contact">
	
					<div class="zbt">
							<a  class="aui-flex b-line">
                                
								<center> <h2><?php the_title(); ?> </h2><h5><?php the_author(); ?> </h5></center>
                                    <h5><?php the_time('Y-m-d') ?>~<?php comments_popup_link('0 条评论', '1 条评论', '% 条评论', '', '评论已关闭'); ?><?php edit_post_link('编辑', ' • ', ''); ?></h5>
                                    <h4><hr>
		
			<?php the_excerpt(); ?><h4>
		
	<a href="<?php the_permalink(); ?>"><button style="float:right; color:blue;" class="btn btn-info">阅读全文</button></a>
	<div >
	~ 

							</div>	
			</div>   
                      
								<br>
		<?php endwhile; ?>
					
			
  	
									
								
						
	<?php get_footer(); ?>
<!-- SCRIPTS -->
<script src="<?php bloginfo('template_url'); ?>/js/jquery.js"></script>
<!--[if lt IE 10]> <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/ie8.js"></script> <![endif]-->	
<script src="<?php bloginfo('template_url'); ?>/js/plugins.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/init.js"></script>
<!-- /SCRIPTS -->
		
							<div style="display:none;">
		<?php else : ?>
		
		<?php endif; ?>
		<?php get_sidebar(); ?>

							</div>	
</body>
</html>