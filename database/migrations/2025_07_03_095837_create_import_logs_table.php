<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('import_logs', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('total_rows')->default(0);
            $table->integer('processed_rows')->default(0);
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('import_logs');
    }
};
