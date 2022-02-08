<?php

/**
 * Calls the class on the post edit screen.
 */
function call_imagesClass()
{
    new imagesClass();
}

if (is_admin()) {
    add_action('load-post.php',     'call_imagesClass');
    add_action('load-post-new.php', 'call_imagesClass');
}

/**
 * The Class.
 */
class imagesClass
{
    public $name = 'mps_hotels_images';

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
                __('Images', 'textdomain'),
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

        // Display the form, using the current value.
        $values = explode(",", $mainvalue);
        $values = array_filter($values, function ($v) {
            return $v !== '';
        });
?>
        <a class="addimage button" onclick="custom_postimage_add_image('<?= $this->name ?>');">Add Image</a><br><br>
        <div id="<?= $this->name ?>_container" style="display:flex; gap:16px; overflow-x: scroll;">
            <?php
            for ($i = 0; $i < sizeof($values); $i++) {
                $value = $values[$i] ?? '';
            ?>
                <div id="<?= $this->name ?>_wrapper_<?= $i ?>" style="margin-bottom:20px;">
                    <img src="<?= wp_get_attachment_image_src($value)[0] ?>" style="width:320px;display:block" data-image_id="<?= $value ?>" alt="">
                    <a class="removeimage" style="color:#a00;cursor:pointer;display:block" onclick="custom_postimage_remove_image('<?= $this->name ?>',<?= $i ?>);">Remove Image</a>
                </div>
            <?php } ?>
        </div>
        <input type="hidden" name="<?= $this->name ?>" id="<?= $this->name ?>" value="<?= implode(",", $values); ?>" />
        <script>
            function custom_postimage_add_image(key) {
                var $input = jQuery('input#' + key);
                var inputArr = $input.val()?.split(",");
                inputArr = inputArr.filter(a => a);
                var index = inputArr.length;

                custom_postimage_uploader = wp.media.frames.file_frame = wp.media({
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
                    var html = '<div id="<?= $this->name ?>_wrapper_' + index + '" style="margin-bottom:20px;"> <img src="' + img_url + '" style="width:320px;display:block" data-image_id="' + img_id + '" alt=""> <a class="removeimage" style="color:#a00;cursor:pointer;display:block" onclick="custom_postimage_remove_image(\"<?= $this->name ?>\",' + index + ');" > Remove Image</a></div>';
                    jQuery("#<?= $this->name ?>_container").append(html);
                    inputArr.push(img_id);
                    $input.val(inputArr.join(","));
                });
                custom_postimage_uploader.open();
                return false;
            }

            function custom_postimage_remove_image(key, index) {
                var $wrapper = jQuery('#' + key + '_wrapper' + '_' + index);
                var $input = jQuery('input#' + key);
                var inputArr = $input.val()?.split(",");
                inputArr.splice(parseInt(index), 1);
                $input.val(inputArr.join(","));
                $wrapper.find('img').hide();
                $wrapper.find('a.removeimage').hide();
                return false;
            }
        </script>
<?php
    }
}
