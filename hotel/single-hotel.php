<?php
function add_styles_scripts()
{
    // wp_enqueue_style('slick-css', 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    // wp_enqueue_style('slick-css', 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('mps-hotel-css', MPS_HOTEL_PLUGIN__URL__ . '/hotel/css/style.css');
    // wp_enqueue_script('slick-js', 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', 'jquery');
}
add_action('wp_enqueue_scripts', 'add_styles_scripts');
wp_head(); ?>
<?php while (have_posts()) : the_post(); ?>
    <div  id="mps-hotel-page" style="padding:32px; background:url(<?=MPS_HOTEL_PLUGIN__URL__."/images/bg.jpg"?>); background-size:cover">
        <div style="background:url(<?= wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) ?>) no-repeat center/cover; width:100%;height:500px;position:relative;">
            <div style="position:absolute;left:0;top:0;background:#000;opacity:0.3;width:100%;height:100%;"></div>
            <h1 style="position: absolute; bottom: 32px; left: 32px; font-weight: bold; color: white;"><?php the_title(); ?>
                <address style="font-size:32px"><?= get_post_meta(get_the_ID(), 'mps_hotels_address', true) ?></address>
            </h1>
        </div>
        <div class="image-container">
            <?php
            $images = get_post_meta(get_the_ID(), "mps_hotels_images", true);
            $arr = explode(",", $images);
            foreach ($arr as $img) :
            ?>
                <div><img src="<?= wp_get_attachment_image_url($img, "large") ?>" /></div>
            <?php endforeach; ?>
        </div>
        <section>
            <h4>Amenities Available</h4>
            <div class="amenities-container">
                <?php
                $amenities = get_post_meta(get_the_ID(), "mps_hotels_amenities", true);
                $arr = explode(",", $amenities);
                foreach ($arr as $a) : $amenity = get_post($a);
                ?>
                    <div><img src="<?= get_the_post_thumbnail_url($amenity) ?>" />
                        <h5><?= $amenity->post_title ?></h5>
                    </div>
		        <?php endforeach; ?>
            </div>
        </section>
        <section class="container"><h4>Description</h4><?php the_content(); ?></section>
		<section><a href="https://cityguide.webstagdummy.com/listing/">View more places around the city on city guide...</a></section>
    </div>
<?php endwhile; ?>

<?php
wp_footer(); ?>