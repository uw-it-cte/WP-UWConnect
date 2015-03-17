<?php define( 'DONOTCACHEPAGE', True );
get_header(); ?>
    <div id='main-content' class='row main-content'>
        <div id='content' class='site-content it_container' role='main'>
            <div id='secondary' class='col-lg-2 col-md-2 hidden-sm hidden-xs' role='complementary'>
                <div id='sidebar' role='navigation' aria-label='Sidebar Menu'>
                    <?php dynamic_sidebar('Service-Catalog-Sidebar'); ?>
                </div> <!-- #sidebar -->
            </div> <!-- #secondary -->
            <div id='primary' class='col-xs-12 col-sm-12 col-md-10 col-lg-10 itsm-primary'>
                <?php while (have_posts()) : the_post();
                global $post;
                $id = $post->ID;?>

                <h1><?php the_title(); ?></h1>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Service Description</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-description', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Service Options</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-options_text', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Eligibility</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-eligibility', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>How to Order</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-ordering', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Availability</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-availability', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Price</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-price', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Additional Information</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-additional-info', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Support Information</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-support-info', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Contact for More Information</h2>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-customer-ref', true); ?></p>
                </div>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Maintainance</h2>
                  <h3 class='service-subattr'>Last Review Date</h3>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-last-review', true); ?></p>
                  <h3 class='service-subattr'>Next Review Date</h3>
                  <p class='attr-text'><?php echo get_post_meta($id, 'uwc-next-review', true); ?></p>
                </div>
                <?php endwhile; ?>
            </div> <!-- #primary -->
        </div> <!-- #content -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>
