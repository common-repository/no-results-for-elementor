<?php
	  if (!defined('ABSPATH')) {
      exit;
    } // Exit if accessed directly.
   //Frontend Output Function
    $plugin = new elemnoresultsSettings(); // Create an instance of your plugin class
    //Options
    $GLOBALS['enresc_html_enabled'] = $plugin->get_plugin_option('enresc_html_enabled');
    $GLOBALS['enr_title'] = $plugin->get_plugin_option('enr_title');
    $GLOBALS['enr_description'] = $plugin->get_plugin_option('enr_description');
    $GLOBALS['enr_searchbox'] = $plugin->get_plugin_option('enr_searchbox');

    if ($GLOBALS['enresc_html_enabled'] == 'on') {
      function smdevesc_html_enr_custom_css() {
 ?>
  <style>
  .elementor-posts-nothing-found {display: none!important;}	 
  #smdev-elemnoresults .smdev-enr-title{color:var(--e-global-color-primary);}
  #smdev-elemnoresults .smdev-enr-desc{color:var(--e-global-color-primary);}
  #smdev-elemnoresults #smdev-search-wrap{margin-bottom:40px;}
  #smdev-elemnoresults #smdev-search-wrap input,
  #smdev-elemnoresults #smdev-search-wrap input[type=search]{font-family: var( --e-global-typography-text-font-family ), Sans-serif;font-weight: var( --e-global-typography-text-font-weight );padding-left: calc(50px / 3);padding-right: calc(50px / 3);border-radius:0;}
  #smdev-elemnoresults #smdev-search-wrap button{min-width: 50px;background-color: var( --e-global-color-primary );padding: 10px 10px;display: flex;justify-content: center;align-items: center;border:0;border-radius:0;}
  #smdev-elemnoresults #smdev-search-wrap button:hover {min-width: 50px;background-color: var( --e-global-color-accent);}
  #smdev-elemnoresults .search-form .smdev-search-container {background-color: #ffffff;border-color: #474747;border-width: 1px 1px 1px 1px;border-radius: 0px;}
</style>
<?php }
  add_action( 'wp_head', 'smdevesc_html_enr_custom_css', 50 );

  function smdevesc_html_enr_output($query){
    $nre_postTotal = $query->found_posts;
    if (is_search() && !is_post_type_archive('product') && $nre_postTotal == 0) {
           echo '<div id="smdev-elemnoresults">';
            if(!empty($GLOBALS['enr_title'])) {
               printf( 
                 /* translators: %s: Title */
                '<h3 class="smdev-enr-title">%s</h3>',
                esc_html($GLOBALS['enr_title'])
               );
            } 
            if(!empty($GLOBALS['enr_description'])) {
              printf(
                 /* translators: %s: Description */
              '<p class="smdev-enr-desc">%s</p>',
              esc_html($GLOBALS['enr_description'])
              );
            } 
              if ($GLOBALS['enr_searchbox'] == 'on') {
printf(
            /* translators: %s: Home Url */
               '<div id="smdev-search-wrap" class="search-form">
                <form class="elementor-search-form" role="search" action="%s" method="get">
                  <div class="elementor-search-form__container smdev-search-container" style="display:flex;">
                      <input placeholder="Search..." class="elementor-search-form__input" type="search" name="s" title="Search" value="">
                        <button class="elementor-search-form__submit" type="submit" title="Search" aria-label="Search">
                        <svg viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m27.414 24.586-5.077-5.077A9.932 9.932 0 0 0 24 14c0-5.514-4.486-10-10-10S4 8.486 4 14s4.486 10 10 10a9.932 9.932 0 0 0 5.509-1.663l5.077 5.077a2 2 0 1 0 2.828-2.828zM7 14c0-3.86 3.14-7 7-7s7 3.14 7 7-3.14 7-7 7-7-3.14-7-7z" fill="#ffffff" class="fill-000000"></path></svg>						
                        <span class="elementor-screen-only">Search</span>
                      </button>
                  </div>
                </form>
              </div>',
             esc_html(esc_url( home_url( '/' ) ))
                );       
              }
              echo '</div>';
          }
        }
        add_action( 'elementor/query/query_results', 'smdevesc_html_enr_output');
    }
?>
