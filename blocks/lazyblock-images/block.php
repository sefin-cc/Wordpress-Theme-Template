<?php
/**
 * Hero Banner Lazy Block Template
 *
 * @package template-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$header         = $attributes['header'] ?? '';
$paragraph      = $attributes['paragraph'] ?? '';
$image_repeater = $attributes['image-repeater'] ?? [];
?>

<div class="container">


    <?php if ( $header ) : ?>
        <h1 class="title_text"><?php echo esc_html( $header ); ?></h1>
    <?php endif; ?>

    <?php if ( ! empty( $image_repeater ) ) : ?>
        <div class="my-repeater-block">
            <?php foreach ( $image_repeater as $item ) : ?>

                <div class="repeater-item">

                    <?php if ( ! empty( $item['label-image'] ) ) : ?>
                        <h3><?php echo esc_html( $item['label-image'] ); ?></h3>
                    <?php endif; ?>

                    <?php if ( ! empty( $item['image']['url'] ) ) : ?>
                        <img 
                            src="<?php echo esc_url( $item['image']['url'] ); ?>"
                            alt="<?php echo esc_attr( $item['image']['alt'] ?? '' ); ?>"
                        >
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ( $paragraph ) : ?>
        <p class="body_text"><?php echo esc_html( $paragraph ); ?></p>
    <?php endif; ?>

</div>


