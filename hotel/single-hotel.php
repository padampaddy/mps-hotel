<?php
function add_styles_scripts()
{
    // wp_enqueue_style('slick-css', 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    // wp_enqueue_style('slick-css', 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('mps-hotel-css', MPS_HOTEL_PLUGIN__URL__ . '/hotel/css/style.css');
    // wp_enqueue_script('slick-js', 'http://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', 'jquery');
}
add_action('wp_enqueue_scripts', 'add_styles_scripts');

function add_meta_tags()
{
?>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
<?php }
add_action('wp_head', 'add_meta_tags');

wp_head(); ?>
<?php while (have_posts()) : the_post(); ?>
    <div id="mps-hotel-page">
        <div class="wrapper-banner" style="background:url(<?= wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())) ?>) no-repeat center/cover; width:100%;height:100%;position:relative;">
            <div class="overlay" style=""></div>
            <div class="banner-content">
                <h1 class="" style="text-transform: uppercase;"><?php the_title(); ?>

                </h1>
                <div class="wrapper-holiday d-lg-flex justify-content-md-between align-items-center">
                    <div class="">
                        <h3>BOOK YOUR HOLIDAYS NOW</h3>
                    </div>
                    <!-- <div class="promotion">
                        <h4>HAVE A PROMOTION CODE?</h4>
                    </div> -->
                    <div class="chk-availability">
                        <a style="color:white;" href="tel:<?= get_post_meta(get_the_ID(), "mps_hotels_phone", true) ?>">
                            <h2>CHECK AVAILABILITY<br><span>BEST PRICE GUARANTED!</span></h2>
                        </a>
                    </div>
                </div>
                <div class="banner-bottom">
                    <h3>BEST PRICE GUARANTEED</h3>

                    <p style=" text-transform: capitalize;"><?= get_post_meta(get_the_ID(), 'mps_hotels_address', true) ?></p>
                </div>
            </div>
        </div>
        <section class="wrapper-gallery">
            <div class="container">
                <div class="heading">

                    <h4><?= get_post_meta(get_the_ID(), 'mps_hotels_tagline', true) ?></h4>
                    <h2>WELCOME TO <?= get_the_title() ?></h2>
                </div>
                <p><?= get_post_meta(get_the_ID(), 'mps_hotels_short', true) ?> </p>
                <div class="wrapper-booking">
                    <?php
                    $images = get_post_meta(get_the_ID(), "mps_hotels_images", true);
                    $arr = explode(",", $images);
                    foreach ($arr as $img) :
                    ?>
                        <div><img src="<?= wp_get_attachment_image_url($img, "large") ?>" /></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php $lobby = get_post_meta(get_the_ID(), "mps_hotels_lobby", true);
        if ($lobby) : ?>
            <section class="qr-code text-center">

                <div class="heading">
                    <h4><?= get_post_meta(get_the_ID(), 'mps_hotels_tagline', true) ?></h4>
                    <h2>Lobby Area</h2>
                </div>
                <div class="wrapper-qr">
                    <div class="">
                        <div class="booking3"><img src="<?= wp_get_attachment_url($lobby) ?>"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <section class="amenities-section text-center">
            <div class="container">
                <div class="heading">
                    <h4>Top Amenities</h4>
                    <h2>Popular Amenities</h2>
                </div>
                <div class="wrapper-amenities">
                    <?php
                    $amenities = get_post_meta(get_the_ID(), "mps_hotels_amenities", true);
                    $arr = explode(",", $amenities);
                    foreach ($arr as $a) : $amenity = get_post($a);
                    ?>
                        <div><span><img src="<?= get_the_post_thumbnail_url($amenity) ?>" /></span>
                            <h4><?= $amenity->post_title ?></h4>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php $breakfast = get_post_meta(get_the_ID(), "mps_hotels_breakfast", true);
        if ($breakfast) : ?>
            <section class="qr-code text-center">

                <div class="heading">
                    <h4><?= get_post_meta(get_the_ID(), 'mps_hotels_tagline', true) ?></h4>
                    <h2>Breakfast Area</h2>
                </div>
                <div class="wrapper-qr">
                    <div class="">
                        <div class="booking3"><img src="<?= wp_get_attachment_url($breakfast) ?>"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php $vending = get_post_meta(get_the_ID(), "mps_hotels_vending", true);
        if ($vending) : ?>
            <section class="qr-code text-center">

                <div class="heading">
                    <h4><?= get_post_meta(get_the_ID(), 'mps_hotels_tagline', true) ?></h4>

                    <h2>Vending Area</h2>
                </div>
                <div class="wrapper-qr">
                    <div class="">
                        <div class="booking3"><img src="<?= wp_get_attachment_url($vending) ?>"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php $pool = get_post_meta(get_the_ID(), "mps_hotels_pool", true);
        if ($pool) : ?>
            <section class="qr-code text-center">

                <div class="heading">
                    <h4><?= get_post_meta(get_the_ID(), 'mps_hotels_tagline', true) ?></h4>
                    <h2>Pool Area</h2>
                </div>
                <div class="wrapper-qr">
                    <div class="">
                        <div class="booking3"><img src="<?= wp_get_attachment_url($pool) ?>"></div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <section>
            <div class="heading">
                <h2>Get in touch with us <br><a class="contact-phone" href="tel:<?= get_post_meta(get_the_ID(), "mps_hotels_phone", true) ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                        </svg>&nbsp;&nbsp;<?= get_post_meta(get_the_ID(), "mps_hotels_phone", true) ?></a> </h2>
            </div>
        </section>

        <section class="special-offer">
            <div class="heading">

                <h4><?= get_post_meta(get_the_ID(), 'mps_hotels_tagline', true) ?></h4>
                <h2>Special Offers</h2>
            </div>
            <div class="special-offer-wrapper">
                <?php
                $special = get_post_meta(get_the_ID(), "mps_hotels_specials", true);
                $arr = explode(",", $special);
                foreach ($arr as $a) :;
                ?>
                    <div class="special-offer1 room"><img src="<?= wp_get_attachment_image_url($a, "large") ?>" /></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="wrapper-desp">
            <div class="container">
                <div class="desp">
                    <h4>Description</h4><?php the_content(); ?>
                </div>
            </div>
        </section>

    </div>
    <section>
        <div class="heading text-cnter">
            <h2>For more places visit<br> <a class="contact-phone" href="http://cityguide.webstagdummy.com/mobile">City Guide</a></h2>
        </div>
    </section>
    <div class="copy-right">
        <p>Copyright@2021 DEMO HOTEL ALL RIGHTS RESERVED.</p>
    </div>
    </div>
<?php endwhile; ?>

<?php
wp_footer(); ?>