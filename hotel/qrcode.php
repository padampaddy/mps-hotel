<?php

/**
 * Calls the class on the post edit screen.
 */
function call_QRcodeClass()
{
    new QRcodeClass();
}

if (is_admin()) {
    add_action('load-post.php',     'call_QRcodeClass');
    add_action('load-post-new.php', 'call_QRcodeClass');
}

/**
 * The Class.
 */
class QRcodeClass
{
    public $name = 'mps_hotels_qrcode';

    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
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
                __('QR Code', 'textdomain'),
                array($this, 'render_meta_box_content'),
                $post_type,
                'side',
                'low'
            );
        }
    }
    public function render_meta_box_content($post)
    {
?>
        <div id="qrcode"></div><br>
        <button id="qrcode-button" class="button" type="button">Download Code</button>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                var ele = document.getElementById("qrcode");
                new QRCode(ele, "<?= get_permalink($post) ?>");
                document.getElementById("qrcode-button").onclick = function() {
                    var ele = document.getElementById("qrcode");
                    var img = ele.children[1];
                    var a = document.createElement('a');
                    a.setAttribute("download", "<?= get_the_title($post) ?>.png");
                    a.setAttribute("href", img.src);
                    a.appendChild(img);
                    var w = window.open();
                    w.document.title = 'Export Image';
                    w.document.body.innerHTML = 'Left-click on the image to save it.';
                    w.document.body.appendChild(a);
                    new QRCode(ele, "<?= get_permalink($post) ?>");
                };
            });
        </script>
<?php
    }
}
