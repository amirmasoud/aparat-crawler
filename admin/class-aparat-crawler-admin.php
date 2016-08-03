<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://chakosh.ir
 * @since      1.0.0
 *
 * @package    Aparat_Crawler
 * @subpackage Aparat_Crawler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aparat_Crawler
 * @subpackage Aparat_Crawler/admin
 * @author     AmirMasoud Sheidayi <amirmasood33@gmail.com>
 */
class Aparat_Crawler_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $aparat_crawler    The ID of this plugin.
	 */
	private $aparat_crawler;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The array of videos.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $videos
	 */
	private $videos;

	/**
	 * Finished update status.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var boolean $finished
	 */
	private $finished;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $aparat_crawler       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $aparat_crawler, $version ) {

		$this->aparat_crawler = $aparat_crawler;
		$this->version = $version;
		$this->videos = array();
		$this->finished = false;

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
		 * defined in Aparat_Crawler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aparat_Crawler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->aparat_crawler, plugin_dir_url( __FILE__ ) . 'css/aparat-crawler-admin.css', array(), $this->version, 'all' );

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
		 * defined in Aparat_Crawler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aparat_Crawler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->aparat_crawler, plugin_dir_url( __FILE__ ) . 'js/aparat_crawler-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register aparat page.
	 * 
	 * @since 	1.0.0
	 */
	public function admin_page() {
    	add_options_page("آپارات", "آپارات", 1, "aparat", array($this, 'crawler'));
	}

	public function crawler( $pagingForward = '' ) {
		$url = 'http://www.aparat.com/etc/api/profilehome/username/TorlanGame/';
		echo '<br/>';

		$data = '';
		if ( $pagingForward != '' ) {
			$data = $this->get_data( $pagingForward );
		} else {
			$data = $this->get_data( $url );
		}

		
		if ( $data->ui->pagingForward != '' ) {
			foreach ( $data->profilehome as $cat ) {
				echo 'بررسی وجود دسته <b>"' . $cat->cat_name . '"</b><br/>';
				$this->check_term( $cat->cat_name );
				$this->videos = array();
				$this->crawl_by_cat( $cat->cat_id, $cat->cat_name );
				$this->videos = array();
			}

			return $this->crawler( $data->ui->pagingForward );
		}
	}

	/**
	 * Crawl by category.
	 *
	 * @since 	1.0.0
	 * @param   integer $cat_id
	 * @param   string  $cat_name
	 */
	private function crawl_by_cat( $cat_id, $cat_name ) {
		$url = 'http://www.aparat.com/etc/api/videobyprofilecat/usercat/' . $cat_id . '/username/TorlanGame';

		// Get the first page.
		$data = $this->get_data( $url );
		$this->get_videos($data->videobyprofilecat);

		if ( ! $this->finished ) {
			// Get next page.
			$pagingForward = $data->ui->pagingForward;
			
			// Get next pages if existed.
			while( $pagingForward != '' && ! $this->finished ) {
				$data = $this->get_data( $pagingForward );
				$this->get_videos( $data->videobyprofilecat );
				if ( $this->finished ) {
					break;
				}
				$pagingForward = $data->ui->pagingForward;
			}
		}

		$empty_vidoes = (empty($this->videos));
		if( ! $empty_vidoes ) {
			// Insert posts to videos cpt.
			$this->insert( $cat_name );			
		}
	}

	/**
	 * Loop through videos.
	 *
	 * @since  1.0.0
	 * @param  array $videos
	 * @return array
	 */
	private function get_videos($videos) {
		global $wpdb;
		foreach ( $videos as $video ) {
			$sql = $wpdb->prepare( "SELECT * FROM $wpdb->postmeta WHERE meta_value LIKE %s",
			'%' . $video->uid . '%' );
			$results = $wpdb->get_results( $sql );
			$result = empty((array)$results);

			if( ! $result ) {
				$this->finished = true;
				echo "پایان به روزرسانی. <br/>";
				return;
			}
			array_push( $this->videos, array(
							'title' => $video->title,
							'uid' 	=> $video->uid,
							'big_poster' => $video->big_poster
							)
						);
			echo 'ویدیو <b>"' . $video->title . '"</b> اضافه شد.<br/>';
		}
		return $data;
	}

	/**
	 * Get json data.
	 *
	 * @since  1.0.0
	 * @param  string $url
	 * @return array
	 */
	private function get_data($url) {
		$aparat = file_get_contents( $url );
		return json_decode($aparat);
	}

	/**
	 * Insert aparat videos to movies cpt.
	 *
	 * @param  string $cat
	 * @since  1.0.0
	 */
	private function insert($cat) {
		foreach ( array_reverse( $this->videos ) as $video ) {
			$args = array(
				'post_type' 	=> 'movies',
				'post_title' 	=> $video['title'],
				'post_status' 	=> 'publish',
				'post_author'   => get_current_user_id(),
				'post_content' 	=> '<style>.h_iframe-aparat_embed_frame{position:relative;} .h_iframe-aparat_embed_frame .ratio {display:block;width:100%;height:auto;} .h_iframe-aparat_embed_frame iframe {position:absolute;top:0;left:0;width:100%; height:100%;}</style><div class="h_iframe-aparat_embed_frame"> <span style="display: block;padding-top: 57%"></span><iframe src="https://www.aparat.com/video/video/embed/videohash/' . $video['uid'] . '/vt/frame" allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" ></iframe></div>',
			);

			$post_id = wp_insert_post( $args );
			add_post_meta( $post_id, 'aparat_url', 'http://www.aparat.com/v/' . $video['uid'] );
			add_post_meta( $post_id, 'wp_featherlight_disable', 'yes' );
			$this->set_featured_image( $video['big_poster'], $post_id );
			wp_set_object_terms( $post_id, $cat, 'movies_category' );
		}
	}

	/**
	 * Set featured image for post.
	 *
	 * @link http://wordpress.stackexchange.com/questions/40301/how-do-i-set-a-featured-image-thumbnail-by-image-url-when-using-wp-insert-post
	 * @since 1.0.0
	 * @param string $image_url
	 * @param integer $post_id
	 */
	private function set_featured_image( $image_url, $post_id ) {
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename = basename($image_url);
		if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
		else                                    $file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);

		$wp_filetype = wp_check_filetype($filename, null );
		$attachment = array(
		    'post_mime_type' => $wp_filetype['type'],
		    'post_title' => sanitize_file_name($filename),
		    'post_content' => '',
		    'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
		$res2= set_post_thumbnail( $post_id, $attach_id );
	}

	/**
	 * If term not existed add new one.
	 *
	 * @since  1.0.0
	 * @param  string $term
	 */
	private function check_term($term) {
		if ( ! term_exists($term, 'movies_category' ) ) {
			echo 'دسته <b>"' . $term . '"</b> وجود ندارد.<br/>';
			echo 'در حال ایجاد دسته جدید <b>"' . $term . '"</b> ...<br/>';
			wp_insert_term( $term, 'movies_category' );
			echo 'دسته جدید <b>"' . $term . '"</b> ایجاد شد.<br/>';
		}
		echo 'دسته <b>"' . $term . '"</b> از قبل وجود دارد.<br/>';
	}

	private function dd($code) {
		print_r($code);
		die();
	}
}
