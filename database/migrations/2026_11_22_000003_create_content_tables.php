<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('subtitle_bn')->nullable();
            $table->string('image');
            $table->string('image_position', 30)->default('center');
            $table->string('button_text')->nullable();
            $table->string('button_text_bn')->nullable();
            $table->string('button_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->longText('content_bn')->nullable();
            $table->string('banner_image')->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('designation')->nullable();
            $table->string('designation_bn')->nullable();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->text('quote');
            $table->text('quote_bn')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category', 30)->default('general');      // general | real_estate | garments | landowner
            $table->string('question');
            $table->string('question_bn')->nullable();
            $table->text('answer');
            $table->text('answer_bn')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('location', 20)->default('header');      // header | footer
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->string('label');
            $table->string('label_bn')->nullable();
            $table->string('url');
            $table->boolean('open_in_new_tab')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['location', 'is_active', 'sort_order']);
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('original_name');
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('alt')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('garments');         // garments | property | site_visit | landowner | other
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 30);
            $table->string('company')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->json('details')->nullable();                     // preferred_date, land_location, land_size, …
            $table->string('status', 20)->default('new');            // new | contacted | closed
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 30);                            // created | updated | deleted | …
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('description');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('media');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('banners');
    }
};
