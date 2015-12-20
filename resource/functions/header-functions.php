<?php

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//
// 		Header related functions
//
//		Q: Why place theme here instead of the functions.php file?
//		A: WordPress totally breaks if you make any accident changes
//		   to that file.
//
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Mobile Navigation
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

if(!function_exists('vntd_mobile_nav')) {
function vntd_mobile_nav($button = NULL) {

	global $smof_data;
	
	if(!$smof_data['vntd_responsive']) {
		return false;
	}

	
	if($button) {
		echo '<div id="vntd-mobile-nav-toggle"><i class="fa fa-bars"></i></div>';
	} else { ?>
		<div id="mobile-navigation" class="vntd-container">
			<?php wp_nav_menu( array('theme_location' => 'primary' )); ?>
		</div>	
	<?php }

}
}

if(!function_exists('vntd_nav_menu')) {
function vntd_nav_menu() {
	global $post;
	
	if (has_nav_menu('primary')) {
		if(get_post_meta(get_the_ID(), 'page_nav_menu', true) && get_post_meta(get_the_ID(), 'page_nav_menu', true) != 'default') {
			wp_nav_menu( array('menu' => get_post_meta(get_the_ID(), 'page_nav_menu', true),'container' => false,'menu_class' => 'nav font-primary', 'walker' => new Vntd_Custom_Menu_Class())); 
		} else {
			wp_nav_menu( array('theme_location' => 'primary','container' => false,'menu_class' => 'nav font-primary', 'walker' => new Vntd_Custom_Menu_Class())); 
		}
	} else {
		echo '<span class="vntd-no-nav">No custom menu created!</span>';
	}
}
}

if(!function_exists('vntd_navbar_style')) {
function vntd_navbar_style($type = NULL) {
	
	global $smof_data,$post;
	
	$navbar_style = $navbar_color = '';

	$navbar_style = vntd_option('navbar_style');
	
	return $navbar_style;
}
}

if(!function_exists('vntd_header_extra_content')) {
function vntd_header_extra_content() {
	echo '<div class="nav-extra-item nav-extra-item-text">';
	
	if(vntd_option('navbar_extra_type') == 'text') {
		echo do_shortcode(vntd_option('navbar_extra'));
	} elseif(vntd_option('navbar_extra_type') == 'search') {
		echo '<div class="nav-extra-search">';
		get_template_part('searchform');
		echo '</div>';
	} elseif(vntd_option('navbar_extra_type') == 'search-product') {
	
	}				
	
	
	
	echo '</div>';
}
}


// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Breadcrumbs
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

