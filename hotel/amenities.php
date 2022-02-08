<?php

/**
 * Calls the class on the post edit screen.
 */
function call_amenitiesClass()
{
    new amenitiesClass();
}

if (is_admin()) {
    add_action('load-post.php',     'call_amenitiesClass');
    add_action('load-post-new.php', 'call_amenitiesClass');
}

/**
 * The Class.
 */
class amenitiesClass
{
    public $name = 'mps_hotels_amenities';

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
                __('Amenities', 'textdomain'),
                array($this, 'render_meta_box_content'),
                $post_type,
                'side',
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
        $mydata = $_POST[$this->name];

        // Update the meta field.
        update_post_meta($post_id, $this->name, implode(",", $mydata));
    }


    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
    {
        $original = $post;
        // Add an nonce field so we can check for it later.
        wp_nonce_field($this->name, $this->name . '_nonce');

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, $this->name, true);

        // Display the form, using the current value.
        $amenities = get_posts([
            "post_type"=>'amenities'
        ]);
        $values = explode(",", $value);
?>
        <select name="<?= $this->name ?>[]" style="width:320px;height:160px;" multiple>
            <?php foreach ($amenities as $amenity) : ?>
                <option <?= in_array(strval($amenity->ID), $values) ? 'selected' : '' ?> value="<?= $amenity->ID ?>"><?= $amenity->post_title ?></option>
            <?php endforeach; 
            ?>
        </select>
<?php
    }
}
