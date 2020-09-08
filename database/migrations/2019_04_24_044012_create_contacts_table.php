<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('district_id')->nullable();
            $table->string('district_name_en')->nullable();
            $table->string('district_name_np')->nullable();
            $table->string('org_name_en')->nullable();
            $table->string('org_name_np')->nullable();
            $table->string('local_authority_en')->nullable();
            $table->string('local_authority_np')->nullable();
            $table->string('phone_en')->nullable();
            $table->string('phone_np')->nullable();
            $table->bigInteger('order')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('contacts');
    }
}
