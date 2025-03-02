<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512);
            $table->string('provider_id');
            $table->foreignIdFor(\App\Models\Category::class)->constrained();
            $table->char('source', '20');
            $table->string('url', 2048);
            $table->timestamp('published_at');
            $table->timestamps();


            //define full text index to search more efficient
            //due to using test in sqlite we should ignore it, it has some better solution
            if (config('database.default') !== 'sqlite') {
                $table->fullText('title');
                $table->fullText('source');
                $table->unique(['source', 'provider_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
