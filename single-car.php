<?php
get_header();
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php echo get_the_post_thumbnail($post->ID, 'thumbnail' ); ?>
    <h3><?php the_title(); ?></h3>
    <?php the_content(); ?>
    <div class="car-properies">
    <?php _e('Марка:', 'wltesttheme'); ?>
    <?php $marks = wp_get_post_terms($post->ID, 'mark', array('fields' => 'names'));
    foreach($marks as $mark) {
        echo $mark;
    }
    ?>
    </div>
    <div class="car-properies">
    <?php _e('Страна производитель:', 'wltesttheme'); ?>
    <?php $countries = wp_get_post_terms($post->ID, 'country', array('fields' => 'names'));
    foreach($countries as $country) {
        echo $country; 
    } ?>
    </div>
    <div class="car-properies">
    <?php _e('Топливо:', 'wltesttheme'); ?>
    <?php echo get_post_meta($post->ID, '_wporg_fuel_meta_key', true);?>
    </div>
    <div class="car-properies">
    <?php _e('Цвет:', 'wltesttheme'); ?>
    <span style="display:inline-block; border: 1px solid #888; width:10px; height:10px; background-color: <?php echo get_post_meta($post->ID, '_wporg_color_meta_key', true);?>;"></span>
    </div>
    <div class="car-properies">
    <?php _e('Мощность:', 'wltesttheme'); ?>
    <?php echo get_post_meta($post->ID, '_wporg_power_meta_key', true);?>
    </div>
    <div class="car-properies">
    <?php _e('Цена:', 'wltesttheme'); ?>
    <?php echo get_post_meta($post->ID, '_wporg_price_meta_key', true);?>
    </div>
    <?php wp_link_pages(); ?>
    <?php edit_post_link(); ?>
    
<?php endwhile; ?>
 
<?php
if ( get_next_posts_link() ) {
next_posts_link();
}
?>
<?php
if ( get_previous_posts_link() ) {
previous_posts_link();
}
?>
 
<?php else: ?>
 
<p>No posts found. :(</p>
 
<?php endif; ?>

<?php 
get_footer();
?>