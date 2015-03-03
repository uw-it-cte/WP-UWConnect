<?php
function service_post_type() {
    $labels = array(
        'name' => _x('Services', 'post type general name'),
        'singular_name' => _x('Service', 'post type signular name'),
        'add_new' => _x('Add New', 'service'),
        'add_new_item' => __('Add New Service'),
        'edit_item' => __('Edit Service'),
        'new_item' => __('New Service'),
        'all_items' => __('All Services'),
        'view_item' => __('View Service'),
        'search_items' => __('Search Services'),
        'not_found' => __('No Services Found'),
        'not_found_in_trash' => __('No Services found in the Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'description' => 'Holds our services and service sepecific data.',
        'public' => true,
        'capability_type' => 'page',
        'menu_position' => 5,
        'register_meta_box_cb' => '',
        'supports' => array('title'),
        'has_archive' => false,
        'hierarchical' => true
    );
    register_post_type('service', $args);
}

add_action('init', 'service_post_type');

add_action('add_meta_boxes', 'service_info');

function service_info() {
    add_meta_box('service_form', 'Service Details', 'service_content', 'service', 'normal', 'default');
}

function service_content($object, $box) {
    wp_nonce_field(basename(__FILE__), 'service_details_nonce'); ?>

    <p>
        <label for='description'><?php _e('Short Description', 'services'); ?></label>
        <input type='text' name='short-description' id='short-description' value="<?php echo esc_attr(get_post_meta($object->ID, 'short-description', true)); ?>" size="90" />
    </p>
<?php }

add_action('save_post', 'save_service_form', 10, 2);

function save_service_form($post_id, $post) {

    if (!verify_save('service_details_nonce', $post_id))
        return $post_id;

    update_service($post_id, 'service_form', 'short-description', sanitize_post_field('short-description', $_POST['short-description'], $post_id, 'display'));
}

function verify_save ($nonce_name, $post_id) {
    if (!isset($_POST[$nonce_name])) {
        return false;
    }
    if (!wp_verify_nonce($_POST[$nonce_name], basename(__FILE__))) {
        return false;
    }
    if (!current_user_can('edit_page', $post_id)) {
        return false;
    }

    return true;
}

function update_service($post_id, $service_form, $detail_name) {
    $new_meta_value = (isset($_POST[$detail_name]) ? sanitize_post_field($detail_name, $_POST[$detail_name], $post_id, 'display'):'');

    $meta_key = $detail_name;

    $meta_value = get_post_meta($post_id, $meta_key, true);

    if ($new_meta_value && '' == $meta_value)
        add_post_meta($post_id, $meta_key, $new_meta_value, true);
    elseif ($new_meta_value && $new_meta_value != $meta_value)
        update_post_meta($post_id, $meta_key, $new_meta_value);
    elseif ('' == $new_meta_value && $meta_value)
        delete_post_meta($post_id, $meta_key, $meta_value);
}
?>
