<?php define( 'DONOTCACHEPAGE', True );
get_header(); ?>
    <div id='main-content' class='row main-content'>
        <div id='content' class='site-content it_container' role='main'>
            <div id='secondary' class='col-lg-2 col-md-2 hidden-sm hidden-xs' role='complementary'>
                <div id='sidebar' role='navigation' aria-label='Sidebar Menu'>
                    <?php dynamic_sidebar('Service-Catalog-Sidebar'); ?>
                </div> <!-- #sidebar -->
            </div> <!-- #secondary -->
            <div id='primary' class='col-xs-12 col-sm-12 col-md-10 col-lg-10'>
                <?php while (have_posts()) : the_post();
                global $post;
                $id = $post->ID;

                service_breadcrumbs($post);
                ?>

                <div style='margin-left:25px;'>
                <h1 class='entry-title'><?php the_title(); ?></h1>
                <?php if (get_post_meta($id, 'uwc-description', true)) { ?>
                  <div class='attr-wrap'>
                    <h2 class='service-attr'>Service Description</h2>
                    <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-description', true)); ?></div>
                  </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-options-text', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Service Options</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-options-text', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-eligibility', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Eligibility</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-eligibility', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-ordering', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>How to Order</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-ordering', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-availability', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Availability</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-availability', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-price', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Price</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-price', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-additional-info', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Additional Information</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-additional-info', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-support-info', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Support Information</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-support-info', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-customer-ref', true)) { ?>
                <div class='attr-wrap'>
                  <h2 class='service-attr'>Contact for More Information</h2>
                  <div class='attr-text'><?php echo wpautop(get_post_meta($id, 'uwc-customer-ref', true)); ?></div>
                </div>
                <?php } ?>
                <?php if (get_post_meta($id, 'uwc-last-review', true)) { ?>
                <hr id="fold" />
                <div class='superattr-wrap'>
                  <h2 class='service-attr belowf'>Maintenance</h2>
                  <div class='subattr-wrap'>
                    <p class='attr-text'>Last Review Date: <?php echo get_post_meta($id, 'uwc-last-review', true); ?></p>
                  </div>
                </div>
                </div>
                <?php } ?>
                <?php endwhile; ?>
            </div> <!-- #primary -->
        </div> <!-- #content -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>
