<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('order_number')->unique();
            $table->decimal('price', 10, 2); // Final price paid
            $table->decimal('discount', 10, 2)->nullable()->default(0.00);

            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->enum('payment_method', ['paypal', 'stripe', 'mpesa', 'emola'])->default('paypal');
            $table->timestamp('paid_at')->nullable();

            $table->string('currency', 10)->default('USD');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
