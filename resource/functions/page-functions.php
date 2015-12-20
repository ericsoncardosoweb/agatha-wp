<?php
//
// Blog Post Settings
//


add_action("admin_init", "vntd_page_metaboxes");   

function vntd_page_metaboxes(){    
    add_meta_box("vntd_page_settings", "Page Settings", "vntd_page_settings_config", "page", "side", "low");
    add_meta_box("vntd_page_settings", "Page Settings", "vntd_page_settings_config", "post", "side", "low");
    add_meta_box("vntd_page_settings", "Page Settings", "vntd_page_settings_config", "portfolio", "side", "low");
    
    add_meta_box("vntd_page_settings_advanced", "Advanced Page Settings", "vntd_page_settings_advanced_config", "page", "side", "low", true, true);
    add_meta_box("vntd_page_settings_advanced", "Advanced Page Settings", "vntd_page_settings_advanced_config", "post", "side", "low");
    add_meta_box("vntd_page_settings_advanced", "Advanced Page Settings", "vntd_page_settings_advanced_config", "portfolio", "side", "low");
    
    add_meta_box("vntd_page_custom_pagetitle", "Customize Page Title", "vntd_pagetitle_config", "page", "normal", "low");
    add_meta_box("vntd_page_custom_pagetitle", "Customize Page Title", "vntd_pagetitle_config", "post", "normal", "low");
    add_meta_box("vntd_page_custom_pagetitle", "Customize Page Title", "vntd_pagetitle_config", "portfolio", "normal", "low");
}   

function vntd_page_settings_config() {
        global $post,$smof_data;	
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $footer_widgets = $page_header = $page_subtitle = $navbar_style = $navbar_color = $page_layout = $page_sidebar = $page_width = $footer_color = $footer_widgets = '';
        if(array_key_exists("page_header", $custom)) {
			$page_header = $custom["page_header"][0];
		}
		if(array_key_exists("page_subtitle", $custom)) {
			$page_subtitle = $custom["page_subtitle"][0];
		}
		if(array_key_exists("navbar_style", $custom)) {
			$navbar_style = $custom["navbar_style"][0];
		}
		if(array_key_exists("navbar_color", $custom)) {
			$navbar_color = $custom["navbar_color"][0];
		}
		if(array_key_exists("page_layout", $custom)) {
			$page_layout = $custom["page_layout"][0];	
		}
		if(array_key_exists("page_sidebar", $custom)) {
			$page_sidebar = $custom["page_sidebar"][0];
		}
		if(array_key_exists("page_width", $custom)) {
			$page_width = $custom["page_width"][0];
		}
		if(array_key_exists("footer_color", $custom)) {
			$footer_color = $custom["footer_color"][0];
		}
		if(array_key_exists("footer_widgets", $custom)) {
			$footer_widgets = $custom["footer_widgets"][0];
		}
?>
    <div class="metabox-options form-table side-options">
  		
		<div id="page-header" class="label-radios">  		
			<h5><?php _e('Page Title','veented_backend'); ?>:</h5>
    	    <?php
    	    $headers = array(
    	    	'Enabled' => "default",
    	    	'No Page Title' => 'no-header'
    	    );
    	    
    	    vntd_create_dropdown('page_header',$headers,$page_header);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="navbar-style">  		
    		<h5><?php _e('Header Style','veented_backend'); ?>:</h5>
    	    <?php
    	    $navbar_styles = array(
    	    	'Default set in Theme Options' => "default",    	    	
    	    	"Style 1 - Default Style" => "style-default",
    	    	"Style 2 - Bottom Navigation" => "style-bottom",
    	    	"Style 3 - Mixed Default & Bottom" => "style-mixed",
    	    	"Style 4 - Transparent Menu" => "style-transparent",
    	    	"Style 5 - Bottom Alternative" => "style-bottom2",
    	    	"Style 6 - Boxed" => "style-boxed",
    	    	"Style 7 - Minimalistic 1 - Bottom Menu" => "style-minimal1",
    	    	"Style 8 - Minimalistic 2 - Hamburger Menu" => "style-minimal2",
    	    	"Style 9 - No navigation (just search bar, nav in Top Bar)" => "style-empty",
    	    	"Disable" => "disable" 
    	    );
    	    
    	    vntd_create_dropdown('navbar_style',$navbar_styles,$navbar_style);
    	    
    	    ?>
    	    
    	</div>
    	
    	<?php if(get_post_type(get_the_id()) == 'portfolio') { } else { ?>
    	
    	<div class="metabox-option">
			<h5><?php _e('Page Layout','veented_backend'); ?>:</h5>
			
			<?php 
			if(!$page_layout) $page_layout = $smof_data['vntd_default_layout'];
			$page_layout_arr = array('Right Sidebar' => 'sidebar_right', 'Left Sidebar' => 'sidebar_left', "Fullwidth" => 'fullwidth');  
			
			vntd_create_dropdown('page_layout',$page_layout_arr,$page_layout,true);
			
			?>
		</div>
		<div class="metabox-option fold fold-page_layout fold-sidebar_right fold-sidebar_left" <?php if($page_layout == "fullwidth" || !$page_layout) echo 'style="display:none;"'; ?>>
			<h5><?php _e('Page Sidebar','veented_backend'); ?>:</h5>
			<select name="page_sidebar" class="select"> 
                <option value="Default Sidebar"<?php if($page_sidebar == "Default Sidebar" || !$page_sidebar) echo "selected"; ?>>Default Sidebar</option>
            	<?php
            								
				// Retrieve custom sidebars
											
				$sidebars = $smof_data['sidebar_generator'];  
  
				if(isset($sidebars) && sizeof($sidebars) > 0)  
				{  
					foreach($sidebars as $sidebar)  
					{  
				?>                
				<option value="<?php echo esc_html($sidebar['title']); ?>"<?php if($page_sidebar == $sidebar['title']) echo "selected"; ?>><?php echo $sidebar['title']; ?></option>
                
				<?php
                	}  
				}	
				
				if(class_exists('Woocommerce')) {
				
					if($page_sidebar == "WooCommerce Shop Page") $selected_shop = "selected";
					if($page_sidebar == "WooCommerce Product Page") $selected_product = "selected";
					
					echo '<option value="WooCommerce Shop Page" '.$selected_shop.'>WooCommerce Shop Page</option>';
					echo '<option value="WooCommerce Product Page" '.$selected_product.'>WooCommerce Product Page</option>';
				}			
				?>            	

            </select>
		</div>
		
		<?php } ?>
        
    </div>
<?php

}	

