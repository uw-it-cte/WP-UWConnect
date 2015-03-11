                    <?php get_header(); ?>
                    <?php while (have_posts()) : the_post(); ?>
                    <?php global $post; $id = $post->ID;?>
                    <pre>Dump: <?php echo $id; ?></pre>
                    <h1><?php the_title(); ?></h1>
                    <h2>Service Description:</h2>
                    <p><?php echo get_post_meta($id, 'description', true); ?></p>
                    <h2>Service Options:</h2>
                    <p><?php echo get_post_meta($id, 'options_text', true); ?></p>
                    <h2>Eligibility:</h2>
                    <p><?php echo get_post_meta($id, 'eligibility', true); ?></p>
                    <h2>How to Order:</h2>
                    <p><?php echo get_post_meta($id, 'ordering', true); ?></p>
                    <h2>Availability:</h2>
                    <p><?php echo get_post_meta($id, 'availability', true); ?></p>
                    <h2>Price:</h2>
                    <p><?php echo get_post_meta($id, 'price', true); ?></p>
                    <h2>Additional Information:</h2>
                    <p><?php echo get_post_meta($id, 'additional_info', true); ?></p>
                    <h2>Support Information:</h2>
                    <p><?php echo get_post_meta($id, 'support_info', true); ?></p>
                    <h2>Contact for More Information:</h2>
                    <p><?php echo get_post_meta($id, 'customer_ref', true); ?></p>
                    <h2>Maintainance:</h2>
                    <h3>Last Review Date:</h3>
                    <p><?php echo get_post_meta($id, 'last_review', true); ?></p>
                    <h3>Next Review Date:</h3>
                    <p><?php echo get_post_meta($id, 'next_review', true); ?></p>
                    <?php endwhile; ?>
