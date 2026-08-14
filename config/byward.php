<?php

/*
|--------------------------------------------------------------------------
| Byward Logistics — site configuration
|--------------------------------------------------------------------------
|
| Company details and the image library used across the site. Images point
| at Unsplash by default: drop your own photos in public/images and swap the
| values below to switch the whole site over to them.
|
*/

$unsplash = fn (string $id, int $w = 1600, string $crop = 'entropy') => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&crop={$crop}&w={$w}&q=72";

return [

    'company' => [
        'name' => 'Byward Logistics',
        'phone' => '(613) 501-0653',
        'phone_href' => '+16135010653',
        'email' => 'info@bywardlogistics.com',
        'founded' => 2014,
    ],

    'social' => [
        'facebook' => 'https://www.facebook.com/share/1CX3134jZ7/?mibextid=wwXIfr',
        'instagram' => 'https://www.instagram.com/bywardlogistics?igsh=MW51bHJvdGtqbHB5ZQ==',
        'linkedin' => 'https://www.linkedin.com/company/byward-logistics/',
    ],

    'images' => [
        'hero'            => '/images/banner.jpeg',
        'hero_services'   => $unsplash('1586528116311-ad8dd3c8310d', 1800),
        'hero_industries' => $unsplash('1565793298595-6a879b1d9492', 1800),
        'hero_about'      => $unsplash('1553413077-190dd305871c', 1800),
        'hero_faq'        => $unsplash('1504328345606-18bbc8c9d7d1', 1800),
        'hero_contact'    => $unsplash('1600880292203-757bb62b4baf', 1800),
        'hero_quote'      => $unsplash('1494412574643-ff11b0a5c1c3', 1800),

        'why'             => $unsplash('1601584115197-04ecc0da31d7', 1100),
        'why_alt'         => $unsplash('1578575437130-527eed3abbec', 900),
        'estimate_teaser' => $unsplash('1595246140625-573b715d11dc', 1200),
        'about_team'      => $unsplash('1521737711867-e3b97375f902', 1100),
        'about_ops'       => $unsplash('1566576912321-d58ddd7a6088', 900),
        'approach'        => $unsplash('1494412574643-ff11b0a5c1c3', 1100),

        'service_freight'   => $unsplash('1553413077-190dd305871c', 1000),
        'service_warehouse' => $unsplash('1601584115197-04ecc0da31d7', 1000),
        'service_lastmile'  => $unsplash('1587293852726-70cdb56c2866', 1000),
        'service_supply'    => $unsplash('1586528116311-ad8dd3c8310d', 1000),
        'service_customs'   => $unsplash('1504328345606-18bbc8c9d7d1', 1000),
        'service_reverse'   => $unsplash('1566576912321-d58ddd7a6088', 1000),
        'service_whiteglove'=> '/images/Glove.jpeg',

        'industry_retail'        => $unsplash('1565043666747-69f6646db940', 900),
        'industry_healthcare'    => $unsplash('1532187863486-abf9dbad1b69', 900),
        'industry_manufacturing' => $unsplash('1565793298595-6a879b1d9492', 900),
        'industry_automotive'    => $unsplash('1486262715619-67b85e0b08d3', 900),
        'industry_food'          => $unsplash('1542838132-92c53300491e', 900),
        'industry_technology'    => $unsplash('1581091226825-a6a2a5aee158', 900),
        'industry_construction'  => $unsplash('1541888946425-d81bb19240f5', 900),
        'industry_energy'        => $unsplash('1466611653911-95081537e5b7', 900),
    ],

    /*
    | Indicative pricing model behind the instant estimate. Rates are per
    | kilogram, per shipping method, plus a flat handling fee.
    */
    'estimate' => [
        'base_fee' => 45.0,
        'methods' => [
            'road_ltl'  => ['rate' => 1.35, 'min' => 95,  'days' => [3, 6]],
            'road_ftl'  => ['rate' => 0.95, 'min' => 480, 'days' => [2, 4]],
            'express'   => ['rate' => 4.20, 'min' => 180, 'days' => [1, 2]],
            'air'       => ['rate' => 6.40, 'min' => 260, 'days' => [2, 4]],
            'sea'       => ['rate' => 0.55, 'min' => 320, 'days' => [18, 32]],
            'rail'      => ['rate' => 0.78, 'min' => 210, 'days' => [6, 11]],
        ],
        'currency' => 'USD',
    ],
];