function vntd_page_settings_advanced_config() {
        global $post,$smof_data;	
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $footer_widgets = $footer_style = $footer_color = $page_nav_menu = '';
        if(array_key_exists("page_nav_menu", $custom)) {
        	$page_nav_menu = $custom["page_nav_menu"][0];
        }
		if(array_key_exists("footer_style", $custom)) {
			$footer_style = $custom["footer_style"][0];
		}
		if(array_key_exists("footer_color", $custom)) {
			$footer_color = $custom["footer_color"][0];
		}
		if(array_key_exists("footer_widgets", $custom)) {
			$footer_widgets = $custom["footer_widgets"][0];
		}
?>
    <div class="metabox-options form-table side-options">
    	
    	<div class="metabox-option fold fold-page_layout fold-sidebar_right fold-sidebar_left">
			<h5><?php _e('Page Nav Menu','veented_backend'); ?>:</h5>
			
			<select name="page_nav_menu" class="select"> 
			    <option value="default" <?php if($page_nav_menu == "default" || !$page_nav_menu) echo "selected"; ?>>Default Nav Menu</option>
			<?php
			
			$nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );	
			$selected = '';
			foreach($nav_menus as $nav_menu)  
			{  	
				$selected = '';
				if($page_nav_menu == $nav_menu->slug) $selected = ' selected';
				echo '<option value="'.$nav_menu->slug.'"'.esc_attr($selected).'>'.$nav_menu->name.'</option>';
			}
			
			?>
			</select>
		</div>
		
		<div id="footer_style">  		
			<h5><?php _e('Footer Style','veented_backend'); ?>:</h5>
		    <?php
		    $footer_styles = array(
		    	'Default set in Theme Options' => "default",
		    	'Classic' => 'classic',
		    	'Centered' => 'centered'
		    );
		    
		    vntd_create_dropdown('footer_style',$footer_styles,$footer_style);
		    
		    ?>
		    
		</div>
		
		<div id="footer-color">  		
			<h5><?php _e('Footer Skin','veented_backend'); ?>:</h5>
		    <?php
		    $footer_colors = array(
		    	'Default set in Theme Options' => "default",
		    	'Light' => 'light',
		    	'Dark' => 'dark'
		    );
		    
		    vntd_create_dropdown('footer_color',$footer_colors,$footer_color);
		    
		    ?>
		    
		</div>
		
		<div id="footer-color">  		
			<h5><?php _e('Footer Widgets Area','veented_backend'); ?>:</h5>
		    <?php
		    $footer_widgets_arr = array(
		    	'Default set in Theme Options' => "default",
		    	'Enabled' => 'enabled',
		    	'Disabled' => 'disabled'
		    );
		    
		    vntd_create_dropdown('footer_widgets',$footer_widgets_arr,$footer_widgets);
		    
		    ?>
		    
		</div>
        
    </div>
