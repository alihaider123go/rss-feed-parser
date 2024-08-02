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
        Schema::create('alert_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pooling_trigger_id')->constrained()->onDelete('cascade');
            $table->string('recipient_address');
            $table->string('subject');
            $table->json('body_items');
            $table->enum('alert_type', ['email', 'slack', 'sms'])->default('email');
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_actions');
    }
};
