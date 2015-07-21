<?php

use App\Unit;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call('UserTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('CourseTableSeeder');

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        User::create(['username' => 'admin',
            'emp_name' => 'Admin',
            'email' => 'admin@fiin.in.th',
            'role' => 99, 'password' => bcrypt('1234')]);


    }

}

class ProductTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('product_type')->delete();

        \App\Product_type::create(['pt_id' => '1001', 'pt_name' => 'Laser']);

        DB::table('product_group')->delete();
        \App\Product_group::create(['pg_id' => '1001', 'pt_id' => '1001', 'pg_name' => 'Laser']);


        DB::table('product')->delete();
        \App\Product::create(['product_id' => 'b011',
            'pg_id' => '1001',
            'product_name' => 'Anti Cellulite',
            'product_qty' => '200',
            'product_qty_order' => '50',
            'product_date_start' => '2002-02-03',
            'product_date_end' => '2012-02-03',
            'product_price' => '200',
            'product_unit' => 'CC']);
    }

}

class CourseTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('course')->delete();

        \App\Course::create(['course_id' => 'A001', 'course_name' => 'Advence Growth Factors รายครั้ง', 'course_price' => '10000',]);

        DB::table('course_detail')->delete();
        \App\Course_detail::create(['course_de_id' => '1', 'course_id' => 'A001', 'course_de_qty' => '1']);

        DB::table('medicine')->delete();
        \App\Medicine::create(['course_id' => 'A001', 'product_id' => 'A01', 'qty' => '20']);

    }

}