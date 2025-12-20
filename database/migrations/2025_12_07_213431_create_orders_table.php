<?php
// database/migrations/2025_01_01_000000_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('buyer_name');
        $table->string('phone');
        $table->text('address');
        $table->bigInteger('total_price');
        $table->string('status')->default('pending');
        $table->timestamps();
    });

    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
