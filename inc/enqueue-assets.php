<?php
/**
 * Enqueue all theme assets
 */

class Template_Theme_Assets {
    private $config;
    
    public function __construct() {
        $this->config = require_once get_template_directory() . '/inc/enqueue-config.php';
        
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
    }
    
    /**
     * Enqueue Styles
     */
    public function enqueue_styles() {
        // Theme blocks CSS
        $css_file = get_template_directory() . '/assets/dist/css/blocks.css';
        if ( file_exists( $css_file ) ) {
            wp_enqueue_style(
                'template-theme-blocks',
                get_template_directory_uri() . '/assets/dist/css/blocks.css',
                [],
                filemtime( $css_file )
            );
        }
        
        // Swiper CSS
        if ( $this->is_enabled( 'swiper' ) ) {
            $version = $this->config['swiper']['version'];
            wp_enqueue_style(
                'swiper',
                "https://cdn.jsdelivr.net/npm/swiper@{$version}/swiper-bundle.min.css",
                [],
                $version
            );
        }
        
        // Google Fonts
        if ( $this->is_enabled( 'google_fonts' ) ) {
            $this->enqueue_google_fonts();
        }
    }
    
    /**
     * Enqueue Scripts
     */
    public function enqueue_scripts() {
        // GSAP
        if ( $this->is_enabled( 'gsap' ) ) {
            $this->enqueue_gsap();
        }
        
        // Swiper
        if ( $this->is_enabled( 'swiper' ) ) {
            $this->enqueue_swiper();
        }
        
        // Custom Scripts from config
        $this->enqueue_custom_scripts();
        
        // Theme bundle JS (load last, after all dependencies)
        $js_file = get_template_directory() . '/assets/dist/js/bundle.js';
        if ( file_exists( $js_file ) ) {
            $deps = $this->get_js_dependencies();
            
            wp_enqueue_script(
                'template-theme-blocks',
                get_template_directory_uri() . '/assets/dist/js/bundle.js',
                $deps,
                filemtime( $js_file ),
                true
            );
            
            // Pass config to JS
            wp_localize_script( 'template-theme-blocks', 'themeConfig', [
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'template_theme_nonce' ),
                'gsapEnabled' => $this->is_enabled( 'gsap' ),
                'swiperEnabled' => $this->is_enabled( 'swiper' ),
            ]);
        }
    }
    
    /**
     * Enqueue Editor Assets
     */
    public function enqueue_editor_assets() {
        // Editor styles
        $css_file = get_template_directory() . '/assets/dist/css/blocks.css';
        if ( file_exists( $css_file ) ) {
            wp_enqueue_style(
                'template-theme-blocks-editor',
                get_template_directory_uri() . '/assets/dist/css/blocks.css',
                [],
                filemtime( $css_file )
            );
        }
        
        // Editor scripts (if needed)
        $js_file = get_template_directory() . '/assets/dist/js/bundle.js';
        if ( file_exists( $js_file ) ) {
            wp_enqueue_script(
                'template-theme-blocks-editor',
                get_template_directory_uri() . '/assets/dist/js/bundle.js',
                [ 'wp-blocks', 'wp-element', 'wp-editor' ],
                filemtime( $js_file ),
                true
            );
        }
    }
    
    /**
     * Enqueue GSAP and plugins
     */
    private function enqueue_gsap() {
        $version = $this->config['gsap']['version'];
        $plugins = $this->config['gsap']['plugins'];
        
        // GSAP Core
        wp_enqueue_script(
            'gsap',
            "https://cdn.jsdelivr.net/npm/gsap@{$version}/dist/gsap.min.js",
            [],
            $version,
            true
        );
        
        // GSAP Plugins
        if ( ! empty( $plugins['ScrollTrigger'] ) ) {
            wp_enqueue_script(
                'gsap-scroll-trigger',
                "https://cdn.jsdelivr.net/npm/gsap@{$version}/dist/ScrollTrigger.min.js",
                [ 'gsap' ],
                $version,
                true
            );
        }
        
        if ( ! empty( $plugins['ScrollToPlugin'] ) ) {
            wp_enqueue_script(
                'gsap-scroll-to',
                "https://cdn.jsdelivr.net/npm/gsap@{$version}/dist/ScrollToPlugin.min.js",
                [ 'gsap' ],
                $version,
                true
            );
        }
        
        if ( ! empty( $plugins['Draggable'] ) ) {
            wp_enqueue_script(
                'gsap-draggable',
                "https://cdn.jsdelivr.net/npm/gsap@{$version}/dist/Draggable.min.js",
                [ 'gsap' ],
                $version,
                true
            );
        }
        
        if ( ! empty( $plugins['MotionPathPlugin'] ) ) {
            wp_enqueue_script(
                'gsap-motion-path',
                "https://cdn.jsdelivr.net/npm/gsap@{$version}/dist/MotionPathPlugin.min.js",
                [ 'gsap' ],
                $version,
                true
            );
        }
    }
    
    /**
     * Enqueue Swiper
     */
    private function enqueue_swiper() {
        $version = $this->config['swiper']['version'];
        
        wp_enqueue_script(
            'swiper',
            "https://cdn.jsdelivr.net/npm/swiper@{$version}/swiper-bundle.min.js",
            [],
            $version,
            true
        );
    }
    
    /**
     * Enqueue Google Fonts
     */
    private function enqueue_google_fonts() {
        $families = $this->config['google_fonts']['families'];
        $display = $this->config['google_fonts']['display'] ?? 'swap';
        
        if ( empty( $families ) ) {
            return;
        }
        
        // Build Google Fonts URL
        $families_param = implode( '&family=', array_map( 'urlencode', $families ) );
        $font_url = "https://fonts.googleapis.com/css2?family={$families_param}&display={$display}";
        
        wp_enqueue_style(
            'template-theme-google-fonts',
            $font_url,
            [],
            null
        );
    }
    
    /**
     * Enqueue custom scripts from config
     */
    private function enqueue_custom_scripts() {
        if ( empty( $this->config['custom_scripts'] ) ) {
            return;
        }
        
        foreach ( $this->config['custom_scripts'] as $handle => $script ) {
            wp_enqueue_script(
                $handle,
                $script['src'],
                $script['deps'] ?? [],
                $script['version'] ?? null,
                $script['in_footer'] ?? true
            );
        }
    }
    
    /**
     * Get JS dependencies based on enabled libraries
     */
    private function get_js_dependencies() {
        $deps = [];
        
        if ( $this->is_enabled( 'gsap' ) ) {
            $deps[] = 'gsap';
            
            if ( ! empty( $this->config['gsap']['plugins']['ScrollTrigger'] ) ) {
                $deps[] = 'gsap-scroll-trigger';
            }
        }
        
        if ( $this->is_enabled( 'swiper' ) ) {
            $deps[] = 'swiper';
        }
        
        return $deps;
    }
    
    /**
     * Check if a library is enabled
     */
    private function is_enabled( $library ) {
        return ! empty( $this->config[ $library ]['enabled'] );
    }
}

// Initialize
new Template_Theme_Assets();