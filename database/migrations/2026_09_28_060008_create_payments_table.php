<?php

use App\Models\Sales\Order;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->restrictOnDelete();
            $table->string('provider', 20)->default('stripe');
            $table->string('checkout_session_id')->nullable()->unique();             // cs_...
            $table->string('payment_intent_id')->nullable()->index();                // pi_...
            $table->unsignedInteger('amount');
            $table->unsignedInteger('amount_refunded')->default(0);
            $table->char('currency', 3)->default('usd');
            $table->string('status', 20)->default('unpaid')->index();
            $table->json('payload')->nullable();                                     // last Stripe object
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
