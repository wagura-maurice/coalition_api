<?php

use App\Models\TaskCatalog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('_uid')->unique();
            $table->foreignId('category_id')->constrained('task_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->nullable()->unique(); // Label tag
            $table->text('description')->nullable();
            $table->dateTime('due_date')->nullable(); // Due date
            $table->integer('_priority')->default(0);
            $table->integer('_status')->default(TaskCatalog::PENDING);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_catalogs');
    }
};
