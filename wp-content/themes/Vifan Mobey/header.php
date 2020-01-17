
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="description" content="<?php bloginfo('description'); ?>">



<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title><?php if ( is_home() ) {
		bloginfo('name'); echo " - "; bloginfo('description');
	} elseif ( is_category() ) {
		single_cat_title(); echo " - "; bloginfo('name');
	} elseif (is_single() || is_page() ) {
		single_post_title();
	} elseif (is_search() ) {
		echo "搜索结果"; echo " - "; bloginfo('name');
	} elseif (is_404() ) {
		echo '页面未找到!';
	} else {
		wp_title('',true);
	} ?></title>

<!-- STYLES -->
<style>
a{text-decoration:none;
color:	#000000;}
::-webkit-scrollbar{
display:none;
}


</style>















<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/plugins.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

<!--[if lt IE 9]> <script type="text/javascript" src="js/modernizr.custom.js"></script> <![endif]-->
<!-- /STYLES -->

</head>

<body >

<!-- WRAPPER ALL -->
<div class="arlo_tm_wrapper_all">

	<div id="arlo_tm_popup_blog">
		<div class="container">
			<div class="inner_popup scrollable"></div>
		</div>
		<span class="close"><a href="#"></a></span>
	</div>
	
	<!-- PRELOADER -->
	<div class="arlo_tm_preloader">
		<div class="spinner_wrap">
			<div class="spinner"></div>
		</div>
	</div>
	<!-- /PRELOADER -->
	
	<!-- MOBILE MENU -->
	<div class="arlo_tm_mobile_header_wrap">
		<div class="main_wrap">
			<div class="logo">
				<h3 style="color:blue;"><?php bloginfo('name'); ?></h3>
			</div>
			<div class="arlo_tm_trigger">
				<div class="hamburger hamburger--collapse-r">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="arlo_tm_mobile_menu_wrap">
   			<div class="mob_menu">
			
		
				<ul id="navigation" class="anchor_nav">

	<?php wp_list_pages('depth=1&title_li=0&sort_column=menu_order'); ?>
	<li <?php if (is_home()) { echo 'class="current"';} ?>><a title="<?php bloginfo('name'); ?>"  href="<?php echo get_option('home'); ?>/">主页</a></li>
</ul>

</ul>
			</div>
		</div>
	</div>
	<!-- /MOBILE MENU -->
	
    <!-- CONTENT -->
	<div class="arlo_tm_content">
		
		<!-- LEFTPART -->
		<div class="arlo_tm_leftpart_wrap">
			<div class="leftpart_inner">
				<div class="logo_wrap">
					<a href="#"><img src="<?php bloginfo('template_url'); ?>/img/logol.png" alt="" /></a>
				</div>
				<div class="menu_list_wrap">
					<ul id="navigation" class="anchor_nav">
	
	<?php wp_list_pages('depth=1&title_li=0&sort_column=menu_order'); ?>
	
	
	
	
	
	
	
	
	
	<li <?php if (is_home()) { echo 'class="current"';} ?>><a title="<?php bloginfo('name'); ?>"  href="<?php echo get_option('home'); ?>/">主页</a></li>
</ul>


				</div>
				<div class="leftpart_bottom">
					<div class="social_wrap">
					
						<ul>
							
							<li><a href="http://wpa.qq.com/msgrd?v=3&uin=2991883280&site=qq&menu=yes"><img src="<?php bloginfo('template_url'); ?>/img/qq.png" alt="" /></a></li>
							<li><a href="https://jq.qq.com/?_wv=1027&k=58xCA0H"><img src="<?php bloginfo('template_url'); ?>/img/qq.png" alt="" /></a></li>
							<li><a href="https://github.com/2991883280"><img src="<?php bloginfo('template_url'); ?>/img/github.png" alt="" /></a></li>
						
							
						</ul>
							
					</div>
				</div>
				<a class="arlo_tm_resize" href="#" onclick="pic();"><img src="<?php bloginfo('template_url'); ?>/img/down.jpg" id="1"><img src="<?php bloginfo('template_url'); ?>/img/down2.png" id="2" style="display:none;"></a>
				
				
				
				<script>
				var i=1
				function pic(){ 　
				i=i+1;
			if (i%2==0)
			{
				 document.getElementById('2').style.display="inline";
				  document.getElementById('1').style.display="none";
			}else{
				 document.getElementById('1').style.display="inline";
				  document.getElementById('2').style.display="none";
				
				
			}
				　　} 
		</script>	</div>
		</div>
		<!-- /LEFTPART -->
		