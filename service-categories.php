<?php
get_header();
?>
    <div id='main-content' class='row main-content'>
        <div id='content' class='site-content it_container' role='main'>
            <div id='secondary' class='col-lg-3 col-md-3 hidden-sm hidden-xs' role='complementary'>
                <div id='sidebar' role='navigation' aria-label='Sidebar Menu'>
                    <?php dynamic_sidebar('Service-Catalog-Sidebar'); ?>
                </div> <!-- #sidebar -->
            </div> <!-- #secondary -->
            <div id='primary' class='col-xs-12 col-sm-12 col-md-9 col-lg-9'>
                <?php service_breadcrumbs(); ?>
                <div style='margin-left:25px;'>
                <?php while (have_posts()) : the_post();
                global $post;
                $title = $post->post_title;
                ?>
                <h2><?php echo $title ?></h2>
                <?php the_content(); ?>
                <?php endwhile; ?>
                </ul>
                <?php if (current_user_can('edit_posts')) {
                    edit_post_link('Edit', '<p>', '</p>');
                } ?>
                </div>
            </div> <!-- #primary -->
        </div> <!-- #content -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>
