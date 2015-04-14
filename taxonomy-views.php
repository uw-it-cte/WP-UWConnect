<?php
get_header();
global $wp_query;
$term = $wp_query->queried_object;
query_posts(
  array_merge(
    $wp_query->query,
    array(
    'order' => 'ASC',
    'orderby'=>'title',
    )
  )
);
?>
    <div id='main-content' class='row main-content'>
        <div id='content' class='site-content it_container' role='main'>
            <div id='secondary' class='col-lg-2 col-md-2 hidden-sm hidden-xs' role='complementary'>
                <div id='sidebar' role='navigation' aria-label='Sidebar Menu'>
                    <?php dynamic_sidebar('Service-Catalog-Sidebar'); ?>
                </div> <!-- #sidebar -->
            </div> <!-- #secondary -->
            <div id='primary' class='col-xs-12 col-sm-12 col-md-10 col-lg-10'>
                <?php service_breadcrumbs() ?>
                <div style='margin-left:25px;'>
                <h2>Top Services for <?php echo $term->name; ?></h2>
                <ul class='service-list'>
                <?php while (have_posts()) : the_post();
                global $post;
                $id = $post->ID;
                $shortdesc = get_post_meta($id, 'uwc-short-description', true);
                $perm = get_post_permalink($id);
                ?>
                <a href="<?php echo $perm ?>" class='service-link'>
                <li class='service'><?php the_title(); ?></a>
                <ul class='service-short-desc'>
                <li><?php echo $shortdesc ?></li>
                </ul>
                </li>
                <?php endwhile; ?>
                </ul>
                </div>
            </div> <!-- #primary -->
        </div> <!-- #content -->
    </div> <!-- #main-content -->
<?php get_footer(); ?>
