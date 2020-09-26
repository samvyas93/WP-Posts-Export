<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://test.com
 * @since      1.0.0
 *
 * @package    Samir_Post_Export
 * @subpackage Samir_Post_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Samir_Post_Export
 * @subpackage Samir_Post_Export/admin
 * @author     Samir Vyas <sam.vyas81@gmail.com>
 */
class Samir_Post_Export_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Samir_Post_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Samir_Post_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/samir-post-export-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Samir_Post_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Samir_Post_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/samir-post-export-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Adds "Export" button on post list page
	 */
	public function addCustomExportButton()
	{
		global $current_screen;

	    // Not our post type, exit earlier
	    // You can remove this if condition if you don't have any specific post type to restrict to. 
	    if ('post' != $current_screen->post_type) {
	        return;
	    }

	    ?>
	        <script type="text/javascript">
	            jQuery(document).ready( function($)
	            {
	                $('.wp-header-end').before("<a id='run_export' class='add-new-h2'>Export</a>");
	                $('#posts-filter').append('<input type="submit" id="cus_export" name="export_all_posts" class="button button-primary" value="Export All Posts" />');
	                $('#cus_export').css("display", "none");
	                $("#run_export").on("click", function () {
					 	//console.log('1');
					 	$("#cus_export").trigger("click");
					});
					/*$("#cus_export").on("click", function () {
					 	console.log('2');
					 	alert();
					 	$("#posts-filter").submit();
					 	/*jQuery.ajax({
							"type": "POST",
							"url": '<?php echo admin_url('admin-ajax.php'); ?>',
							'data': {
								action: 'export_posts'
								// etc..
							},
							success: function (result) {
								console.log("called");
							}
						});
					}); */
	            });
	        </script>
	    <?php
	}

	public function sam_func_export_all_posts()
	{
		//var_dump($_POST);
		if(isset($_GET['export_all_posts'])) {
	        $arg = array(
	            'post_type' => 'post',
	            'post_status' => 'publish',
	            'posts_per_page' => -1,
	        );
	  
	        global $post;
	        $arr_post = get_posts($arg);
	        if ($arr_post) {
	  
	            header('Content-type: text/csv');
	            header('Content-Disposition: attachment; filename="wp-posts.csv"');
	            header('Pragma: no-cache');
	            header('Expires: 0');
	  
	            $file = fopen('php://output', 'w');
	  
	            fputcsv($file, array('Post Title', 'URL', 'Categories', 'Tags', 'Featured Image', 'Author'));
	  
	            foreach ($arr_post as $post) {
	                setup_postdata($post);
	                  
	                $categories = get_the_category();
	                $cats = array();
	                if (!empty($categories)) {
	                    foreach ( $categories as $category ) {
	                        $cats[] = $category->name;
	                    }
	                }
	  
	                $post_tags = get_the_tags();
	                $tags = array();
	                if (!empty($post_tags)) {
	                    foreach ($post_tags as $tag) {
	                        $tags[] = $tag->name;
	                    }
	                }

	                if(has_post_thumbnail()){
	                	$thumb_url = get_the_post_thumbnail_url(get_the_ID());
	                }
	                else{
	                	$thumb_url = 'N/A';
	                }

	                $author = get_the_author();
	  
	                fputcsv($file, array(get_the_title(), get_the_permalink(), implode(",", $cats), implode(",", $tags), $thumb_url, $author));
	            }
	  
	            exit();
	        }
	    }
	}

}
