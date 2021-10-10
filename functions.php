<?php
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
	wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );
}
add_action( 'after_setup_theme', 'firsttheme_setup' );
function firsttheme_setup(){
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'custom-logo', [
    'height'      => 190,
	'width'       => 190,
	'flex-width'  => false,
	'flex-height' => false,
	'header-text' => '',
	'unlink-homepage-logo' => false,
    ] );
    register_nav_menus(
        array(
            'header' => 'Primary',
        )
    );
}
add_action( 'after_setup_theme', 'gutenberg_setup_theme' );
function gutenberg_setup_theme(){
	add_theme_support( 'editor-styles' );                   
}
add_action('init', 'my_custom_init');
function my_custom_init(){
	register_taxonomy( 'mark', [ 'mark' ], [
		'label'                 => 'mark',
		'labels'                => array(
			'name'              => 'Марка',
			'singular_name'     => 'Марка',
			'search_items'      => 'Искать марку',
			'all_items'         => 'Все марки',
			'parent_item'       => 'Родит. марка',
			'parent_item_colon' => 'Родит. марка:',
			'edit_item'         => 'Ред. марку',
			'update_item'       => 'Обновить марка',
			'add_new_item'      => 'Добавить марку',
			'new_item_name'     => 'Новая марка',
			'menu_name'         => 'Марки',
		),
		'description'           => 'Марки автомобилей',
		'public'                => true,
		'show_in_nav_menus'     => false,
		'show_ui'               => true,
		'show_tagcloud'         => false,
		'hierarchical'          => true,
		'rewrite'               => array('slug'=>'marks', 'hierarchical'=>false, 'with_front'=>false, 'feed'=>false ),
		'show_admin_column'     => true,
	] );
	register_taxonomy( 'country', [ 'country' ], [
		'label'                 => 'Страна производитель',
		'labels'                => array(
			'name'              => 'Страна производитель',
			'singular_name'     => 'Страна производитель',
			'search_items'      => 'Искать Страну производителя',
			'all_items'         => 'Все Страны производители',
			'parent_item'       => 'Родит. Страна производитель',
			'parent_item_colon' => 'Родит. Страна производитель:',
			'edit_item'         => 'Ред. Страну производителя',
			'update_item'       => 'Обновить Страну производителя',
			'add_new_item'      => 'Добавить Страну производителя',
			'new_item_name'     => 'Новая Страна производитель',
			'menu_name'         => 'Страна производитель',
		),
		'description'           => 'Страна производитель автоиобиля',
		'public'                => true,
		'show_in_nav_menus'     => false,
		'show_ui'               => true,
		'show_tagcloud'         => false,
		'hierarchical'          => true,
		'rewrite'               => array('slug'=>'country', 'hierarchical'=>false, 'with_front'=>false, 'feed'=>false ),
		'show_admin_column'     => true,
	] );
	register_post_type('car', array(
		'labels'             => array(
			'name'               => 'Car',
			'singular_name'      => 'Car',
			'add_new'            => 'Add new Car',
			'add_new_item'       => 'Add new Car',
			'edit_item'          => 'Edit Car',
			'new_item'           => 'New Car',
			'view_item'          => 'View Car',
			'search_items'       => 'Search Car',
			'not_found'          => 'Car not found',
			'not_found_in_trash' => 'Car not found in trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Car'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => '6',
        'menu_icon'          => 'dashicons-car',   
		'supports'           => array('title','editor','thumbnail','comments','custom-fields'),
		'taxonomies'          => array( 'mark','country' ),
	) );
}
function wporg_add_fuel_box() {
    $screens = [ 'car' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_fuel_id',
            'Выбор топлива',
            'wporg_fuel_box_html',
            $screen
        );
    }
}
function wporg_fuel_box_html( $post ) {
    $fuels_list = array('80', '92', '95', '95+', '98', '100');
    $fuel = get_post_meta( $post->ID, '_wporg_fuel_meta_key', true );
    ?>
    <label for="wporg_fuel">Топливо</label>
    <select name="wporg_fuel" id="wporg_fuel" class="postbox">
        <?php foreach( $fuels_list as $fuel_item): ?>
            <option value="<?php echo $fuel_item; ?>" <?php selected( $fuel, $fuel_item ); ?>><?php echo $fuel_item; ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}
