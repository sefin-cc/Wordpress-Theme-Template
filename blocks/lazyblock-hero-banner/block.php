<?php
/**
 * Hero Banner Lazy Block Template
 *
 * @package template-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$title    = isset($attributes['title']) ? $attributes['title'] : '';
$paragraph = isset($attributes['paragraph']) ? $attributes['paragraph'] : '';
$image     = isset($attributes['image']) ? $attributes['image'] : '';

// For image, get URL if it's an array
$image_url = '';
if (is_array($image) && isset($image['url'])) {
    $image_url = esc_url($image['url']);
} elseif (is_string($image)) {
    $image_url = esc_url($image);
}
?>

<section class="hero-banner" <?php echo esc_attr(get_block_wrapper_attributes()); ?>>
    <?php if ( $title ) : ?>
        <h1 class="hero-banner-header"><?php echo esc_html($title); ?></h1>
    <?php endif; ?>

    <?php if ( $paragraph ) : ?>
        <p><?php echo esc_html($paragraph); ?></p>
    <?php endif; ?>

    <?php if ( $image ) : ?>
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
    <?php endif; ?>
</section>
