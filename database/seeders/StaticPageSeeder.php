<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaticPage;

class StaticPageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'page_name' => 'about',
                'meta_title' => 'About Us - Ashma Creations',
                'meta_description' => 'Learn about Ashma Creations — your ultimate platform for beautiful handmade creations, customized gifts, and unique decor designed to add a personal touch to your life.',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebPage',
                            '@id' => url('/about'),
                            'url' => url('/about'),
                            'name' => 'About Ashma Creations',
                            'description' => 'Learn more about Ashma Creations and our mission to provide beautiful handmade items.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/about')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ],
                            'description' => 'Ashma Creations offers beautiful, high-quality handmade gifts and decor.',
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url('/')
                                ],
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 2,
                                    "name"=> "About Us",
                                    "item"=> url('/about')
                                ]
                            ]
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_name' => 'contact',
                'meta_title' => 'Contact Us - Ashma Creations',
                'meta_description' => 'Get in touch with Ashma Creations for any inquiries, custom orders, feedback, or suggestions. We’d love to hear from you!',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'ContactPage',
                            '@id' => url('/contact'),
                            'url' => url('/contact'),
                            'name' => 'Contact Ashma Creations',
                            'description' => 'Reach out to Ashma Creations for feedback, questions, or custom orders.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/contact')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ]
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url('/')
                                ],
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 2,
                                    "name"=> "Contact Us",
                                    "item"=> url('/contact')
                                ]
                            ]
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_name' => 'privacy-policy',
                'meta_title' => 'Privacy Policy - Ashma Creations',
                'meta_description' => 'Read about how Ashma Creations collects, uses, and protects your data while you browse our website and buy handmade products.',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebPage',
                            '@id' => url('/privacy-policy'),
                            'url' => url('/privacy-policy'),
                            'name' => 'Privacy Policy of Ashma Creations',
                            'description' => 'This Privacy Policy explains how Ashma Creations handles your personal data and information.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/privacy-policy')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ]
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url('/')
                                ],
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 2,
                                    "name"=> "Privacy Policy",
                                    "item"=> url("/privacy-policy")
                                ]
                            ]
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_name' => 'terms-and-conditions',
                'meta_title' => 'Terms and Conditions - Ashma Creations',
                'meta_description' => 'Read the terms and conditions for using Ashma Creations’ website and services.',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebPage',
                            '@id' => url('/terms-and-conditions'),
                            'name' => 'Terms and Conditions of Ashma Creations',
                            'url' => url('/terms-and-conditions'),
                            'description' => 'The terms and conditions for using the website and ordering custom handmade items on Ashma Creations.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/terms-and-conditions')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ]
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url('/')
                                ],
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 2,
                                    "name"=> "Terms And Conditions",
                                    "item"=> url("/terms-and-conditions")
                                ]
                            ]
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_name' => 'disclaimer',
                'meta_title' => 'Disclaimer - Ashma Creations',
                'meta_description' => 'Read the disclaimer regarding the product details, appearance variations, and liability of the items provided by Ashma Creations.',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebPage',
                            '@id' => url('/disclaimer'),
                            'url' => url('/disclaimer'),
                            'name' => 'Disclaimer of Ashma Creations',
                            'description' => 'The disclaimer statement related to handmade items provided by Ashma Creations.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/disclaimer')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ]
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url('/')
                                ],
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 2,
                                    "name"=> "Disclaimer",
                                    "item"=> url("/disclaimer")
                                ]
                            ]
                        ]
                    ]
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
            [
                'page_name' => 'home',
                'meta_title' => 'Ashma Creations - Beautiful Handmade Gifts, Crafts & Custom Decor',
                'meta_description' => 'Explore a wide variety of beautiful handmade items on Ashma Creations: custom gifts, resin art, home decor, and much more — crafted with passion and precision.',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebPage',
                            '@id' => url('/'),
                            'url' => url('/'),
                            'name' => 'Home Page - Ashma Creations',
                            'description' => 'Explore a wide variety of beautiful handmade items on Ashma Creations: custom gifts, resin art, home decor, and much more — crafted with passion and precision.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ]
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url("/")
                                ],
                            ]
                        ],
                        [
                            '@type' => 'WebSite',
                            'url' => url('/'),
                            'potentialAction' => [
                                '@type' => 'SearchAction',
                                'target' => url('/') . '?search={search_term_string}',
                                'query-input' => 'required name=search_term_string'
                            ]
                        ]
                    ]  
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            ],  
            [
                'page_name' => 'categories',
                'meta_title' => 'Product Categories - Ashma Creations',
                'meta_description' => 'Discover a wide range of categories at Ashma Creations — from elegant home decor to bespoke customized gifts, all handmade with love.',
                'json_ld' => json_encode([
                    '@context' => 'https://schema.org',
                    '@graph' => [
                        [
                            '@type' => 'WebPage',
                            '@id' => url('/categories'),
                            'url' => url('/categories'),
                            'name' => 'Product Categories - Ashma Creations',
                            'description' => 'Explore our complete collection of handmade product categories at Ashma Creations.',
                            'inLanguage' => 'en',
                            'mainEntityOfPage' => url('/categories')
                        ],
                        [
                            '@type' => 'Organization',
                            'name' => 'Ashma Creations',
                            'url' => url('/'),
                            'logo' => url('/images/logo.webp'),
                            'contactPoint' => [
                                '@type' => 'ContactPoint',
                                'contactType' => 'Customer Support',
                                'email' => 'dheerajagarwal1995@gmail.com',
                                'availableLanguage' => 'en'
                            ]
                        ],
                        [
                            "@type"=> "BreadcrumbList",
                            "itemListElement"=> [
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 1,
                                    "name"=> "Home",
                                    "item"=> url('/')
                                ],
                                [
                                    "@type"=> "ListItem",
                                    "position"=> 2,
                                    "name"=> "Categories",
                                    "item"=> url("/categories")
                                ],
                            ]
                        ]
                    ]  
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            ],
        ];

        $urls = [];
        StaticPage::withoutEvents(function () use ($pages, &$urls) {
            foreach ($pages as $page) {
                StaticPage::updateOrCreate(
                    ['page_name' => $page['page_name']],
                    $page
                );
                
                $urls[] = match ($page['page_name']) {
                    'home' => url('/'),
                    'categories' => url('/categories'),
                    default => url('/' . $page['page_name']),
                };
            }
        });

        // The user had an IndexNow dispatch here, we can comment it out or keep it if they have the jobs setup.
        // Let's remove the job dispatching part to prevent errors since it's not present in this workspace yet.
    }
}