add_action( 'add_meta_boxes', 'wporg_add_fuel_box' );
function wporg_save_fuel_postdata( $post_id ) {
    if ( array_key_exists( 'wporg_fuel', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_fuel_meta_key',
            $_POST['wporg_fuel']
        );
    }
}
add_action( 'save_post', 'wporg_save_fuel_postdata' );
function wporg_add_colorpicker_box() {
    $screens = [ 'car' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_color_id',
            'Выберите цвет',
            'wporg_custom_colorpicker_html',
            $screen
        );
    }
}
function wporg_custom_colorpicker_html( $post ) {
    $color = get_post_meta( $post->ID, '_wporg_color_meta_key', true );
    ?>
    <label for="wporg_color">Цвет</label>
		<input name="wporg_color" class="postbox" type="color" id="wporg_color" value="<?php echo $color ?>">
    <?php
}
add_action( 'add_meta_boxes', 'wporg_add_colorpicker_box' );
function wporg_save_color_postdata( $post_id ) {
    if ( array_key_exists( 'wporg_color', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_color_meta_key',
            $_POST['wporg_color']
        );
    }
}
add_action( 'save_post', 'wporg_save_color_postdata' );
function wporg_add_power_box() {
    $screens = [ 'car' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_power_id',
            'Мощность',
            'wporg_power_box_html',
            $screen
        );
    }
}
function wporg_power_box_html( $post ) {
    $power = get_post_meta( $post->ID, '_wporg_power_meta_key', true );
    ?>
    <label for="wporg_power">Мощность</label>
        <input type="number" name="wporg_power" id="wporg_power" class="postbox" value="<?php echo $power ?>">
    <?php
}
add_action( 'add_meta_boxes', 'wporg_add_power_box' );
function wporg_save_power_postdata( $post_id ) {
    if ( array_key_exists( 'wporg_power', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_power_meta_key',
            $_POST['wporg_power']
        );
    }
}
add_action( 'save_post', 'wporg_save_power_postdata' );
function wporg_add_price_box() {
    $screens = [ 'car' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_price_id',
            'Цена',
            'wporg_price_box_html',
            $screen
        );
    }
}
function wporg_price_box_html( $post ) {
    $price = get_post_meta( $post->ID, '_wporg_price_meta_key', true );
    ?>
    <label for="wporg_price">Цена</label>
        <input type="number" name="wporg_price" id="wporg_price" class="postbox" value="<?php echo $price ?>">
    <?php
}
add_action( 'add_meta_boxes', 'wporg_add_price_box' );
function wporg_save_price_postdata( $post_id ) {
    if ( array_key_exists( 'wporg_price', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_price_meta_key',
            $_POST['wporg_price']
        );
    }
}
add_action( 'save_post', 'wporg_save_price_postdata' );

add_action( 'customize_register', 'customizer_init' );
function customizer_init( WP_Customize_Manager $wp_customize ){
	$transport = 'postMessage';
	if( $section = 'display_options' ){
		$wp_customize->add_section( $section, [
			'title'     => 'Настройки',
			'priority'  => 200,
			'description' => 'Настройка параметров',
		] );

		$setting = 'telephone';
		$wp_customize->add_setting( $setting, [
			'default'            => '+380',
			'sanitize_callback'  => 'sanitize_text_field',
			'transport'          => $transport
		] );
		$wp_customize->add_control( $setting, [
			'section'  => 'display_options',
			'label'    => 'Телефон',
			'type'     => 'text'
		] );

	}

}

add_shortcode( 'car_list', 'car_list_func' );

function car_list_func( ){
	$query = new WP_Query( array('post_type' => 'car', 'post__per_page' => 10) );
	$html = '';
	if ( $query->have_posts() ) {
		$html .= '<ul>';
		while ( $query->have_posts() ) {
			$query->the_post();
			$html .=  '<li>' . get_the_title() . '</li>';
		} 
		$html .= '</ul>';
	}
	wp_reset_postdata();
	return $html;
}
?>