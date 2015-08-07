<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar', function (Blueprint $table) {
            $table->date('datefield');
        });
        $sql = <<<SQL
                DROP PROCEDURE IF EXISTS fill_calendar;
                CREATE PROCEDURE fill_calendar(start_date DATE, end_date DATE)
BEGIN
  DECLARE crt_date DATE;
  SET crt_date=start_date;
  WHILE crt_date < end_date DO
    INSERT INTO calendar VALUES(crt_date);
    SET crt_date = ADDDATE(crt_date, INTERVAL 1 DAY);
  END WHILE;
END
SQL;
        DB::connection()->getPdo()->exec($sql);
        DB::unprepared("CALL fill_calendar('2015-01-01', '2020-12-31');
");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = "DROP PROCEDURE IF EXISTS fill_calendar";
        DB::connection()->getPdo()->exec($sql);
        Schema::drop('calendar');
    }
}
