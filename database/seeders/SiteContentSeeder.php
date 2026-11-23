<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Imports the website content that used to be hard-coded in the views
 * (contact details, menus, banners, the Bashundhara Riverview project, About page)
 * into the database so it can be managed from the admin panel.
 * Safe to run more than once: existing records are left untouched.
 */
class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->menus();
        $this->banners();
        $this->project();
        $this->pages();
    }

    /** Bangla translation of an English string from lang/bn.json (null if none). */
    private function bn(string $text): ?string
    {
        $translated = trans($text, [], 'bn');

        return $translated !== $text ? $translated : null;
    }

    private function settings(): void
    {
        $values = [
            'site_name' => 'FMB Group',
            'phone' => '+8801612149719',
            'phone_display' => '+880 1612-149719',
            'whatsapp' => '8801612149719',
            'email' => 'info@fmbgroupbd.com',
            'real_estate_phone' => '+8801312149719',
            'real_estate_phone_display' => '01312-149719',
            'real_estate_email' => 'fmb@fmbgroupbd.com',
            'address_line1' => '174, East Dholipar, Jatrabari',
            'address_line2' => 'Dhaka 1204, Bangladesh',
            'office_hours' => 'Sat – Thu, 9:00 AM – 6:00 PM (BST)',
            'map_query' => 'East Dholipar, Jatrabari, Dhaka 1204, Bangladesh',
            'facebook_url' => 'https://www.facebook.com/fmbdevelopmentsltd',
            'messenger_url' => 'https://m.me/fmbdevelopmentsltd',
            'linkedin_url' => '',
            'youtube_url' => '',
            'instagram_url' => '',
            'seo_title' => 'Garments Sourcing & Real Estate in Dhaka, Bangladesh',
            'seo_description' => 'FMB Group, Dhaka: garments buying house for knit, woven, sweater and home textile, and FMB Developments Ltd for apartments and real estate in Dhaka.',
            'seo_keywords' => 'FMB Group, FMB Developments Ltd, flat sale Dhaka, apartment Bashundhara Riverview, real estate developer Dhaka, garments buying house Bangladesh, buying house Dhaka, knit garments Bangladesh, woven garments, sweater manufacturer Bangladesh, home textile Bangladesh',
            'og_image' => 'assets/images/banner/banner-factory.jpg',
            'footer_about' => 'FMB Group is a Dhaka-based business group in garments buying & sourcing and, through FMB Developments Ltd, real estate development.',
            'home_about_title' => 'Who we are',
            'home_about_subtitle' => 'Delivering top-quality products at competitive prices',
            'home_about_lead' => 'FMB Group, located in Dhaka, Bangladesh',
            'home_about_text' => "FMB Group, based in Dhaka, Bangladesh, is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items. We collaborate with trusted factories to ensure that every product meets our standards of quality and style. From initial production planning to regular communication and updates with our clients, we handle all stages of the process, including in-line inspections, shipping schedule management, and final dispatch of documents.\n\nWith a dedicated team of experienced professionals, FMB Group is committed to delivering top-quality products at competitive prices. We believe that building long-term success requires trust, reliability, and consistently meeting client expectations.",
            'home_about_image' => 'assets/images/banner/banner-qc.jpg',
            'home_cta_title' => 'Planning your next order?',
            'home_cta_text' => 'Send us your tech pack or sample and we will get back to you with a quotation.',
            'home_show_featured_projects' => '1',
            'home_show_testimonials' => '1',
            'home_show_faqs' => '1',
        ];

        $translatable = ['office_hours', 'address_line1', 'address_line2', 'seo_title', 'seo_description', 'footer_about',
            'home_about_title', 'home_about_subtitle', 'home_about_lead', 'home_cta_title', 'home_cta_text'];

        foreach ($translatable as $key) {
            $values[$key.'_bn'] = $this->bn($values[$key]);
        }
        $values['home_about_text_bn'] = implode("\n\n", array_filter([
            $this->bn('FMB Group, based in Dhaka, Bangladesh, is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items. We collaborate with trusted factories to ensure that every product meets our standards of quality and style. From initial production planning to regular communication and updates with our clients, we handle all stages of the process, including in-line inspections, shipping schedule management, and final dispatch of documents.'),
            $this->bn('With a dedicated team of experienced professionals, FMB Group is committed to delivering top-quality products at competitive prices. We believe that building long-term success requires trust, reliability, and consistently meeting client expectations.'),
        ]));

        foreach ($values as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    private function menus(): void
    {
        if (MenuItem::exists()) {
            return;
        }

        $add = function (string $location, string $label, string $url, ?int $parent = null, int $order = 0) {
            return MenuItem::create([
                'location' => $location, 'parent_id' => $parent, 'label' => $label,
                'label_bn' => $this->bn($label), 'url' => $url, 'sort_order' => $order,
            ]);
        };

        // Header
        $add('header', 'Home', '/', null, 1);
        $garments = $add('header', 'Garments', '#', null, 2);
        $knit = $add('header', 'KNIT', '#', $garments->id, 1);
        $add('header', 'MEN', '/collection/men-knit', $knit->id, 1);
        $add('header', 'WOMEN', '/collection/women-knit', $knit->id, 2);
        $add('header', 'KIDS', '/collection/kid-knit', $knit->id, 3);
        $add('header', 'WOVEN', '/contact', $garments->id, 2);
        $add('header', 'SWEATER', '/contact', $garments->id, 3);
        $add('header', 'HOME TEXTILE', '/collection/home-tex', $garments->id, 4);
        $add('header', 'Sourcing Services', '/garments/services', $garments->id, 5);
        $realEstate = $add('header', 'Real Estate', '/development', null, 3);
        $add('header', 'About FMB Developments', '/development', $realEstate->id, 1);
        $add('header', 'Our Projects', '/development/projects', $realEstate->id, 2);
        $add('header', 'Landowners', '/landowners', $realEstate->id, 3);
        $add('header', 'About Us', '/about', null, 4);
        $add('header', 'Our Management', '/our-management', null, 5);
        $add('header', 'Contact', '/contact', null, 6);

        // Footer quick links
        $add('footer', 'Home', '/', null, 1);
        $add('footer', 'Our Collection', '/collection/men-knit', null, 2);
        $add('footer', 'Sourcing Services', '/garments/services', null, 3);
        $add('footer', 'FMB Developments (Real Estate)', '/development', null, 4);
        $add('footer', 'Our Projects', '/development/projects', null, 5);
        $add('footer', 'Our Management', '/our-management', null, 6);
        $add('footer', 'Contact', '/contact', null, 7);
    }

    private function banners(): void
    {
        if (Banner::exists()) {
            return;
        }

        $slides = [
            ['FMB GROUP', 'Knit, Woven & Sweater Sourcing from Bangladesh', 'assets/images/banner/banner-factory.jpg', 'center', 'Request a Quote', '/contact'],
            ['FMB DEVELOPMENTS', 'Premium Apartments in Dhaka', 'assets/images/banner/banner-dhaka.jpg', 'center bottom', 'View Projects', '/development'],
            ['FMB GROUP', 'Quality Checked at Every Stage', 'assets/images/banner/banner-qc.jpg', 'center top', 'Request a Quote', '/contact'],
        ];

        foreach ($slides as $i => [$title, $subtitle, $image, $position, $button, $link]) {
            Banner::create([
                'title' => $title,
                'subtitle' => $subtitle, 'subtitle_bn' => $this->bn($subtitle),
                'image' => $image, 'image_position' => $position,
                'button_text' => $button, 'button_text_bn' => $this->bn($button),
                'button_link' => $link, 'is_active' => true, 'sort_order' => $i + 1,
            ]);
        }
    }

    private function project(): void
    {
        if (Project::withTrashed()->where('slug', 'bashundhara-riverview')->exists()) {
            return;
        }

        $specLabels = ['RAJUK approval', 'Land area', 'Storeys', 'Facing', 'No. of flats', 'Flat size', 'Bedrooms', 'Car parking', 'Handover'];

        Project::create([
            'name' => 'FMB Project – Bashundhara Riverview',
            'name_bn' => $this->bn('FMB Project – Bashundhara Riverview'),
            'slug' => 'bashundhara-riverview',
            'type' => 'residential',
            'status' => 'upcoming',
            'area' => 'Bashundhara Riverview',
            'area_bn' => $this->bn('Bashundhara Riverview'),
            'location' => 'Bashundhara Riverview Residential Area, Dhaka',
            'location_bn' => $this->bn('Bashundhara Riverview Residential Area, Dhaka'),
            'summary' => 'Residential apartments for sale. Register your interest now to get details first.',
            'summary_bn' => $this->bn('Residential apartments for sale. Register your interest now to get details first.'),
            'map_query' => 'Bashundhara Riverview Residential Area, Dhaka',
            'cover_image' => 'assets/images/background/5.jpg',
            // Labels only: values are added in the admin panel; empty values show "To be announced".
            'specs' => array_map(fn ($label) => ['label' => $label, 'label_bn' => $this->bn($label), 'value' => '', 'value_bn' => ''], $specLabels),
            'amenities' => [],
            'is_featured' => true,
            'is_published' => true,
            'sort_order' => 1,
            'seo_description' => 'FMB Developments Ltd, a concern of FMB Group, builds and sells apartments in Dhaka. Upcoming project in Bashundhara Riverview Residential Area. Call 01312-149719.',
        ]);
    }

    private function pages(): void
    {
        $about = <<<'HTML'
<p>FMB Group is a Dhaka-based business group with two businesses: garments buying &amp; sourcing, and real estate development through FMB Developments Ltd.</p>
<h3>Garments</h3>
<p>FMB Group is a garments buying and trading house specializing in the manufacturing, export, and sourcing of high-quality sweaters, woven, and knit items. We collaborate with trusted factories to ensure that every product meets our standards of quality and style, and we handle every stage from production planning to in-line inspections, shipping schedules and final dispatch of documents.</p>
<h3>Real estate</h3>
<p>FMB Developments Ltd is the real estate concern of FMB Group, headquartered in Jatrabari, Dhaka. We develop residential buildings and apartments for families who want a safe, well-built home in a good neighbourhood. From land selection and design approval to construction and handover, we manage every step and keep buyers informed throughout.</p>
HTML;

        Page::firstOrCreate(['slug' => 'about'], [
            'title' => 'About Us',
            'title_bn' => 'আমাদের সম্পর্কে',
            'content' => $about,
            'is_published' => true,
            'seo_description' => 'About FMB Group, Dhaka: garments buying & sourcing and real estate development through FMB Developments Ltd.',
        ]);

        Page::firstOrCreate(['slug' => 'contact'], [
            'title' => 'Contact Us',
            'title_bn' => $this->bn('Contact Us'),
            'content' => '<p>Tell us about the product, quantity and target price. Our merchandising team will get back to you soon (Saturday – Thursday).</p>',
            'content_bn' => '<p>'.$this->bn('Tell us about the product, quantity and target price. Our merchandising team will get back to you soon (Saturday – Thursday).').'</p>',
            'is_published' => true,
        ]);
    }
}