<?php

}
 

function vntd_pagetitle_config() {
        global $post,$smof_data;	
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
        $custom = get_post_custom($post->ID);
        $customize_enable = $customize_textcolor = $customize_bgcolor = $customize_bg_image = $customize_textalign = $customize_bgimage = $customize_breadcrumbs = $customize_fontsize = $customize_fontweight = $customize_texttransform = $customize_height = $customize_animated = '';
        if(array_key_exists("customize_enable", $custom)) {
			$customize_enable = $custom["customize_enable"][0];
		}
		if(array_key_exists("customize_textcolor", $custom)) {
			$customize_textcolor = $custom["customize_textcolor"][0];
		}
		if(array_key_exists("customize_bgcolor", $custom)) {
			$customize_bgcolor = $custom["customize_bgcolor"][0];
		}
		if(array_key_exists("customize_bgimage", $custom)) {
			$customize_bgimage = $custom["customize_bgimage"][0];
		}
		if(array_key_exists("customize_textalign", $custom)) {
			$customize_textalign = $custom["customize_textalign"][0];	
		}
		if(array_key_exists("customize_fontweight", $custom)) {
			$customize_fontweight = $custom["customize_fontweight"][0];
		}
		if(array_key_exists("customize_fontsize", $custom)) {
			$customize_fontsize = $custom["customize_fontsize"][0];
		}
		if(array_key_exists("customize_texttransform", $custom)) {
			$customize_texttransform = $custom["customize_texttransform"][0];
		}
		if(array_key_exists("customize_breadcrumbs", $custom)) {
			$customize_breadcrumbs = $custom["customize_breadcrumbs"][0];
		}
		if(array_key_exists("customize_height", $custom)) {
			$customize_height = $custom["customize_height"][0];
		}
		if(array_key_exists("customize_animated", $custom)) {
			$customize_animated = $custom["customize_animated"][0];
		}
		
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker', '', '', '', true);

?>
    <div class="metabox-options form-table side-options pagetitle-customize">
  		
  		<div id="customize_textcolor">  		
  		    <?php
  		    
  		    $arr_enable = array(
  		    	"Don't use a custom page title" => 'no',
  		    	'Use a custom page title' => "yes",
  		    	
  		    );
  		    
  		    vntd_create_dropdown('customize_enable',$arr_enable,$customize_enable);
  		    
  		    ?>
  		    
  		</div>	
    	
    	<?php 
    	$extra_class = 'hidden';
    	if($customize_enable == 'yes') $extra_class = ' not-hidden';
    	
    	?>
    	<div id="customize_textalign" class="hidden <?php echo esc_attr($extra_class); ?>">  		
    		<h5><?php _e('Text Align','veented_backend'); ?>:</h5>
    		
    	    <?php
    	    
    		$arr_textalign = array(
    			'Left' => "left",
    			'Center' => "center"
    		);
    		
    		vntd_create_dropdown('customize_textalign',$arr_textalign,$customize_textalign);
    	    
    	    ?>
    	    
    	</div> 	
    	
    	<div id="customize_breadcrumbs" class="hidden <?php echo esc_attr($extra_class); ?>">  		
    		<h5><?php _e('Breadcrumbs','veented_backend'); ?>:</h5>
    		
    	    <?php
    	    
			$arr_breadcrumbs = array(
				'Enabled' => "enabled",
				'Disabled' => 'disabled'
			);
			
			vntd_create_dropdown('customize_breadcrumbs',$arr_breadcrumbs,$customize_breadcrumbs);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="customize_fontweight" class="hidden <?php echo esc_attr($extra_class); ?>">  		
    		<h5><?php _e('Title Font Weight','veented_backend'); ?>:</h5>
    		
    	    <?php
    	    
    		$arr_fontweight = array(
    			'Normal' => "normal",
    			'Bold' => 700,
    			'Extra Bold' => 800
    		);
    		
    		vntd_create_dropdown('customize_fontweight',$arr_fontweight,$customize_fontweight);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="customize_fontsize" class="hidden <?php echo esc_attr($extra_class); ?>">  		
    		<h5><?php _e('Title Font Size','veented_backend'); ?>:</h5>
    		
    	    <?php
    	    
    		$arr_fontsize = array(
    			'30' => 30,
    			'32' => 32,
    			'36' => 36,
    			'40' => 40,
    			'44' => 44,
    			'48' => 48,
    			'52' => 52,
    			'56' => 56,
    			'60' => 60,
    			'64' => 64,
    			'68' => 68,
    			'72' => 72,
    			'76' => 76
    		);
    		
    		vntd_create_dropdown('customize_fontsize',$arr_fontsize,$customize_fontsize);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="customize_texttransform" class="hidden <?php echo $extra_class; ?>">  		
    		<h5><?php _e('Text Transform','veented_backend'); ?>:</h5>
    		
    	    <?php
    	    
    		$arr_texttransform = array(
    			'Normal' => "normal",
    			'Uppercase' => "uppercase"
    		);
    		
    		vntd_create_dropdown('customize_texttransform',$arr_texttransform,$customize_texttransform);
    	    
    	    ?>
    	    
    	</div>
    	
    	<div id="customize_height" class="hidden <?php echo $extra_class; ?>">  		
    		<h5><?php _e('Page Title Height','veented_backend'); ?>:</h5>
    		
    	    <input type="text/css" value="<?php if(!$customize_height) { echo '80'; } else { echo $customize_height; } ?>" name="customize_height">
    	    
    	</div>
    	
		<div id="customize_textcolor" class="hidden <?php echo $extra_class; ?>">  		
			<h5><?php _e('Text Color','veented_backend'); ?>:</h5>

		    <input name="customize_textcolor" type="text" value="<?php echo $customize_textcolor; ?>" class="wp-color-picker">
		</div>
    	
		<div id="customize_bgcolor" class="hidden <?php echo $extra_class; ?>">  		
			<h5><?php _e('Background Color','veented_backend'); ?>:</h5>

		    <input name="customize_bgcolor" type="text" value="<?php echo $customize_bgcolor; ?>" class="wp-color-picker">
		</div>
		
		<div id="customize_bgimage" class="hidden image-upload image-upload-dep <?php echo $extra_class; ?>">  		
			<h5><?php _e('Background Image','veented_backend'); ?>:</h5>

		    <input name="customize_bgimage" type="hidden" value="<?php echo $customize_bgimage; ?>" class="image-upload-data">
		    <div class="image-upload-preview show-on-upload" <?php if($customize_bgimage) echo 'style="display:block;"'; ?>>
		    	<?php
		    		$imgurl = '';
		    		if($customize_bgimage) {
			    		$imgurl = wp_get_attachment_image_src( $customize_bgimage, 'thumbnail');			
			    		$imgurl = $imgurl[0];
			    	}
		    	?>
		    	<img src="<?php echo $imgurl;?>">
		    </div>
		    <div class="button add-single-image"><?php if($customize_bgimage) { _e('Change image','vntd_qaro'); } else { _e('Upload image','vntd_qaro'); } ?></div>
		    <div class="button remove-single-image show-on-upload" <?php if($customize_bgimage) echo 'style="display:inline-block;"'; ?>>Remove image</div>
		</div>
		
		<div id="customize_breadcrumbs" class="hidden <?php echo $extra_class; ?>">  		
			<h5><?php _e('Animated','veented_backend'); ?>:</h5>
			
		    <?php
		    
			$arr_animated = array(
				'No' => "no",
				'Yes' => 'yes'
			);
			
			vntd_create_dropdown('customize_animated',$arr_animated,$customize_animated);
		    
		    ?>
		    
		</div>

        
    </div>
<?php

}	


	
// Save Custom Fields
	
add_action('save_post', 'vntd_save_page_settings'); 

function vntd_save_page_settings(){
    global $post;  

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return $post_id;
	}else{		
	
		$post_metas = array('page_layout','page_sidebar','page_width','navbar_style','navbar_color','footer_color','footer_style','page_header','page_title','page_subtitle','footer_widgets', 'customize_fontsize', 'customize_texttransform', 'customize_textalign', 'customize_fontweight', 'customize_textcolor', 'customize_bgcolor', 'customize_bgimage', 'customize_breadcrumbs', 'customize_enable', 'customize_height', 'customize_animated', 'page_nav_menu');
		
		foreach($post_metas as $post_meta) {
			if(isset($_POST[$post_meta])) update_post_meta($post->ID, $post_meta, $_POST[$post_meta]);
		}

    }

}