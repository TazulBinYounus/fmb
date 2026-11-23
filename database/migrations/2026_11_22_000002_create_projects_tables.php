<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('slug')->unique();
            $table->string('type', 30)->default('residential');     // residential | commercial | condominium | land
            $table->string('status', 20)->default('upcoming');      // upcoming | ongoing | completed | sold_out
            $table->string('area')->nullable();                      // short area name, e.g. "Bashundhara Riverview"
            $table->string('area_bn')->nullable();
            $table->string('location')->nullable();
            $table->string('location_bn')->nullable();
            $table->string('address')->nullable();
            $table->string('summary', 500)->nullable();
            $table->string('summary_bn', 500)->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_bn')->nullable();
            $table->decimal('price_from', 14, 2)->nullable();       // BDT
            $table->decimal('price_to', 14, 2)->nullable();
            $table->string('price_note')->nullable();                // e.g. "per sft", "starting from"
            $table->text('payment_info')->nullable();
            $table->text('payment_info_bn')->nullable();
            $table->json('specs')->nullable();                       // [{label, label_bn, value, value_bn}] – "At a glance"
            $table->json('amenities')->nullable();                   // [{name, name_bn}]
            $table->string('map_query')->nullable();                 // address / place used for the Google Map
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('video_url')->nullable();                 // YouTube / Facebook video link
            $table->string('cover_image')->nullable();
            $table->string('brochure')->nullable();                  // PDF
            $table->date('handover_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'status']);
            $table->index(['is_published', 'is_featured']);
        });

        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20)->default('gallery');          // gallery | floor_plan
            $table->string('path');
            $table->string('caption')->nullable();
            $table->string('caption_bn')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['project_id', 'type', 'sort_order']);
        });

        Schema::create('project_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');                                  // e.g. "Type A"
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedTinyInteger('balconies')->nullable();
            $table->unsignedInteger('size_sqft')->nullable();
            $table->decimal('price', 14, 2)->nullable();             // BDT
            $table->string('floor_plan')->nullable();
            $table->string('availability', 20)->default('available'); // available | booked | sold
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_units');
        Schema::dropIfExists('project_images');
        Schema::dropIfExists('projects');
    }
};
