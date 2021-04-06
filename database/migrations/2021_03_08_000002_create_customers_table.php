<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('name');
            $table->string('username')->unique();
            $table->tinyInteger('status')->nullable()->comment('1/0');
            $table->uuid('photo')->nullable();
            $table->integer('trx_count')->nullable();
            $table->float('trx_amount')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('photo')->on('images')->references('id')->onDelete('cascade');
            $table->index('name');
            $table->index('username');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
