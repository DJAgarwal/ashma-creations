<?php 

namespace Database\Seeders;

use App\Models\StaticPage;
use App\Services\SchemaGenerator;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'page_name' => 'home',
                'schema_type' => 'homepage',
                'meta_title' => 'Handmade Gifts, Crafts & Personalized Creations | Ashma Creations',
                'meta_description' => 'Discover unique handmade gifts, personalized creations, home decor and thoughtful keepsakes at Ashma Creations. Beautifully handcrafted with creativity and care for every special moment.',
            ],
            [
                'page_name' => 'about',
                'schema_type' => 'about',
                'meta_title' => 'About Us - Ashma Creations',
                'meta_description' => 'Learn about Ashma Creations — your ultimate platform for beautiful handmade creations, customized gifts, and unique decor designed to add a personal touch to your life.',
            ],
            [
                'page_name' => 'contact',
                'schema_type' => 'contact',
                'meta_title' => 'Contact Us - Ashma Creations',
                'meta_description' => 'Get in touch with Ashma Creations for any inquiries, custom orders, feedback, or suggestions. We’d love to hear from you!',
            ],
            [
                'page_name' => 'faq',
                'schema_type' => 'faq',
                'meta_title' => 'Frequently Asked Questions (FAQ) - Ashma Creations',
                'meta_description' => 'Find answers to common questions about Ashma Creations handmade pipe cleaner flowers, custom orders, care instructions, shipping, and returns.',
            ],
            [
                'page_name' => 'privacy-policy',
                'schema_type' => 'webpage',
                'meta_title' => 'Privacy Policy - Ashma Creations',
                'meta_description' => 'Read about how Ashma Creations collects, uses, and protects your data while you browse our website and buy handmade products.',
            ],
            [
                'page_name' => 'terms-and-conditions',
                'schema_type' => 'webpage',
                'meta_title' => 'Terms and Conditions - Ashma Creations',
                'meta_description' => 'Read the terms and conditions for using Ashma Creations’ website and services.',
            ],
            [
                'page_name' => 'disclaimer',
                'schema_type' => 'webpage',
                'meta_title' => 'Disclaimer - Ashma Creations',
                'meta_description' => 'Read the disclaimer regarding the product details, appearance variations, and liability of the items provided by Ashma Creations.',
            ],
            [
                'page_name' => 'categories',
                'schema_type' => 'webpage',
                'meta_title' => 'Product Categories - Ashma Creations',
                'meta_description' => 'Discover a wide range of categories at Ashma Creations — from elegant home decor to bespoke customized gifts, all handmade with love.',
            ],
        ];

        StaticPage::withoutEvents(function () use ($pages) {
            foreach ($pages as $pageData) {
                // Create temporary model instance to compute JSON-LD via SchemaGenerator
                $tempModel = new StaticPage($pageData);
                $pageData['json_ld'] = SchemaGenerator::forStaticPage($tempModel);

                StaticPage::updateOrCreate(
                    ['page_name' => $pageData['page_name']],
                    $pageData
                );
            }
        });
    }
}
