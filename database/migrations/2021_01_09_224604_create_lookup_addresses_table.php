<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLookupAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookup_addresses', function (Blueprint $table) {
            $table->id();
			$table->string('building_name')->nullable();
			$table->string('street')->nullable();
			$table->string('town')->nullable();
			$table->string('postcode')->index();
			$table->decimal('longitude', 10, 7)->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable()->index();
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
        Schema::dropIfExists('lookup_addresses');
    }
}
