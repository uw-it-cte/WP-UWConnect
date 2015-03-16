<?php define( 'DONOTCACHEPAGE', True );
get_header(); ?>
    <div id='main-content' class='row main-content'>
        <div id='content' class='site-content it_container' role='main'>
            <div id='secondary' class='col-lg-2 col-md-2 hidden-sm hidden-xs' role='complementary'>
                <div id='sidebar' role='navigation' aria-label='Sidebar Menu'>
                    <?php dynamic_sidebar('servicenow-sidebar'); ?>
                </div> <!-- #sidebar -->
            </div> <!-- #secondary -->
            <div id='primary' class='col-xs-12 col-sm-12 col-md-10 col-lg-10 itsm-primary'>
                <?php while (have_posts()) : the_post();
                global $post;
                $id = $post->ID;?>
                <h1><?php the_title(); ?></h1>
                <h2>Service Description:</h2>
                <p><?php echo get_post_meta($id, 'uwc-description', true); ?></p>
                <h2>Service Options:</h2>
                <p><?php echo get_post_meta($id, 'uwc-options_text', true); ?></p>
                <h2>Eligibility:</h2>
                <p><?php echo get_post_meta($id, 'uwc-eligibility', true); ?></p>
                <h2>How to Order:</h2>
                <p><?php echo get_post_meta($id, 'uwc-ordering', true); ?></p>
                <h2>Availability:</h2>
                <p><?php echo get_post_meta($id, 'uwc-availability', true); ?></p>
                <h2>Price:</h2>
                <p><?php echo get_post_meta($id, 'uwc-price', true); ?></p>
                <h2>Additional Information:</h2>
                <p><?php echo get_post_meta($id, 'uwc-additional_info', true); ?></p>
                <h2>Support Information:</h2>
                <p><?php echo get_post_meta($id, 'uwc-support_info', true); ?></p>
                <h2>Contact for More Information:</h2>
                <p><?php echo get_post_meta($id, 'uwc-customer_ref', true); ?></p>
                <h2>Maintainance:</h2>
                <h3>Last Review Date:</h3>
                <p><?php echo get_post_meta($id, 'uwc-last_review', true); ?></p>
                <h3>Next Review Date:</h3>
                <p><?php echo get_post_meta($id, 'uwc-next_review', true); ?></p>
                <?php endwhile; ?>
            </div> <!-- #primary -->
        </div> <!-- #content -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>
