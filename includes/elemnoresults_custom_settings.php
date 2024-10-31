<?php
if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.

define( 'ELEMNORESULTS_PLUGIN_SLUG', 'elemnoresults-settings-admin' );
class elemnoresultsSettings{

  private $options;

  public function __construct(){
    add_action('admin_menu', array($this,'add_plugin_page'));
    add_action('admin_init', array($this,'page_init'));
  }

  public function add_plugin_page(){
    add_options_page(
      'Settings Admin',
      'No Results For Elementor',  
      'manage_options', 
      'elemnoresults-settings-admin',
      array($this,'smdevenr_create_admin_page'),
      55
    );  
  }
  public function smdevenr_create_admin_page(){
    $this->options = get_option('elemnoresults-option');
     echo '<style>
        /*Some styling for the form***/
		    h2{font-size:1.5rem;}
        input[type=checkbox] {width: 30px;height: 30px;}
        input[type=checkbox]:checked::before {width: 34px;}
		    input[type=text]{width:100%;max-width:757px;}
		    #enr-form table.form-table tr:nth-child(odd) { background: #e3e3e3;}
		    #enr-form .form-table th{padding:20px;}
		    a.enr-test-button {background: #2271b1;border-color: #2271b1;color: #fff;padding: 6px 20px;display: inline-block;border-radius: 4px;text-decoration:none;padding: 7px 23px;font-size: 14px;text-transform: uppercase;margin-bottom: 7px;}
        button:hover{cursor:pointer;}
        .wp-core-ui .button-primary{background-color:#2a822e;border-color:#2a822e;padding: 6px 20px;font-size: 14px;text-transform: uppercase;}
      </style>';
      //settingsesc_html_errors(); 
       echo '<div class="wrap">
          <h1 style="width: 98%;color: #fff;background:#2271b1; padding: 1em;margin-bottom: 1em;">',esc_html_e('No Results For Elementor Settings','no-results-for-elementor'),'</h1>
      </div>
      <div class="wrap" id="smdev-enr-settings">
      <form method="post" action="options.php" id="enr-form">';
            settings_fields( 'elemnoresults-group' ); 
            do_settings_sections( 'elemnoresults-settings-admin' ); 
            submit_button(); 
       printf( 
                '<p><a href="%s?s=9999999" target="_blank" class="enr-test-button">Preview Page</a><br/>Use this button after saving your changes to preview the page.</p>',
                esc_html(esc_url( home_url( '/' )))
       );        
       echo '</form></div>';
      ?>
<?php
}

  public function page_init(){
    register_setting('elemnoresults-group','elemnoresults-option', array($this,'sanitize'));

    //First Section - General Settings
    add_settings_section('enr_settings_section','General Settings', array( $this,'print_section_info'),'elemnoresults-settings-admin','setting_section_id');

    $this->init_form_fields(); // Initialize form fields
  }
	
  public function init_form_fields(){

    $fields = array(
      'enresc_html_enabled'   => array(
				'title'       => __( 'Enable/Disable the settings below', 'no-results-for-elementor' ),
				'label'       => __( 'Enable/Disable', 'no-results-for-elementor' ),
				'type'        => 'checkbox',
				'description' => __('Enable or Disable the plugin','no-results-for-elementor' ),
				'default'     => '',
		    'class'       => '',		  
		    'fieldID'     => '',		  
			),
      'enr_title'       => array(
				'title'         => __( 'Title', 'no-results-for-elementor' ),
		  	'label'		      => __('Title','no-results-for-elementor'),
				'type'          => 'text',
				'description'   => __( 'Enter a title (optional)', 'no-results-for-elementor' ),
				'default'       => __( 'No results found, please try again below.', 'no-results-for-elementor' ),
		    'class'         => '',		  
		  	'fieldID'       => '',		  
			),
      'enr_description'  => array(
				'title'          => __( 'Description', 'no-results-for-elementor' ),
		  	'label'		       => __('Text','no-results-for-elementor'),
				'type'           => 'textarea',
				'description'    => __( 'Add some additional text underneath the title (optional)', 'no-results-for-elementor' ),
				'default'        => __( '', 'no-results-for-elementor' ),
		    'class'          => '',		
		  	'fieldID'        => '',		  
			),
      'enr_searchbox' => array(
				'title'       => __( 'Show or hide the search input box', 'no-results-for-elementor' ),
				'label'       => __( 'Show/Hide Search Box', 'no-results-for-elementor' ),
				'type'        => 'checkbox',
				'description' => __('By default elementor doesnt show the search input when no results are found, you can use this checkbox to show it.','no-results-for-elementor' ),
				'default'     => '',
				'class'       => '',
		  	'fieldID'     => '',		  
			),

  );
//General
  foreach ($fields as $field => $options) {
    add_settings_field($field, $options['label'], array($this, 'render_field_callback'), 'elemnoresults-settings-admin', 'enr_settings_section', array(
        'field'       => $field,
        'type'        => $options['type'],
        'description' => $options['description'],
        'default'     => $options['default'],
		    'class'       => $options['class'],
		    'fieldID'     => $options['fieldID'],
    ));
  }
}
//General
 /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print '';
    }
  public function render_field_callback($args) {
    $field = $args['field'];
    $type = $args['type'];
    $description = $args['description'];
    $default = $args['default'];
	  $class = $args['class'];  
	  $fieldID = $args['fieldID'];    
    $value = get_option('elemnoresults-option')[$field] ?? $default;

    if ($type === 'text') {
      printf(
        '<input type="text" class="%s" name="elemnoresults-option[%s]" value="%s" />',
        esc_html($class),
        esc_html($field),
        esc_html($value)
      );
      printf(
        '<p class="description">%s</p>',
        esc_html($description)
      );

    } elseif ($type === 'checkbox') {

        $checked = checked($value, 'on', false);

      printf(
        '<input type="checkbox" name="elemnoresults-option[%s]" %s />',
        esc_html($field),
        esc_html($checked)
      );
      printf(
        '<p class="description">%s</p>',
        esc_html($description)
      );


    } elseif ($type === 'textarea') {
      printf(
        '<textarea name="elemnoresults-option[%s]" id="$%s" rows="8" cols="100">%s</textarea>',
        esc_html($field),
        esc_html($fieldID),
        esc_html($value)
      );
      printf(
        '<p class="description">%s</p>',
        esc_html($description)
      );
    }
  }
public function get_plugin_option($option_name) {
    $options = get_option('elemnoresults-option');
    if (isset($options[$option_name])) {
        return $options[$option_name];
    }
    return '';
  }
}

include_once(plugin_dir_path(__FILE__) . 'elemnoresults_output_func.php');
