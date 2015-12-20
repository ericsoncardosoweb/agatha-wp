<?php 
/**
 * Initialize the options before anything else. 
 */

add_action( 'init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {

  /* OptionTree is not loaded yet, or this is not an admin request */
  if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
    return false;

  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'contextual_help' => array(
      'content'       => array( 
        array(
          'id'        => 'gerais',
          'title'     => 'Opções Gerais',
          'content'   => '<p>Padrões básicos do Site</p>'
        )
      ),
      'sidebar'       => '<p>Sidebar content goes here!</p>',
    ),
    'sections'        => array(
      array(
        'id'          => 'general',
        'title'       => 'Opções Gerais'
      ),
      array(
        'id'          => 'agatha-page-login',
        'title'       => 'Login'
      ),
      array(
        'id'          => 'agatha-header',
        'title'       => 'Header'
      ),
      array(
        'id'          => 'agatha-top-bar',
        'title'       => 'Top Bar'
      ),
      array(
        'id'          => 'agatha-footer',
        'title'       => 'Footer'
      ),
      array(
        'id'          => 'agatha-blog',
        'title'       => 'Blog'
      ),
      array(
        'id'          => 'agatha-portfolio',
        'title'       => 'Portfólio'
      ),
      array(
        'id'          => 'agatha-sidebar',
        'title'       => 'Sidebar'
      ),
      array(
        'id'          => 'agatha-aparencia',
        'title'       => 'Aparência'
      ),
      array(
        'id'          => 'agatha-arquives',
        'title'       => 'Arquivos'
      ),
      array(
        'id'          => 'agatha-erro404',
        'title'       => 'Página de Erro'
      )
    ),
    'settings'        => array(
      // GERAL
      array(
        'id'          => 'logotipo',
        'label'       => 'Logotipo',
        'desc'        => 'Envie seu logotipo.<br>Atenção, caso você não suba sua imagem no servidor de hospedagem oficial do seu site, após a transferência terá que atualizar o caminho da imagem.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'class'       => ''
      ),
      array(
        'id'          => 'favicon',
        'label'       => 'Favicon',
        'desc'        => 'Defina o favicon do seu site de preferência no tmanho 64 x 64px.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'class'       => ''
      ),
      array(
        'id'          => 'carregamento_da_p_gina',
        'label'       => 'Carregamento da Página',
        'desc'        => 'Selecione um modelo de pré carregamento para as páginas do se site e customize.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'general',
        'class'       => '',
        'choices'     => array(
          array(
            'value'   => 'loader',
            'label'   => 'Sem pré carregamento',
            'src'     => ''
          ),
          array(
            'value'   => 'loader1',
            'label'   => 'Opção 1',
            'src'     => ''
          ),
          array(
            'value'   => 'loader2',
            'label'   => 'Opção 2',
            'src'     => ''
          ),
          array(
            'value'   => 'loader3',
            'label'   => 'Opção 3',
            'src'     => ''
          ),
        )
        // echo ot_get_option( 'carregamento_da_p_gina', '', false, true, 0 )
      ),
      array(
        'id'          => 'bot_o_para_voltar_ao_topo',
        'label'       => 'Voltar ao Topo',
        'desc'        => 'Ative ou desative o botão de vltar ao topo do site.',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'general',
        'class'       => ''
      ),
      array(
        'id'          => 'my_layout',
        'label'       => 'Layout',
        'desc'        => 'Choose a layout for your theme',
        'std'         => 'right-sidebar',
        'type'        => 'radio-image',
        'section'     => 'general',
        'class'       => '',
        'choices'     => array(
          array(
            'value'   => 'left-sidebar',
            'label'   => 'Left Sidebar',
            'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
          ),
          array(
            'value'   => 'right-sidebar',
            'label'   => 'Right Sidebar',
            'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
          ),
          array(
            'value'   => 'full-width',
            'label'   => 'Full Width (no sidebar)',
            'src'     => OT_URL . '/assets/images/layout/full-width.png'
          ),
          array(
            'value'   => 'dual-sidebar',
            'label'   => __( 'Dual Sidebar', 'option-tree' ),
            'src'     => OT_URL . '/assets/images/layout/dual-sidebar.png'
          ),
          array(
            'value'   => 'left-dual-sidebar',
            'label'   => __( 'Left Dual Sidebar', 'option-tree' ),
            'src'     => OT_URL . '/assets/images/layout/left-dual-sidebar.png'
          ),
          array(
            'value'   => 'right-dual-sidebar',
            'label'   => __( 'Right Dual Sidebar', 'option-tree' ),
            'src'     => OT_URL . '/assets/images/layout/right-dual-sidebar.png'
          )
        )
      ),

// LOGIN      
      array(
        'id'          => 'login_theme_area',
        'label'       => 'Cor de Fundo',
        'desc'        => 'Defina a cor de fundo da página de login.',
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_form_area',
        'label'       => 'Cor do Formulário',
        'desc'        => 'Defina a cor de fundo do formulário de login.',
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_b_rad_area',
        'label'       => 'Border Radius',
        'desc'        => 'Defina o valor radiano das bordas do formulário. Ex: 5px 0px',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_button_c_area',
        'label'       => 'Cor da fonte do botão de envio',
        'desc'        => '',
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_button_bg_area',
        'label'       => 'Cor de fundo do botão de envio',
        'desc'        => '',
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_button_bor_area',
        'label'       => 'Deseja manter o border radius no botão de envio?',
        'desc'        => '',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_font_col_area',
        'label'       => 'Cor dos textos do formulário',
        'desc'        => '',
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_link_col_area',
        'label'       => 'Cor dos links abaixo do formulário',
        'desc'        => '',
        'std'         => '',
        'type'        => 'colorpicker-opacity',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_img_area',
        'label'       => 'Imagem de Fundo',
        'desc'        => 'Defina a imagem de fundo da página de login. Ela será aplicada como background no estilo Cover.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_logo',
        'label'       => 'Logotipo',
        'desc'        => 'Escolha o logotipo para a página de login com no máximo 100px de altura.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_altura_logo',
        'label'       => 'Ajuste de altura do logotipo',
        'desc'        => 'Defina a altura mais adequada para o seu logotipo na área de login.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),
      array(
        'id'          => 'login_theme_margin_logo',
        'label'       => 'Margem do logotipo para o formulário',
        'desc'        => 'Defina a distância do logotipo para o formulário.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'agatha-page-login',
        'class'       => ''
      ),

// HEADER
      array(
        'id'          => 'modelo-header',
        'label'       => 'Modelo Header',
        'desc'        => 'Escolha o modelo do header do seu tema',
        'std'         => 'right-sidebar',
        'type'        => 'radio-image',
        'section'     => 'agatha-header',
        'class'       => '',
        'choices'     => array(
          array(
            'value'   => 'below',
            'label'   => 'Below',
            'src'     => OT_URL . '/assets/images/header/below.png'
          ),
          array(
            'value'   => 'below-split',
            'label'   => 'Below Split',
            'src'     => OT_URL . '/assets/images/header/below-split.png'
          ),
          array(
            'value'   => 'classic',
            'label'   => 'Clássico',
            'src'     => OT_URL . '/assets/images/header/classic.png'
          ),
          array(
            'value'   => 'creative',
            'label'   => 'Creative',
            'src'     => OT_URL . '/assets/images/header/creative.png'
          ),
          array(
            'value'   => 'creative-open',
            'label'   => 'Creative Open',
            'src'     => OT_URL . '/assets/images/header/creative-open.png'
          ),
          array(
            'value'   => 'empty',
            'label'   => 'Empty',
            'src'     => OT_URL . '/assets/images/header/empty.png'
          ),
          array(
            'value'   => 'fixed',
            'label'   => 'Fixed',
            'src'     => OT_URL . '/assets/images/header/fixed.png'
          ),
          array(
            'value'   => 'simple',
            'label'   => 'Simples',
            'src'     => OT_URL . '/assets/images/header/simple.png'
          ),
          array(
            'value'   => 'split',
            'label'   => 'Split',
            'src'     => OT_URL . '/assets/images/header/split.png'
          ),
          array(
            'value'   => 'stack-center',
            'label'   => 'Stack Center',
            'src'     => OT_URL . '/assets/images/header/stack-center.png'
          ),
          array(
            'value'   => 'stack-left',
            'label'   => 'Stack Left',
            'src'     => OT_URL . '/assets/images/header/stack-left.png'
          ),
          array(
            'value'   => 'transparent',
            'label'   => 'Transparent',
            'src'     => OT_URL . '/assets/images/header/transparent.png'
          )
        )
      ),
      array(
        'id'          => 'favicon',
        'label'       => 'Favicon',
        'desc'        => 'Defina o favicon do seu site de preferência no tmanho 64 x 64px.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'class'       => ''
      )

    // End Settings
    )
  );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;

}
 ?>