<?php
/**
 * Asset Configuration
 * Enable/disable third-party libraries here
 */

return [
    'gsap' => [
        'enabled' => true,
        'version' => '3.12.5',
        'plugins' => [
            'ScrollTrigger' => true,
            'ScrollToPlugin' => false,
            'Draggable' => false,
            'MotionPathPlugin' => false,
        ]
    ],
    'swiper' => [
        'enabled' => true,
        'version' => '11.0.5',
        'modules' => ['navigation', 'pagination', 'autoplay'] 
    ],
    'google_fonts' => [
        'enabled' => true,
        'families' => [
            'Inter:wght@400;500;600;700',
            'Playfair Display:wght@400;700',
        ],
        'display' => 'swap' // optional, fallback, block, swap, auto
    ],
    'custom_scripts' => [
        // Add your own custom scripts here
        // 'handle' => [
        //     'src' => 'https://cdn.example.com/library.js',
        //     'version' => '1.0.0',
        //     'deps' => [],
        //     'in_footer' => true
        // ]
    ]
];