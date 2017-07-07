<?php namespace Octobro\Jne\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCostsTable extends Migration
{
    public function up()
    {
        Schema::create('octobro_jne_costs', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('location')->index();
            $table->decimal('reg', 8, 2)->default(0);
            $table->decimal('yes', 8, 2)->default(0);
            $table->decimal('oke', 8, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('octobro_jne_costs');
    }
}
