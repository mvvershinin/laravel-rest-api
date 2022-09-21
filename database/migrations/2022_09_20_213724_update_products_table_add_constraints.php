<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $query = '

        ALTER TABLE products ADD CONSTRAINT products_price_check CHECK (price > 0);
        ALTER TABLE products ADD CONSTRAINT products_eid_check CHECK (eid > 0);
        ';
        DB::unprepared($query);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $query = '
        ALTER TABLE products DROP CONSTRAINT products_price_check;
        ALTER TABLE products DROP CONSTRAINT products_eid_check;
        ';
        DB::unprepared($query);

    }
};
