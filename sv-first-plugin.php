<?php
/*
   Plugin Name: sv-first-plugin
   Plugin URI: 
   Description: Starskie Villanueva first plugin
   Version: 0.1
   Author: Starskie Villanueva
   Author URI: 
   License: GPL2
*/

// using plugin class for cleaner and more organize to use
class sv_first_plugin
{
	// start with construct and assign call backs 
	public function __construct() 
	{
		// call back for custom post types 
		add_action( 'init', array($this, 'custom_post_type_callback' ) );
					
		// call back for meta box
		add_action( 'add_meta_boxes', array($this, 'post_meta_boxes' ));
		
		// call back for saving post
		add_action( 'save_post', array( $this, 'save_sample_field' ) );
		
	}	
	// callback action for custom post my type
	public function custom_post_type_callback() 
	{
    	register_post_type( 'podcast',
        	array(
            'labels' => array(
                'name' => 'Podcast',
                'singular_name' => 'Podcast Review',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Podcast Review',
                'edit' => 'Edit',
                'edit_item' => 'Edit Podcast Review',
                'new_item' => 'New Podcast Review',
                'view' => 'View',
                'view_item' => 'View Podcast Review',
                'search_items' => 'Search Podcast Reviews',
                'not_found' => 'No Podcast Reviews found',
                'not_found_in_trash' => 'No Podcast Reviews found in Trash',
                'parent' => 'Parent Podcast Review'
           		), 
            	'public' => true,
            	'menu_position' => 15,
            	'menu_icon' => 'dashicons-microphone',
            	'has_archive' => true
        	));
	}
	//callback action for metabox
 	public function post_meta_boxes() 
 		{
			add_meta_box
			( 
		    	'post-class-meta-box',
		    	__( "Meta box", 'podcast' ),
		    	array( $this, 'post_class_meta_box' ),
		    	''
		    );
		}
		  	
	// for displaying meta box
	public function post_class_meta_box( $post ) 
	{ 
		if ( ! empty ( $post ) ) 
		{
			$audio_input = get_post_meta( $post->ID, 'audio_input', true );
			$episode_input = get_post_meta( $post->ID, 'episode_input', true );
		}
		?>
    		<p>
     		<label for="audio_input">Audio</label>
     		<br/>
     		<input type="text" name="audio_input" value="<?php echo $audio_input; ?>" />
    		</p>
  			<p>
    		<label for="episode_input">Episode Notes</label>
    		<br/>
     		<textarea name="episode_input" cols="100" rows="3"><?php echo $episode_input; ?></textarea>	
    		<?php
	  }
	  
	// callback for saving post meta data
	public function save_sample_field( $post_id ) 
	{
		
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		{
			return;
		}

		$slug = 'podcast';
		if ( ! isset( $_POST['post_type'] ) || $slug != $_POST['post_type'] ) 
		{
			return;
		}
		
		if ( isset( $_POST['audio_input']  ) ) 
		{
			update_post_meta( $post_id, 'audio_input',  esc_html( $_POST['audio_input'] ) );
		}
		
		if ( isset( $_POST['episode_input']  ) ) 
		{
			update_post_meta( $post_id, 'episode_input',  esc_html( $_POST['episode_input'] ) );
		}
	}
	
	  
}	
$sv_first_plugin = new sv_first_plugin();
?>