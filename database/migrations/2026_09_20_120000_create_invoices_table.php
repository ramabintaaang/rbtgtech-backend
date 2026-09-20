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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->string('billed_to');
            $table->string('billed_address')->nullable();
            $table->string('billed_phone')->nullable();
            $table->json('items'); // [{item, quantity, unit_price, total}]
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid');
            
            // Payment details
            $table->string('account_name')->default('RAMA BINTANG');
            $table->string('bank_name')->default('Bank Mandiri');
            $table->string('account_number')->default('1350019554706');
            
            // Footer details
            $table->string('thank_you_text')->default('Thank you!');
            $table->string('issuer_name')->default('Rama Bintang');
            $table->string('issuer_contact')->default('Semarang, Indonesia - 0895360531176');
            $table->string('issuer_website')->default('www.rbtgtech.com');
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
