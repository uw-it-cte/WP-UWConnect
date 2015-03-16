<?php define( 'DONOTCACHEPAGE', True );
get_header();
$term = $wp_query->queried_object;
?>
    <div id='main-content' class='row main-content'>
        <div id='content' class='site-content it_container' role='main'>
            <div id='secondary' class='col-lg-2 col-md-2 hidden-sm hidden-xs' role='complementary'>
                <div id='sidebar' role='navigation' aria-label='Sidebar Menu'>
                    <?php dynamic_sidebar('ServiceCatalog-sidebar'); ?>
                </div> <!-- #sidebar -->
            </div> <!-- #secondary -->
            <div id='primary' class='col-xs-12 col-sm-12 col-md-10 col-lg-10 itsm-primary'>
                <h2>Top Services for <?php echo $term->name; ?></h2>
                <ul style="list-style-type:none;">
                <?php while (have_posts()) : the_post();
                global $post;
                $id = $post->ID;
                $shortdesc = get_post_meta($id, 'uwc-short-description', true);
                $perm = get_post_permalink($id);
                ?>
                <a href="<?php echo $perm ?>" >
                <li><?php the_title(); ?></a>
                <ul>
                <li><?php echo $shortdesc ?></li>
                </ul>
                </li>
                <?php endwhile; ?>
                </ul>
            </div> <!-- #primary -->
        </div> <!-- #content -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>
