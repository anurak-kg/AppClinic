<?php

use App\Course;
use App\Course_detail;
use App\Medicine;
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
        $this->call('BranchTableSeeder');

        Model::reguard();
    }
}

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        User::create(['username' => 'admin',
            'name' => 'นาย ประยุท จันโอชา',
            'email' => 'admin@fiin.in.th',
            'role' => 99, 'password' => bcrypt('1234')]);

        DB::table('branch')->delete();
        \App\Branch::create(['branch_id'=>'99',
        'branch_name'=>'Tokyo',
        'branch_address'=>'150-0042 โตเกียว, Shibuya-ku, Udagawa-cho 3-1, ญี่ปุ่น',
        'branch_tel'=>'ไม่ระบุ',
        'branch_code'=>'4257893625145']);
    }

}
class BranchTableSeeder extends Seeder
{

    public function run()
    {
          DB::table('branch')->delete();
        \App\Branch::create([
            'branch_name'=>'Tokyo',
            'branch_address'=>'150-0042 โตเกียว, Shibuya-ku, Udagawa-cho 3-1, ญี่ปุ่น',
            'branch_tel'=>'ไม่ระบุ',
            'branch_code'=>'4257893625145']);
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
        DB::table('course_detail')->delete();
        DB::table('course_medicine')->delete();

        Course::create(
            ['course_id' => 'A001',
                'course_name' => 'Advence Growth Factors รายครั้ง',
                'course_price' => '10000',]);
       Course_detail::create(
            [
                'course_id' => 'A001',
                'course_detail_name' =>'Laser',
                'course_detail_qty' => '1']);
        Medicine::create(
            [   'course_detail_id' => '1',
                'product_id' => 'A01',
                'qty' => '20'
            ]);


        Course::create(
            ['course_id' => 'A002',
                'course_name' => 'นวดและนาบ',
                'course_detail' => 'เป็นการนวดที่ผสมการนาบที่ลงตัวลึกสุดใจ',
                'course_price' => '2400',]);

        Course_detail::create(
            [
                'course_id' => 'A002',
                'course_detail_name' =>'นวด',
                'course_detail_qty' => '2']);

        Course_detail::create(
            [
                'course_id' => 'A002',
                'course_detail_name' =>'นาบ',
                'course_detail_qty' => '1']);

       Course_detail::create(
            [
                'course_id' => 'A002',
                'course_detail_name' =>'อาบน้ำ',
                'course_detail_qty' => '1']);

    }

}