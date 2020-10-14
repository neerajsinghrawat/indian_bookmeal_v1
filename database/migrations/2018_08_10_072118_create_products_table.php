<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->length('11');
            $table->string('name')->length('255');
            $table->string('model_no')->length('255');
            $table->string('slug')->length('255');
            $table->string('image')->length('255');       
            $table->timestamp('created_at');
            //$table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
