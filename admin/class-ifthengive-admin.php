<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.angelleye.com/
 * @since      0.1.0
 *
 * @package    IfThenGive
 * @subpackage IfThenGive/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    IfThenGive
 * @subpackage IfThenGive/admin
 * @author     Angell EYE <andrew@angelleye.com>
 */
class IfThenGive_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                $this->load_dependencies();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ifthengive_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ifthengive_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */                 
                $screen = get_current_screen();                
                if($screen->post_type == 'ifthengive_goals' || $screen ->id == 'settings_page_ifthengive_option' || $screen ->id == 'dashboard_page_ifthengive_givers' ){
                   wp_enqueue_style($this->plugin_name . 'eight', ITG_PLUGIN_URL.'includes/css/bootstrap/css/bootstrap.css', array(), $this->version, 'all');
                   wp_enqueue_style($this->plugin_name . 'nine',  ITG_PLUGIN_URL.'includes/css/alertify/alertify.css', array(), $this->version, 'all');
                }
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ifthengive-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ifthengive_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ifthengive_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
                $screen = get_current_screen();
                if($screen->post_type == 'ifthengive_goals' || $screen ->id == 'settings_page_ifthengive_option' || $screen ->id == 'dashboard_page_ifthengive_givers' ){
                     wp_enqueue_script($this->plugin_name . 'six', ITG_PLUGIN_URL . 'includes/css/bootstrap/js/bootstrap.min.js', array('jquery'), $this->version, false);
                     wp_enqueue_script($this->plugin_name . 'seven', ITG_PLUGIN_URL . 'includes/css/clipboardjs/clipboard.min.js', array('jquery'), $this->version, false);
                     wp_enqueue_script($this->plugin_name . 'ten', ITG_PLUGIN_URL . 'includes/css/alertify/alertify.min.js', array('jquery'), $this->version, false);                     
                }
                if($screen->post_type == 'ifthengive_goals'){
                    wp_enqueue_script($this->plugin_name . 'ele', plugin_dir_url( __FILE__ ) . 'js/ifthengive-post.js', array('jquery'), $this->version, false);
                }
                                
                if ( ! did_action( 'wp_enqueue_media' ) ) {
                    wp_enqueue_media();
                }                
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ifthengive-admin.js', array( 'jquery' ), $this->version, false );
                
                global $post;
                $args = array(
                    'post_type' => 'ifthengive_goals',
                    'post_status' => 'publish',
                    'posts_per_page' => '100'                    
                );

                $posts = get_posts($args);
		$ifthengive_posts = get_posts($args);                
		$shortcodes = array();
		$shortcodes_values = array();
                $shortcodes['[ifthengive_transactions]']='Transaction';
                $shortcodes['[ifthengive_account]']='Account';
                $shortcodes['[ifthengive_goals]'] = 'My Signedup Goals';
                foreach ($ifthengive_posts as $key_post => $ifthengive_posts_posts_value) {
			$shortcodes[$ifthengive_posts_posts_value->ID] = $ifthengive_posts_posts_value->post_title;
		}
		if (empty($shortcodes)) {

			$shortcodes_values = array('0' => 'No shortcode Available');
		} else {
			$shortcodes_values = $shortcodes;
		}
		wp_localize_script($this->plugin_name, 'itg_shortcodes_button_array', apply_filters('ifthengive_shortcode', array(
		'shortcodes_button' => $shortcodes_values
		)));
                
                $sanbox_enable = get_option('itg_sandbox_enable', TRUE);                
                wp_localize_script($this->plugin_name, 'itg_sanbox_enable_js', $sanbox_enable);
                
                wp_localize_script($this->plugin_name, 'admin_ajax_url', admin_url('admin-ajax.php'));
                
	}
        
    private function load_dependencies() {
        /*The class responsible for defining all actions that occur in the Admin side for Goals. */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-post-types.php';
        
        /* The class responsible for defining  "itg_sign_up" custom post type. */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-post-types-sign-up.php';
        
        /* The class responsible for defining  "itg_transactions" custom post type. */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-post-types-transactions.php';
        
        /* The class responsible for defining all actions that occur in the display of admin side */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-admin-display.php';
        
        /* The class responsible for defining function for display Html element */
	require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-html-output.php';
        
        /* The class responsible for defining function for display connetc to PayPal setting tab */
	require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-connect_paypal.php';
                
        /*Custom class table */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-giver.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-list_transactions.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-list_users_transactions.php';
        
        /* The class responsible for cancel billing agreement of givers */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ifthengive-cancel-billing-agreement.php';
        require_once ITG_PLUGIN_DIR.'/library/dompdf/autoload.inc.php';
    }
    
    /**
     *  ifthengive_shortcode_button_init function process for registering our button.
     *
     */
    public function ifthengive_shortcode_button_init() {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
		return;

        /*Add a callback to regiser our tinymce plugin*/
        add_filter('mce_external_plugins', array($this, 'ifthengive_register_tinymce_plugin'));

        /* Add a callback to add our button to the TinyMCE toolbar */
        add_filter('mce_buttons', array($this, 'ifthengive_add_tinymce_button'));
    }
    
    public function ifthengive_register_tinymce_plugin($plugin_array) {
        $plugin_array['ifthengive_shortcodes'] = plugin_dir_url(__FILE__) . 'js/ifthengive-admin.js';
	return $plugin_array;                
    }

    public function ifthengive_add_tinymce_button($buttons) {
        array_push($buttons, 'ifthengive_shortcodes');
        return $buttons;
    }
      
    public function ifthengive_messages(){
        
        global $post, $post_ID;
        $post_ID = $post->ID;
        $post_type = get_post_type($post_ID);
        
        $custom_message = __('Goal Created Successfully','ifthengive');
        $messages['ifthengive_goals'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf(__('Goal Updated Successfully','ifthengive')),
		2 => __('Custom field updated.','ifthengive'),
		3 => __('Custom field deleted.','ifthengive'),
		4 => __($custom_message,'ifthengive'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf(__('Goal restored to revision from %s','ifthengive'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		6 => sprintf(__($custom_message,'ifthengive')),
		7 => __('Goal saved.','ifthengive'),
		8 => sprintf(__('Goal submitted. <a target="_blank" href="%s">Preview Goal</a>','ifthengive'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		9 => sprintf(__('Goal scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Goal</a>','ifthengive'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
		10 => sprintf(__('Goal draft updated. <a target="_blank" href="%s">Preview Goal</a>','ifthengive'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		);
		return $messages;

        return $messages;
    }
    
  /**
    * Adds three links to plugin's action links.
    * @since    0.1.0
    */
    
    public function ifthengive_plugin_action_links( $links, $file ){
           $plugin_basename = ITG_PLUGIN_BASENAME;
           if($file == $plugin_basename)
           {
               $new_links = array(
                   sprintf( '<a href="%s">%s</a>', admin_url('options-general.php?page=ifthengive_option'), __( 'Configure', 'ifthengive' ) ),
                   sprintf( '<a href="%s" target="_blank">%s</a>', 'https://www.angelleye.com/category/docs/wordpress', __( 'Docs', 'ifthengive' ) ),
                   sprintf( '<a href="%s" target="_blank">%s</a>', 'https://wordpress.org/support/plugin/angelleye-ifthengive', __( 'Support', 'ifthengive' ) ),
                   sprintf( '<a href="%s" target="_blank">%s</a>', 'https://wordpress.org/plugins/angelleye-ifthengive/#reviews', __( 'Write a Review', 'ifthengive' ) ),
               );

               $links = array_merge( $links, $new_links );
           }
           return $links;
    }
   
   /**
    * Display the notice while transaction process.
    * @since    0.1.0
    */
    function processing_notice(){
            $in_process = get_option('itg_txns_in_process');
            $current_process_goal = get_option('itg_current_process_goal_id');
            $complete_percentage = get_option('itg_current_process_progress');
            $is_complete = get_option('itg_transaction_complete');
            $is_retry_txn = get_option('itg_failed_txns_in_process');
            if(!empty($current_process_goal) && is_numeric($current_process_goal)){
                $goal_title =  get_the_title( $current_process_goal );
            }
            else{
                $goal_title = '';
            }
            if($in_process === 'yes') : ?>
                <div class="notice notice-warning is-dismissible">
                    <p>
                        <?php
                        echo sprintf('%1$s<b>%2$s</b> %3$s %4$s%5$s',
                                __('IfThenGive : ','ifthengive'),
                                $goal_title,
                                __(' running in background. Transactions are in Process. ','ifthengive'),
                                $complete_percentage,
                                __('% Completed.','ifthengive') 
                             );
                        ?>
                    </p>                   
                </div>
            <?php
            endif;
            
            if($is_complete == 'yes'): ?>
                <div class="notice notice-success is-dismissible">
                    <p>
                        <?php
                        echo sprintf('%1$s<b>%2$s</b> %3$s <a href="%5$s">%4$s</a>',
                                    __('IfThenGive : ','ifthengive'),
                                    $goal_title,
                                    __('Transactions Completed.','ifthengive'),
                                    __('See Transactions.','ifthengive'),
                                    admin_url('edit.php?post_type=ifthengive_goals&page=ifthengive_givers&post='.$current_process_goal.'&view=ListTransactions&orderby=Txn_date&order=desc')
                                    );
                        ?>
                    </p>                    
                </div>
                
            <?php                 
                $this->rest_transaction_status($current_process_goal,$is_retry_txn);                                
            endif;
        }
        
        /*
         *   While do transaction, we are adding transaction status to 1.
         *   We are resting here to 0 in this function so that means process for that is completed.
         *   and all givers are set to 0.
         */
        function rest_transaction_status($goal_id='',$is_retry_txn=''){             
            update_option('itg_txns_in_process', 'no');
            update_option('itg_current_process_goal_id',0);
            update_option('itg_current_process_progress', 0);
            update_option('itg_transaction_complete','');
            if(!empty($goal_id)){
                if($is_retry_txn == 'yes'){
                    update_option('itg_failed_txns_in_process','no');
                    $meta_post_ids = AngellEYE_IfThenGive_Transactions_Table::reset_transaction_status($goal_id);
                    foreach ($meta_post_ids as $post_id) {
                         update_post_meta($post_id['post_id'], 'itg_txn_pt_status', '0');     
                    }
                }
                else{
                    $meta_post_ids = AngellEYE_IfThenGive_Givers_Table::reset_givers_transaction_status($goal_id);
                    foreach ($meta_post_ids as $post_id) {
                         update_post_meta($post_id['signup_postid'], 'itg_transaction_status', '0');     
                    }
                }                
            }
        }

        public function itg_block_cgb_editor_assets(){

            wp_enqueue_script(
                'itg_block-cgb-block-js',
                ITG_PLUGIN_URL.'includes/gutenberg/blocks.build.js',
                array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
                $this->version,
                true
            );

            wp_enqueue_style(
                'itg_block-cgb-block-editor-css',
                ITG_PLUGIN_URL.'includes/gutenberg/blocks.editor.build.css',
                array( 'wp-edit-blocks' )
            );
        }
    }
