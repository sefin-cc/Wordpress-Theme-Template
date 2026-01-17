<?php
function template_theme_enqueue_blocks_css() {
    $css_file = get_template_directory() . '/assets/css/blocks.css';
    if ( file_exists( $css_file ) ) {
        wp_enqueue_style(
            'template-theme-blocks',
            get_template_directory_uri() . '/assets/css/blocks.css',
            [],
            filemtime( $css_file )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'template_theme_enqueue_blocks_css' );
add_action( 'enqueue_block_editor_assets', 'template_theme_enqueue_blocks_css' );
