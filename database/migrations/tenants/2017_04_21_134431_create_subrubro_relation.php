<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubrubroRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subrubros', function (Blueprint $table) {
			$table->integer('rubro_id')->unsigned()->after('id');
			
			//relacion con rubros            
            $table->foreign('rubro_id')
                ->references('id')->on('rubros');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subrubros', function (Blueprint $table) {
			$table->dropForeign('subrubros_rubro_id_foreign');			
			$table->dropColumn('rubro_id');
		});
    }
}
