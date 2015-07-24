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
        $this->call('CustomerTableSeeder');
        $this->call('PositionTableSeeder');
        Model::reguard();
    }
}

class CustomerTableSeeder extends Seeder
{
    public function run(){
        DB::table('customer')->delete();

        \App\Customer::create([
            'cus_name' => 'อนุรักษ์ ',
            'cus_lastname' => 'กิ่งแก้ว',
            'cus_tel' => '0875430262',
            'cus_email' => 'imannn.99@gmail.com',
        ]);
    }
}
class PositionTableSeeder extends Seeder{
    public function run(){
        DB::table('position')->delete();
        \App\Position::create(['position_id'=>1,'position_name'=>'General',
            'role'=>10]);
        \App\Position::create(['position_id'=>2,'position_name'=>'IT',
            'role'=>80]);
        \App\Position::create(['position_id'=>3,'position_name'=>'Manager',
            'role'=>60]);
        \App\Position::create(['position_id'=>4,'position_name'=>'Doctor',
            'role'=>40]);
        \App\Position::create(['position_id'=>5,'position_name'=>'Human resources officer',
            'role'=>50]);
        \App\Position::create(['position_id'=>99,'position_name'=>'admin',
            'role'=>99]);
        \App\Position::create(['position_name'=>'Reception',
            'role'=>1]);
        \App\Position::create(['position_name'=>'Sale',
            'role'=>1]);
        \App\Position::create(['position_name'=>'Marketing',
            'role'=>5]);
        \App\Position::create(['position_name'=>'Stock',
            'role'=>6]);
    }
}
class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        User::create(['username' => 'admin',
            'branch_id'=>'1','position_id'=>99,
            'name' => 'นาย ประยุท จันโอชา',
            'email' => 'admin@fiin.in.th',
            'password' => bcrypt('1234')]);
        User::create(['username' => 'sale',
            'branch_id'=>'1','position_id'=>1,
            'name' => 'นางยิงลักษณ์ ชินวัต',
            'email' => 'sale@fiin.in.th',
            'password' => bcrypt('1234')]);
        User::create(['username' => 'doctor',
            'branch_id'=>'1','position_id'=>4,
            'name' => 'นายชูวิทย์ กมลวิศิษฎ์',
            'email' => 'doctor@fiin.in.th',
            'password' => bcrypt('1234')]);
    }

}
class BranchTableSeeder extends Seeder
{

    public function run()
    {
          DB::table('branch')->delete();
        \App\Branch::create([
            'branch_id'=>'1',
            'branch_name'=>'Tokyo',
            'branch_address'=>'150-0042 โตเกียว, Shibuya-ku, Udagawa-cho 3-1, ญี่ปุ่น',
            'branch_tel'=>'ไม่ระบุ',
            'branch_email'=>'AV-JP@jp.com',
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

        \App\Product::create(['product_id' => 'b021',
            'pg_id' => '1001',
            'product_name' => 'Cellulite',
            'product_qty' => '80',
            'product_qty_order' => '50',
            'product_date_start' => '2002-02-03',
            'product_date_end' => '2012-02-03',
            'product_price' => '7000',
            'product_unit' => 'ขวด']);

        \App\Product::create(['product_id' => 'ad02',
            'pg_id' => '1001',
            'product_name' => 'Treatment',
            'product_qty' => '99',
            'product_qty_order' => '50',
            'product_date_start' => '2002-02-03',
            'product_date_end' => '2012-02-03',
            'product_price' => '7000',
            'product_unit' => 'เข็ม']);
    }

}

class CourseTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('course')->delete();
        DB::table('course_medicine')->delete();

        Course::create(
            ['course_id' => 'a001',
                'course_name' => 'Advence Growth Factors รายครั้ง',
                'course_detail'=>'บริการหน้าขาว ใส ไร้สิว',
                'course_price' => '10000.00',
                'course_qty'=>'1']);

        Medicine::create(
            ['course_id' => 'A001',
                'product_id' => 'b011',
                'qty' => '20'
            ]);

        Course::create(
            ['course_id' => 'A002',
                'course_name' => 'นวดและนาบ',
                'course_detail' => 'เป็นการนวดที่ผสมการนาบที่ลงตัวลึกสุดใจ',
                'course_price' => '2400',
                'course_qty'=>'1']);
        Medicine::create(
            ['course_id' => 'A002',
                'product_id' => 'ab02',
                'qty' => '5'
            ]);

        Course::create(
            ['course_id' => 'A003',
                'course_name' => 'Fake body',
                'course_detail' => 'กำลังอัพเดรต',
                'course_price' => '70000',
                'course_qty'=>'5']);

        Medicine::create(
            ['course_id' => 'A003',
                'product_id' => 'ab02',
                'qty' => '3'
            ]);
    }

}