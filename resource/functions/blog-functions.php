<?php
//
// Blog Post Settings
//


add_action("admin_init", "vntd_blog_post_settings");   

// Add Blog Metaboxes
function vntd_blog_post_settings(){   
    add_meta_box("blog_gallery_post_format", __("Gallery Settings",'veented_backend'), "vntd_blog_gallery_settings_config", "post", "normal", "high");
    add_meta_box("blog_video_post_format", __("Video Settings",'veented_backend'), "vntd_blog_video_settings_config", "post", "normal", "high");
    add_meta_box("blog_quote_post_format", __("Quote Settings",'veented_backend'), "vntd_blog_quote_settings_config", "post", "normal", "high");
    add_meta_box("blog_link_post_format", __("Link Settings",'veented_backend'), "vntd_blog_link_settings_config", "post", "normal", "high");
}

function vntd_blog_post_settings_config(){
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
		$thumb_setting = $thumb_height = $thumb_lightbox = '';
		if(isset($custom["thumb_setting"][0])) $thumb_setting = $custom["thumb_setting"][0];	
		if(isset($custom["thumb_height"][0])) $thumb_height = $custom["thumb_height"][0];
		if(isset($custom["thumb_lightbox"][0])) $thumb_lightbox = $custom["thumb_lightbox"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<div class="metabox-option">
    	    		
    	    <h6><?php _e('Thumbnail Display', 'veented_backend') ?>:</h6>
    	    <div class="metabox-option-side">    	    
    	    <?php 
    	    
    	    $thumb_setting_arr = array("Display thumbnail on single post page" => "on", "Do NOT display the thumbnail on post page" => "off");
    	    
    	    vntd_create_dropdown('thumb_setting',$thumb_setting_arr,$thumb_setting);
    	    
    	    ?>   	    
    	    </div>
    	</div>
    	<div class="metabox-option">    		
    	    <h6><?php _e('Thumbnail Lightbox', 'veented_backend') ?>: <span class="form-caption">(<?php _e('standard post format', 'veented_backend') ?>)</span></h6>
    	    <div class="metabox-option-side">   	    
    	    <?php 
    	    
    	    $thumb_lightbox_arr = array("Disable lightbox" => "off","Enable lightbox zoom of thumbnail image" => "on");
    	    
    	    vntd_create_dropdown('thumb_lightbox',$thumb_lightbox_arr,$thumb_lightbox);
    	    
    	    ?>    

    	    </div>
    	</div>
    	<div class="metabox-option">  
            <h6><?php _e('Thumbnail Height', 'veented_backend') ?>:</h6>
            <div class="metabox-option-side">            
        	<?php 
        	
        	$thumb_heights = array("Landscape" => "landscape", "Original Aspect Ratio" => "auto");
        	
        	vntd_create_dropdown('thumb_height',$thumb_heights,$thumb_height);
        	
        	?>        
            </div> 
       </div> 
        
    </div> 
<?php
}	

// Gallery Metabox

function vntd_blog_gallery_settings_config(){	
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $gallery_type = $gallery_images = '';
		if(isset($custom["gallery_type"][0])) $gallery_type = $custom["gallery_type"][0];
		if(isset($custom["gallery_images"][0])) $gallery_images = $custom["gallery_images"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<!--<div class="metabox-option">
    		<h6><?php _e('Gallery Type', 'veented_backend') ?>:</h6>
    	    <div class="metabox-option-side">
    	    <?php 
    	    
    	    $gallery_types = array("Lightbox" => "lightbox", "Slider" => "slider");
    	    
    	    vntd_create_dropdown('gallery_type',$gallery_types,$gallery_type);
    	    
    	    ?>
    	    </div>
    	</div>-->
    	<div class="metabox-option">
    		<h6><?php _e('Gallery Images', 'veented_backend') ?>:</h6> 
    		
    		<div class="metabox-option-side">
    		<?php vntd_gallery_metabox($gallery_images); ?>	 
    		</div>  
    	</div>   
    </div>
<?php
}


// Video Metabox


function vntd_blog_video_settings_config(){	
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $video_site_url = '';
		if(isset($custom["video_site_url"][0])) $video_site_url = $custom["video_site_url"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<div class="metabox-option">
    		<h6><?php _e('Video URL', 'veented_backend') ?>:<span class="form-caption">(<a target="_blank" href="https://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F"> <?php _e('List of supported sites', 'veented_backend') ?></a>)</span></h6>
    		
    		<div class="metabox-option-side">
    	    <td class="description-textarea">
    	    	<input type="text" name="video_site_url" value="<?php echo esc_url($video_site_url); ?>">
    	    </td>
    	    </div>
    	</div>      
    </div>
<?php
}

// Quote Metabox


function vntd_blog_quote_settings_config(){	
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $quote_content = $quote_author = '';
		if(isset($custom["quote_content"][0])) $quote_content = $custom["quote_content"][0];
		if(isset($custom["quote_author"][0])) $quote_author = $custom["quote_author"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<div class="metabox-option">
    		<h6><?php _e('Quote Content', 'veented_backend') ?>:</h6>
    		
    		<div class="metabox-option-side">
    			<textarea class="textarea-full" name="quote_content"><?php echo esc_attr($quote_content); ?></textarea>
    		</div>
    	</div>
    	<div class="metabox-option">
    		<h6><?php _e('Quote Author', 'veented_backend') ?>:</h6>
    		
    	    <div class="metabox-option-side">
    	    	<input type="text" name="quote_author" value="<?php echo esc_attr($quote_author); ?>">
    	    </div>
    	</div>
    </div>
<?php
}

// Link Metabox


function vntd_blog_link_settings_config(){	
        global $post;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $post_link = '';
		if(isset($custom["post_link"][0])) $post_link = $custom["post_link"][0];
?>
    <div class="form-table custom-table fullwidth-metabox">
    	<div class="metabox-option">
    		<h6><?php _e('Link URL', 'veented_backend') ?>:</h6>
    	    <div class="metabox-option-side">
    	    	<input type="text" name="post_link" value="<?php echo esc_attr($post_link); ?>">
    	    </div>
    	</div>
    </div>
<?php
}

	
// Save Custom Fields
	
add_action('save_post', 'vntd_save_post_settings'); 

function vntd_save_post_settings(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{
		if(isset($_POST["page_title"])) update_post_meta($post->ID, "page_title", $_POST["page_title"]);	
		if(isset($_POST["tagline"])) update_post_meta($post->ID, "tagline", $_POST["tagline"]);	
		if(isset($_POST["page_layout"])) update_post_meta($post->ID, "page_layout", $_POST["page_layout"]);
		if(isset($_POST["page_sidebar"])) update_post_meta($post->ID, "page_sidebar", $_POST["page_sidebar"]);
		if(isset($_POST["thumb_setting"])) update_post_meta($post->ID, "thumb_setting", $_POST["thumb_setting"]);
		if(isset($_POST["thumb_height"])) update_post_meta($post->ID, "thumb_height", $_POST["thumb_height"]);
		if(isset($_POST["thumb_lightbox"])) update_post_meta($post->ID, "thumb_lightbox", $_POST["thumb_lightbox"]);
		if(isset($_POST["gallery_type"])) update_post_meta($post->ID, "gallery_type", $_POST["gallery_type"]);	
		if(isset($_POST["gallery_images"])) update_post_meta($post->ID, "gallery_images", $_POST["gallery_images"]);
		if(isset($_POST["video_site_url"])) update_post_meta($post->ID, "video_site_url", $_POST["video_site_url"]);
		if(isset($_POST["video_file_url"])) update_post_meta($post->ID, "video_file_url", $_POST["video_file_url"]);
		if(isset($_POST["quote_content"])) update_post_meta($post->ID, "quote_content", $_POST["quote_content"]);
		if(isset($_POST["quote_author"])) update_post_meta($post->ID, "quote_author", $_POST["quote_author"]);
		if(isset($_POST["post_link"])) update_post_meta($post->ID, "post_link", $_POST["post_link"]);	
    }

}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
//		Comments Layout
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   global $post;
   ?>
   
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	
		<!-- Comment -->
		<div class="comment">
			<!-- Image -->
			<div class="comment-author-avatar">
				<?php echo get_avatar($comment,$size='100'); ?>
			</div>
			<!-- Description -->
			<div class="comment-text">
				<!-- Reply Button -->
				
				<div class="comment-mini-heading">
							
					<!-- Name -->
					<h6 class="comment-name">
						<?php echo get_comment_author(); ?>
					</h6>
					<!-- Date -->
					<div class="comment-date">
						<?php echo get_comment_date('F d, Y'); ?>
					</div>
				</div>
				<!-- Description -->
				<?php comment_text(); ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'],'reply_text' => __('Reply','vntd_qaro')))); ?>
			</div>
			<!-- End Description -->
		</div>
		<!-- End Comment -->
		
	</li>
	
<?php
}

// Blog Comments Script

function vntd_comments_script() {
	if(is_singular())
	wp_enqueue_script('comment-reply');
}
add_action('wp_enqueue_scripts', 'vntd_comments_script');


function vntd_blog_post_tags(){
	if(has_tag()){
	?>
	<div class="post-tags"><i class="fa fa-tags"></i> <?php the_tags('', ', ', '<br />'); ?></div>
	<?php
	}
}

function vntd_blog_post_author($blog_style = NULL){
	global $post;
	
	if(get_the_author_meta('description')) {
	?>
	<div class="post-author">
	
		<div class="post-author-avatar">
			<div class="post-author-circle"><?php echo get_avatar( get_the_author_meta('ID'), 100 ); ?></div>
		</div>		
		
		<div class="post-author-info">
			<h4 class="post-section-heading"><?php the_author(); ?></h4>
			<p><?php echo get_the_author_meta('description'); ?></p>
		</div>	
	
	</div>
	<?php	
	}
}

function vntd_blog_post_nav(){
	?>	
	<div class="divider line"></div>
	<div id="blog-post-nav" class="blog-navigation">
		<div class="newer-posts boxed-link"><?php previous_post_link('%link'); ?></div>
		<div class="older-posts boxed-link"><?php next_post_link('%link'); ?></div>
	</div>
	<?php
}

function vntd_post_meta() {
	global $post;
	
	?>
	<div class="vntd-meta-section classic-meta-section">
		<span class="vntd-meta-author">
			<?php echo __('By','vntd_qaro'); ?>: 
			<a href="<?php echo get_the_author_meta( 'user_url'); ?>">
				<?php the_author(); ?>
			</a>
		</span>
		<span class="vntd-meta-date">
			<?php echo __('On','vntd_qaro'); ?>: 
			<span class="meta-value"><?php the_time('F d, Y'); ?></span>
		</span>
		<span class="vntd-meta-categories">
			<?php echo __('In','vntd_qaro'); ?>:
			<?php the_category(', '); ?>
		</span>	
		<span class="vntd-meta-comments">
			<?php echo __('Comments','vntd_qaro'); ?>:
			<a href="<?php echo get_permalink($post->ID).'#comments'?>" title="<?php _e('View comments','veented');?>"><?php comments_number('0', '1', '%'); ?></a>
		</span>
		
	</div> 
	<?php

}

function vntd_post_meta_extra() {
	?>
	
	<div class="blog-extra-meta">
	
	<?php
	
	if(vntd_option('blog_style') == 'timeline') { ?>
	
		<div class="timeline-author">
			<i class="fa fa-chevron-right"></i>
			<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
				<?php echo get_avatar( get_the_author_meta('ID'), 100 ); ?>		
			</a>
		</div>
		<div class="timeline-date">
			<?php the_time('M d, Y'); ?>
		</div>
	
	<?php
	} else { ?>
	
		<div class="extra-meta-item extra-meta-date">
			<div class="extra-meta-day"><?php the_time('d'); ?></div>
			<div class="extra-meta-month"><?php the_time('M'); ?></div>
		</div>
		<a href="<?php echo get_permalink(get_the_ID()).'#comments'?>" class="extra-meta-item extra-meta-comments" title="<?php _e('View comments','veented');?>">
			<div class="extra-meta-icon"><i class="fa fa-comments"></i></div>
			<div class="extra-meta-comments-count"><?php comments_number('0', '1', '%'); ?></div>
		</a>
		
	<?php } ?>
	</div>
	
	<?php
}

function vntd_post_tags(){

	$posttags = get_the_tags();
	
	if($posttags == NULL) return false;
	
	if ($posttags) {
		echo '<span class="post-meta-tags">';
		$i = 0;
		$len = count($posttags);
		foreach($posttags as $tag) {	
		  echo '<a href="'. get_tag_link($tag->term_id) .'">'; 
		  echo $tag->name;	 
		  echo "</a>";
		   $i++;
		  if($i != $len) echo ', ';		 
		}
		echo '</span>';
	}	
}

function vntd_blog_post_content($page_layout = NULL, $blog_style = NULL, $grid_style = NULL, $masonry = NULL) {

	global $post;
	
	$post_format = get_post_format($post->ID);
	
	if(!$post_format) {
		$post_format = 'standard';
	}
	
	$extra_classes = array();
	
	$excerpt_size = 50;
	
	if(is_null($grid_style)) {
		$grid_style = vntd_option('blog_grid_style');
	}
	
	if(is_null($blog_style)) {
		$blog_style = 'classic';
	}
	
	
	if($blog_style == "grid" || $blog_style == "timeline") {
		//echo "yes";
		$extra_classes = array('item', 'vntd-grid-item');
		$excerpt_size = 20;
		if(vntd_option('blog_grid_style') == 'thumb_bg') {
			if(!has_post_thumbnail()) return null;
			$excerpt_size = 18;
		}
	}elseif($blog_style == "minimal") {
		$excerpt_size = 30;
	}
	
	$post_media_class = 'post-no-media';
	
	if(has_post_thumbnail()) {
		$post_media_class = 'post-has-media';
	}
	array_push($extra_classes, $post_media_class);
	
	if(!$masonry) {
		$masonry = vntd_option('blog_masonry');
		if($masonry == true) $masonry = 'yes';
	}
	
	?>
	
	<div <?php post_class($extra_classes); ?>>
	
		<div class="blog-post-wrap">
	
		<?php 
		
		if($blog_style != "classic") {
			vntd_post_meta_extra();
		}
		
		if(has_post_thumbnail()) {
			vntd_post_media($blog_style, $page_layout, $grid_style, $masonry); 
		}
		
		?>	
		
		<div class="blog-post-inner">
			<div class="post-inner">
			<?php if($blog_style == "grid" && vntd_option('blog_grid_style') == "thumb_bg") {
				vntd_post_meta_extra();
			} ?>
			<!-- Post Header -->
			<div class="blog-head">
				<h2 class="blog-post-title">
					<a href="<?php echo get_permalink($post->ID); ?>">
					<?php echo get_the_title($post->ID); ?>
					</a>
				</h2>
			</div>
			<!-- Post Header -->
			
			<?php vntd_post_meta(); ?>
	
			<!-- Post Details -->
			<div class="details">
				<?php 
				
				if(!is_single()) { 				
					echo vntd_excerpt($excerpt_size, true); 			
				} 
				 
				?>		
			</div>
			<!-- End Post Details -->
			
			</div>
		</div>
		<?php 
		
		if(is_single()) { 
		
			the_content();
		
		}
		
		?>
		
		</div>
		
	</div>
		
	<?php

}

function vntd_post_media($blog_style = null, $page_layout = null, $grid_style = null, $masonry = null) {
	
	global $post;
	
	$post_format = get_post_format($post->ID);
	
	$img_size = 'sidebar-landscape';

	if($blog_style == 'timeline') {
		$img_size = 'sidebar-auto';
	}
	
	if($grid_style == "thumb_bg" && $blog_style == "grid" || $blog_style == 'aligned' && $page_layout != 'fullwidth') {
		$img_size = 'sidebar-square';
	} elseif($blog_style == 'aligned' && $page_layout == 'fullwidth') {
		$img_size = 'sidebar-landscape';	
	} elseif($page_layout == 'fullwidth' || $blog_style == 'classic' && $page_layout == 'fullwidth' || $blog_style == 'minimal') {
		$img_size = 'fullwidth-landscape';
	} elseif($blog_style == 'grid') {
		if($masonry == 'yes') {
			$img_size = 'sidebar-auto';
		} else {
			$img_size = 'sidebar-square';
		}
	}
	
	echo '<div class="post-media-container">';
	
	if(!$post_format || $post_format == 'standard' || $post_format == 'quote' || $post_format == 'link' || $post_format == 'gallery' && !get_post_meta($post->ID,'gallery_images',TRUE) || $blog_style == "grid" && $grid_style == "thumb_bg") {
	wp_enqueue_script('magnific-popup', '', '', '', true);
	wp_enqueue_style('magnific-popup');
	
	
	
	
	$imgurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $img_size);
	
	$post_link = $imgurl[0];
	$extra_class = " mp-gallery";
	
	if($post_format == "link") {
		$post_link = get_post_meta($post->ID, 'post_link', true);
		$extra_class = '';
	} elseif($post_format == "quote") {
		$post_link = get_permalink($post->ID);
		$extra_class = '';
	}
	
	?>
	<div class="single_item <?php echo esc_attr($extra_class); ?>">
		<a href="<?php echo esc_url($post_link); ?>" title="<?php echo esc_attr(get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)); ?>">
			<img src="<?php echo $imgurl[0]; ?>" alt="<?php echo esc_attr(get_post_meta( get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)); ?>">
			<?php
			
			if($post_format == 'quote' || $post_format == 'link') {
			?>
			<div class="blog-post-overlay">
				<div class="post-overlay-inner">
					<div class="post-overlay-title">
						
						<?php 
						if($post_format == 'quote') {
							echo '<span class="quotation quotation-begin">"</span>'.get_post_meta($post->ID, 'quote_content', true);
						} else {
							echo get_the_title($post->ID);
						}
						?>
						<span class="quotation quotation-end">"</span>
					</div>
					<div class="post-overlay-subtitle">
						<?php 
						if($post_format == 'quote') {
							echo get_post_meta($post->ID, 'quote_author', true);
						} else {
							echo get_post_meta($post->ID, 'post_link', true);
						}
						?>
					</div>
				</div>
			</div>
			<?php
			}
			
			?>
		</a>
	</div>
	<?php
	} elseif($post_format == 'gallery') {
	
	wp_enqueue_script('magnific-popup', '', '', '', true);
	wp_enqueue_style('magnific-popup');
	
	wp_enqueue_script('swiper', '', '', '', true);
	wp_enqueue_style('swiperCSS');	
	
	//$img_size = 'sidebar-landscape';
	
//	if(vntd_option('blog_masonry') == true || vntd_option('blog_style') == 'timeline') {
//		$img_size = 'portfolio-square';
//	}
	
	if($masonry == 'yes' && $page_layout == 'fullwidth' && $blog_style != 'grid') {
		$img_size = 'fullwidth-landscape';
	} elseif($masonry == 'yes' && $blog_style == 'grid') {
		$img_size = 'sidebar-square';
	}
	
	?>

	<div class="vntd-image-slider">

		<ul class="swiper-wrapper mp-gallery">
		
			<?php
			
			$gallery_images = get_post_meta($post->ID,'gallery_images',TRUE);
			
			if($gallery_images) {
			
				$ids = explode(",", $gallery_images);
				
				foreach($ids as $id) {
					$imgurl = wp_get_attachment_image_src($id, $img_size);
					echo '<li class="swiper-slide"><a href="'.esc_url($imgurl[0]).'" title="'.esc_attr(get_post_meta($id, '_wp_attachment_image_alt', true)).'"><img src="'.esc_url($imgurl[0]).'" alt="'.esc_attr(get_post_meta($id, '_wp_attachment_image_alt', true)).'"></a></li>';
				}
			
			}	
			
			?>
		</ul>
		
		<div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
		<div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>	
	</div>
	
	<?php
	
	} elseif($post_format == 'video') {
	
		if(!get_post_meta($post->ID, 'video_site_url', true)) echo 'No video URL inserted!';
		 
		echo '<div class="video-containers single_item">'.wp_oembed_get(get_post_meta($post->ID, 'video_site_url', true)).'</div>';
	}
	
	echo '</div>';

}

// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
// 		Post Views Count
// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

function vntd_getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}
function vntd_setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}