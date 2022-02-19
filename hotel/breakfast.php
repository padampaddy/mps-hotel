<?php

/**
 * Calls the class on the post edit screen.
 */
function call_breakfastClass()
{
    new breakfastClass();
}

if (is_admin()) {
    add_action('load-post.php',     'call_breakfastClass');
    add_action('load-post-new.php', 'call_breakfastClass');
}

/**
 * The Class.
 */
class breakfastClass
{
    public $name = 'mps_hotels_breakfast';

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post',      array($this, 'save'));
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type)
    {
        // Limit meta box to certain post types.
        $post_types = array('hotel');

        if (in_array($post_type, $post_types)) {
            add_meta_box(
                $this->name,
                __('Breakfast Image', 'textdomain'),
                array($this, 'render_meta_box_content'),
                $post_type,
                'advanced',
                'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id)
    {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST[$this->name . '_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST[$this->name . '_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, $this->name)) {
            return $post_id;
        }

        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        /* OK, it's safe for us to save the data now. */

        // Sanitize the user input.
        $mydata = sanitize_text_field($_POST[$this->name]);

        // Update the meta field.
        update_post_meta($post_id, $this->name, $mydata);
    }


    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field($this->name, $this->name . '_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $mainvalue = get_post_meta($post->ID, $this->name, true);
?>
        <a class="addimage button" onclick="custom_postimage_add_breakfast_image();">Add Image</a><br><br>
        <div id="<?= $this->name ?>_wrapper" style="margin-bottom:20px;">

            <img id="<?= $this->name ?>_image" src="<?= wp_get_attachment_url($mainvalue) ?>" style="width:320px;display:block" alt="">
            <input type="hidden" name="<?= $this->name ?>" id="<?= $this->name ?>" value="<?= $mainvalue; ?>" />
        </div>
        <script>
            function custom_postimage_add_breakfast_image() {
                var custom_postimage_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Select Image'
                    },
                    multiple: false
                });
                custom_postimage_uploader.on('select', function() {
                    var attachment = custom_postimage_uploader.state().get('selection').first().toJSON();
                    var img_url = attachment['url'];
                    var img_id = attachment['id'];
                    jQuery("#<?= $this->name ?>_image").attr("src", img_url);
                    jQuery("input#<?= $this->name ?>").val(img_id);
                });
                custom_postimage_uploader.open();
                return false;
            }
        </script>
<?php
    }
}