if(!function_exists('vntd_breadcrumbs')) {
function vntd_breadcrumbs() {

	global $post;
		
	if (!is_front_page() && get_post_type() != 'portfolio') {
	
        echo '<ul id="breadcrumbs" class="breadcrumbs page-title-side">';
        echo '<li><a href="';
        echo home_url();
        echo '">';
        //bloginfo('name');
        echo 'Home</a></li>';
        
		$product = false;
		if(class_exists('Woocommerce')) {
			if(is_product()) $product = true;
		}
        if (is_category()){
//            $catTitle = single_cat_title( "", false );
//            $cat = get_cat_ID( $catTitle );
//            echo "<li>". get_category_parents( $cat, TRUE, "  " ) ."</li>";
        }elseif (is_single() && !$product){
            if ( is_day() ) {
                printf( '%s', get_the_date() );
            } elseif ( is_month() ) {
                printf( '%s', get_the_date( _x( 'F Y', __('monthly archives date format','vntd_renown'), 'veented_backend' ) ) );
            } elseif ( is_year() ) {
                printf( '%s', get_the_date( _x( 'Y', __('yearly archives date format','vntd_renown'), 'veented_backend' ) ) );
            } else {
            	echo '<li>';
            	$frontpage_id = get_option('page_for_posts');
            	echo '<a href="'.get_permalink($frontpage_id).'">'.get_the_title($frontpage_id).'</a>';
                echo '</li>';
            }
        }
        if (class_exists('Woocommerce')) {
	        if(is_woocommerce() || is_product() || is_shop() || is_cart() || is_checkout() || is_account_page()) {        
	        	echo '<li><a href="'.get_permalink(get_option('woocommerce_shop_page_id')).'" title="'.get_the_title(get_option('woocommerce_shop_page_id')).'">'.get_the_title(get_option('woocommerce_shop_page_id')).'</a></li>';        
	        }
	    }
	    
	    if(is_404()) {
	    	echo '<li>'.__('Page not found','vntd_qaro').'</li>';
	    }

        if (is_single()) {
            echo '<li>';
            
            if(strlen(get_the_title()) > 30) {
            	echo substr(get_the_title(),0,30).'...';
            } else {
            	echo get_the_title();
            }
            
            echo '</li>';
        }

        if (is_page()) {
        	$parent_id = $post->post_parent;
        	if($parent_id) {
        	
        		$parent_page = get_page($post->post_parent);
        		
        		if($parent_page->post_parent) {
        			echo '<li><a href="'.get_permalink($parent_page->post_parent).'" title="'.get_the_title($parent_page->post_parent).'">'.get_the_title($parent_page->post_parent).'</a></li>';
        	     }
        	     echo '<li><a href="'.get_permalink($parent_id).'" title="'.get_the_title($parent_id).'">'.get_the_title($parent_id).'</a></li>';
        	}
        	echo '<li>';
        	
            if(strlen(get_the_title()) > 30) {
            	echo substr(get_the_title(),0,30).'...';
            } else {
            	echo get_the_title();
            }
            
            echo '</li>';
        }
        
        if (is_tag()) {
        	echo '<li>'.__('Archives','vntd_renown').'</li>';
        	echo '<li>'.__('Posts tagged by','vntd_renown').' "';
            echo single_tag_title('', false);
            echo '"</li>';
        } elseif (is_category()) {
        	echo '<li>'.__('Archives','vntd_renown').'</li>';
        	echo '<li>'.__('Posts by category','vntd_renown').' "';
            echo single_cat_title('', false);
            echo '"</li>';
        } elseif (is_month() || is_day()) {
        	echo '<li>'.__('Archives','vntd_renown').'</li>';
        	echo '<li>';
            the_time('F Y');
            echo '</li>';
        } elseif (is_year()) {
        	echo '<li>'.__('Archives','vntd_renown').'</li>';
        	echo '<li>';
            the_time('Y');
            echo '"</li>';
        } elseif (is_search()) {
            echo '<li>'.__('Search results for','vntd_renown').' "'.get_search_query().'"</li>';
        }

        if (is_home()){
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) { 
                $post = get_page($page_for_posts_id);
                setup_postdata($post);
                echo '<li>';
                the_title();
                echo '</li>';
                rewind_posts();
            }
        }

        echo '</ul>';
    }
}
}

if(!function_exists('vntd_logo_url')) {
function vntd_logo_url() {
	if(is_front_page()) {
		echo '#home';
	} else {
		echo site_url();
	}
}
}

//
// Page Title Function
//

