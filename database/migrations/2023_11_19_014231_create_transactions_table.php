<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->enum('status', [Transaction::STATUS_PAID, Transaction::STATUS_OUTSTANDING, Transaction::STATUS_OVERDUE])->default(Transaction::STATUS_OUTSTANDING);
            $table->decimal('amount');
            $table->timestamp('due_on');
            $table->decimal('vat');
            $table->boolean('is_vat_inclusive');
            $table->unsignedBigInteger('payer_id');
            $table->unsignedBigInteger('creator_id');

            $table->foreign('payer_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('creator_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
