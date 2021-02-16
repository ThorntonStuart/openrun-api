<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_addresses', function (Blueprint $table) {
            $table->id();
			$table->string('line_1');
			$table->string('line_2')->nullable();
			$table->string('line_3')->nullable();
			$table->string('town')->nullable();
			$table->string('county')->nullable();
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
        Schema::dropIfExists('manual_addresses');
    }
}