if(!function_exists('vntd_print_page_title')) {
function vntd_print_page_title() {

	global $post,$smof_data;
	
	$page_id = 1;
	
	if(get_post_type() == 'services' || get_post_type() == 'testimonials') {
		return false;
	}	
	
	if(is_object($post)) {
		$page_id = $post->ID;
	}
	
	$page_title = get_the_title($page_id);
	
	if(is_home()) {
		$page_title = __('Blog','vntd_qaro');
	}
	
	$page_tagline_wrap = '';
	
	if(get_post_meta($page_id,'page_subtitle',TRUE)) {
		$page_tagline_wrap = '<p class="p-desc">'.get_post_meta($page_id,'page_subtitle',TRUE).'</p>';
	}
	
	if(is_search()) {
		$page_title = __('Search','vntd_qaro');
	} elseif(is_404()) {
		$page_title = __('Page not found','vntd_qaro');
	} elseif(is_archive()) {
		$page_title = __('Archives','vntd_qaro');
	}
	
	if (class_exists('Woocommerce')) {
	
		global $wp_query;
		
		if(is_shop()) {
			$page_title = __('Shop','vntd_qaro');
		}elseif(is_product_category()) {
			$cat = $wp_query->get_queried_object();
			$page_title = $cat->name;
		}elseif(is_product_tag()) {
			$cat = $wp_query->get_queried_object();
			$page_title = $cat->name;
		}
	}
	
	$extra_class = '';
	
	if(get_post_meta(vntd_get_id(), 'customize_enable', TRUE) == 'yes') {
		
		echo '<style type="text/css"> #page-title {';
		
		if(get_post_meta(vntd_get_id(), 'customize_bgcolor', TRUE)) echo 'background-color: '.get_post_meta(vntd_get_id(), 'customize_bgcolor', TRUE).';';
		if(get_post_meta(vntd_get_id(), 'customize_bgimage', TRUE)) {
			$imgurl = wp_get_attachment_image_src( get_post_meta(vntd_get_id(), 'customize_bgimage', TRUE), 'full');			
			$imgurl = $imgurl[0];
			echo 'background-image: url('.esc_url($imgurl).');';
		} 
		
		echo '}';
		
		// Text Align
		
		if(get_post_meta(vntd_get_id(), 'customize_textalign', TRUE) == 'center') {
			echo '#page-title,#breadcrumbs { text-align: center; } #breadcrumbs { position:relative; }';			
		}
		
		// Font Weight
		
		if(get_post_meta(vntd_get_id(), 'customize_fontweight', TRUE) == 700 || get_post_meta(vntd_get_id(), 'customize_fontweight', TRUE) == 800 || get_post_meta(vntd_get_id(), 'customize_fontweight', TRUE) == 'bold') {
			echo '#page-title h1 { font-weight:'.esc_attr(get_post_meta(vntd_get_id(), 'customize_fontweight', TRUE)).'; }';			
		}
		
		// Font Size
		
		if(get_post_meta(vntd_get_id(), 'customize_fontsize', TRUE) != 30) {
			echo '#page-title h1 { font-size:'.esc_attr(get_post_meta(vntd_get_id(), 'customize_fontsize', TRUE)).'px; }';			
		}
		
		// Font Color
		
		if(get_post_meta(vntd_get_id(), 'customize_textcolor', TRUE)) {
			echo 'body #page-title h1, #breadcrumbs a, #breadcrumbs li { color:'.esc_attr(get_post_meta(vntd_get_id(), 'customize_textcolor', TRUE)).'; }';			
		}
		
		// Text Transform
		
		if(get_post_meta(vntd_get_id(), 'customize_texttransform', TRUE) == "uppercase") {
			echo '#page-title h1, #breadcrumbs { text-transform:uppercase; }';			
		}
		
		// Height
		
		if(get_post_meta(vntd_get_id(), 'customize_height', TRUE) != '80') {
			$half = get_post_meta(vntd_get_id(), 'customize_height', TRUE)/2-28;
			echo '#page-title h1 { line-height:'.esc_attr(get_post_meta(vntd_get_id(), 'customize_height', TRUE)).'px; } #breadcrumbs { margin-bottom: '.$half.'px; }';			
		}
		
		// Breadcrumbs
		
		if(get_post_meta(vntd_get_id(), 'customize_breadcrumbs', TRUE) == "disabled") {
			echo '#breadcrumbs { display:none; }';			
		}		
		
		echo '</style>';
		
		
		
		if(get_post_meta(vntd_get_id(), 'customize_animated', TRUE) == 'yes') {
			$extra_class = ' page-title-animated';
		}
		
		
	}
	
	?>
	
	<section id="page-title" class="page_header <?php echo esc_attr(vntd_option('navbar_style')).esc_attr($extra_class); ?>">
		<div class="page-title-inner inner page_header_inner">
			<div class="page-title-holder">
				<h1><?php echo $page_title; ?></h1>
				<?php echo $page_tagline_wrap; ?>				
			</div>
			
			<?php
			if(array_key_exists('vntd_breadcrumbs', $smof_data)) {
				if($smof_data['vntd_breadcrumbs']) {
				
					vntd_breadcrumbs();
					
				}
			}
			?>
			
		</div>
	</section>
	
	<?php
	
}
}

//
// Top Bar
//

if(!function_exists('vntd_print_topbar')) {
function vntd_print_topbar() {

$topbar_skin = 'light';

if(vntd_option('topbar_skin')) {
	$topbar_skin = vntd_option('topbar_skin');
}

?>
<div id="topbar" class="topbar-skin-<?php echo $topbar_skin; ?>">
	<div class="nav-inner">
		<div class="topbar-left">
			<?php vntd_topbar_content('left'); ?>
		</div>
		<div class="topbar-right">
			<?php vntd_topbar_content('right'); ?>
		</div>
	</div>	
</div>
<?php
}
}

if(!function_exists('vntd_topbar_content')) {
function vntd_topbar_content($side) {
	global $smof_data;
	
	$type = vntd_option('topbar_'.$side);
	
	$bar_text = '<span class="topbar-text">'.do_shortcode(vntd_option('topbar_text_'.$side)).'</span>';
	
	// If more than 1 WPML language, display switcher
	
	if(function_exists('icl_get_languages') && sizeof(icl_get_languages('skip_missing=0')) > 1 && $side == 'right' && $smof_data['vntd_topbar_wpml']) {
		vntd_topbar_langs();
	}
	
	// Switch content type
		
	if($type == 'social') {
	
		echo '<div class="topbar-section topbar-social">';
		
		vntd_print_social_icons();
		
		echo '</div>';
	
	} elseif($type == 'Menu') {
	
		echo '<div class="topbar-section topbar-menu">';
	
		wp_nav_menu(array('theme_location' => 'topbar'));
		
		echo '</div>';
	
	} elseif($type == 'textsocial') {
	
		echo '<div class="topbar-section topbar-text">'.$bar_text.'</div>';
		echo '<div class="topbar-section topbar-social">';
		
		vntd_print_social_icons();
		
		echo '</div>';
		
	} else {
		echo '<div class="topbar-section topbar-text">'.$bar_text.'</div>';	
	}
	

}
}

if(!function_exists('vntd_print_big_search')) {
function vntd_print_big_search() {
	?>
	<div class="header-big-search">
		<form class="search-form relative" id="search-form" action="<?php echo home_url(); ?>/">
			<input name="s" id="s" type="text" value="" placeholder="<?php _e('Type and hit Enter..','vntd_qaro') ?>" class="search">
			<div class="header-search-close accent-hover-color"><i class="fa fa-close"></i></div>
		</form>	
	</div>
	<?php
}
}

//function vntd_navbar_love() {
//	echo '<div class="nav-extra-item header-cart-icon header-love-icon"><i class="fa fa-heart"></i></div>';
//}

if(!function_exists('vntd_header_style')) {
	function vntd_header_style() {
		global $post;
		
		$style = 'style-default';
		
		$style = vntd_option('navbar_style');
		
		if(!is_search() && !is_archive() && !is_tag()) {
			if(get_post_meta(vntd_get_id(),'navbar_style',TRUE) && get_post_meta(vntd_get_id(),'navbar_style',TRUE) != $style && get_post_meta(vntd_get_id(),'navbar_style',TRUE) != 'default') {
				$style = get_post_meta(vntd_get_id(),'navbar_style',TRUE);
			}	
		}
		
		return $style;
	}
}