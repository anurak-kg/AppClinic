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

        $this->call('ProductTableSeeder');
        $this->call('CourseTableSeeder');
        $this->call('BranchTableSeeder');
        $this->call('CustomerTableSeeder');
        $this->call('VendorTableSeeder');
        $this->call('SettingTableSeeder');
        $this->call('RolePermissionTableSeeder');
        $this->call('UserTableSeeder');

        Model::reguard();
    }
}

class CustomerTableSeeder extends Seeder
{
    public function run(){
        DB::table('customer')->delete();

        \App\Customer::create([
            'cus_name' => 'อนุรักษ์ กิ่งแก้ว',
            'cus_tel' => '0875430262',
            'cus_email' => 'imannn.99@gmail.com',
            'cus_birthday_year' => '2548',
        ]);
    }
}
class VendorTableSeeder extends Seeder
{
    public function run(){
        DB::table('vendor')->delete();

        \App\Vendor::create([
            'ven_id' => '123',
            'ven_name' => 'Microsoft New York Metro District: Iselin, NJ',
            'ven_address' => '101 Wood Avenue South, Suite 900 Metro Park 101 Iselin, NJ 08830 ',
            'ven_sell_name' => '',
            'ven_sell_tel' => '7324765600',
            'ven_license' => '2134545613212'
        ]);
    }
}
class SettingTableSeeder extends Seeder
{
    public function run(){
        DB::table('setting')->delete();

        DB::table('setting')->insert([
            ['setting_name' => 'clinicName',        'value' => 'TheRock'],
            ['setting_name' => 'commission_rate',   'value' => '10'],
            ['setting_name' => 'vat_mode',          'value' => 'in_vat'],
            ['setting_name' => 'vat_rate',              'value' => '7'],
            ['setting_name' => 'product_day_expire',    'value' => '30'],
            ['setting_name' => 'order_sell',            'value' => 'FIFO'],
            ['setting_name' => 'customer_photo_limit',            'value' => '5'],
            ['setting_name' => 'product_out_stock_can_treat',            'value' => 'false'],

        ]);
    }
}

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();

        $root = User::create(['username' => 'admin',
            'branch_id' => '1', 'position_id' => 99,
            'name' => 'นาย ประยุท จันโอชา',
            'email' => 'admin@fiin.in.th',
            'password' => bcrypt('1234')]);
        $root->roles()->sync([99]);

        $recp = User::create(['username' => 'reception',
            'branch_id' => '1', 'position_id' => 6,
            'name' => 'นางยิงลักษณ์ ชินวัต',
            'email' => 'reception@fiin.in.th',
            'password' => bcrypt('1234')]);
        $recp->roles()->sync([6]);
        $manager = User::create(['username' => 'manager',
            'branch_id' => '1', 'position_id' => 5,
            'name' => 'นายชูวิทย์ กมลวิศิษฎ์',
            'email' => 'manager@fiin.in.th',
            'password' => bcrypt('1234')]);
        $manager->roles()->sync([5]);
        $sale = User::create(['username' => 'sale',
            'branch_id' => '1', 'position_id' => 1,
            'name' => 'sale',
            'email' => 'sale@fiin.in.th']);
        $sale->roles()->sync([1]);
        $doctor = User::create(['username' => 'doctor',
            'branch_id' => '1', 'position_id' => 4,
            'name' => 'doctor',
            'email' => 'doctor@fiin.in.th']);
        $doctor->roles()->sync([4]);
        $it = User::create(['username' => 'it',
            'branch_id' => '1','position_id' => 11,
            'name' => 'IT',
            'email' => 'IT@fiin.in.th',
            'password' => bcrypt('1234')]);
        $it->roles()->sync([11]);
        $super = User::create(['username' => 'superadmin',
            'branch_id' => '1','position_id' => 95,
            'name' => 'superadmin',
            'email' => 'superadmin@fiin.in.th',
            'password' => bcrypt('1234')]);
        $super->roles()->sync([95]);
    }

}

class BranchTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('branch')->delete();
        \App\Branch::create([
            'branch_id' => '1',
            'branch_name' => 'Tokyo',
            'branch_address' => '150-0042 โตเกียว, Shibuya-ku, Udagawa-cho 3-1, ญี่ปุ่น',
            'branch_tel' => 'ไม่ระบุ',
            'branch_email' => 'AV-JP@jp.com',
            'branch_code' => '4257893625145']);
    }

}

class ProductTableSeeder extends Seeder
{

    public function run()
    {

        DB::table('product_group')->delete();
        \App\Product_group::create(['pg_id' => '1001', 'pg_name' => 'Laser']);


        DB::table('product')->delete();
        \App\Product::create(['product_id' => 'b011',
            'pg_id' => '1001',
            'product_name' => 'Anti Cellulite',
            'product_qty_order' => '50',
            'product_price' => '200',
            'product_unit' => 'CC']);
        \App\Product::create(['product_id' => 'b012',
            'pg_id' => '1001',
            'product_name' => 'LA MER Crème De La Mer 60 ml.',
            'product_qty_order' => '50',
            'product_price' => '12700',
            'product_unit' => 'กระปุ๊ก']);
        \App\Product::create(['product_id' => 'b013',
            'pg_id' => '1001',
            'product_name' => 'Jeunesse Instantly Ageless เจอเนสส์ (50 ซอง/กล่อง)   ',
            'product_qty_order' => '50',
            'product_price' => '14875',
            'product_unit' => 'กล่อง']);
        \App\Product::create(['product_id' => 'b014',
            'pg_id' => '1001',
            'product_name' => 'Lancome Genifique Youth Activating Concentrate 7ml',
            'product_qty_order' => '50',
            'product_price' => '2800',
            'product_unit' => 'ขวด']);
        \App\Product::create(['product_id' => 'b015',
            'pg_id' => '1001',
            'product_name' => 'Mederma ครีมทาแผลเป็นหลังคลอด 20 กรัม',
            'product_qty_order' => '50',
            'product_price' => '2400',
            'product_unit' => 'กล่อง']);
        \App\Product::create(['product_id' => 'b016',
            'pg_id' => '1001',
            'product_name' => 'อายไลเนอร์ Bisous Bisous 72 Hrs Pen Eyeliner',
            'product_qty_order' => '50',
            'product_price' => '595',
            'product_unit' => 'กล่อง']);
        \App\Product::create(['product_id' => 'b017',
            'pg_id' => '1001',
            'product_name' => 'Bisous Bisous ครีมทาหน้า สูตรน้ำนมเข้มข้น - The White Queen Milky White Skin   ',
            'product_qty_order' => '50',
            'product_price' => '895',
            'product_unit' => 'หลอด']);
        \App\Product::create(['product_id' => 'b021',
            'pg_id' => '1001',
            'product_name' => 'Cellulite',
            'product_qty_order' => '50',
            'product_price' => '7000',
            'product_unit' => 'ขวด']);

        \App\Product::create(['product_id' => 'ad02',
            'pg_id' => '1001',
            'product_name' => 'Treatment',
            'product_qty_order' => '50',
            'product_price' => '7000',
            'product_unit' => 'เข็ม']);
        \App\Product::create(['product_id' => 'ad03',
            'pg_id' => '1001',
            'product_name' => 'Skin2u ครีมขาเนียน ผิวขาว (300ml)   ',
            'product_qty_order' => '50',
            'product_price' => '590',
            'product_unit' => 'ขวด']);
        \App\Product::create(['product_id' => 'ad04',
            'pg_id' => '1001',
            'product_name' => 'Beauty White Vampire Body Serum เซรั่มหัวเชื้อ ตัวขาว ผิวขาว เข้มข้น 10 เท่า',
            'product_qty_order' => '50',
            'product_price' => '897',
            'product_unit' => 'ขวด']);
    }

}

class CourseTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('course')->delete();
        DB::table('course_type')->delete();
        DB::table('course_medicine')->delete();
        \App\Course_type::create(
            ['name' => 'Laser']
        );
        \App\Course_type::create(
            ['name' => 'Treatment']
        );
        Course::create(
            ['course_id' => 'A001',
                'ct_id' => '1',
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
                'ct_id' => '2',
                'course_name' => 'นวดอโลมา',
                'course_detail' => 'เป็นการนวดที่ผสมการนาบที่ลงตัวลึกสุดใจ',
                'course_price' => '2400',
                'course_qty'=>'1']);
        Medicine::create(
            ['course_id' => 'A002',
                'product_id' => 'b016',
                'qty' => '5'
            ]);

        Course::create(
            ['course_id' => 'A003',
                'ct_id' => '2',
                'course_name' => 'Fake body',
                'course_detail' => 'กำลังอัพเดรต',
                'course_price' => '70000',
                'course_qty'=>'5']);

        Medicine::create(
            ['course_id' => 'A003',
                'product_id' => 'ad02',
                'qty' => '3'
            ]);
        Course::create(
            ['course_id' => 'A004',
                'ct_id' => '1',
                'course_name' => 'body scrap',
                'course_detail' => 'กำลังอัพเดรต',
                'course_price' => '12000',
                'course_qty'=>'5']);
        Medicine::create(
            ['course_id' => 'A004',
                'product_id' => 'ad03',
                'qty' => '3'
            ]);
        Medicine::create(
            ['course_id' => 'A004',
                'product_id' => 'ad04',
                'qty' => '3'
            ]);
        Course::create(
            ['course_id' => 'A005',
                'ct_id' => '1',
                'course_name' => 'face scrap',
                'course_detail' => 'กำลังอัพเดรต',
                'course_price' => '12000',
                'course_qty'=>'5']);
        Medicine::create(
            ['course_id' => 'A005',
                'product_id' => 'b015',
                'qty' => '3'
            ]);
        Medicine::create(
            ['course_id' => 'A005',
                'product_id' => 'b013',
                'qty' => '3'
            ]);
    }

}

class RolePermissionTableSeeder extends Seeder
{
    public function run()
    {

        DB::table('permissions')->delete();
        DB::table('permissions')->insert([
            ['id' => '1', 'name' => 'customer-read', 'display_name' => 'ดูข้อมูลลูกค้า'],
            ['id' => '2', 'name' => 'customer-create', 'display_name' => 'เพิ่มข้อมูลลูกค้า'],
            ['id' => '3', 'name' => 'customer-delete', 'display_name' => 'ลบลูกค้า'],
            ['id' => '4', 'name' => 'customer-edit', 'display_name' => 'แก้ไขข้อมูลลูกค้า'],
            ['id' => '5', 'name' => 'order-order', 'display_name' => 'สั่งสิ้นค้า'],
            ['id' => '6', 'name' => 'quo', 'display_name' => 'ขายคอร์ส'],
            ['id' => '7', 'name' => 'emp', 'display_name' => 'การจัดการพนักงาน'],
            ['id' => '8', 'name' => 'course', 'display_name' => 'เพิ่ม แก้ไข และลบคอร์ส'],
            ['id' => '9', 'name' => 'course-read', 'display_name' => 'ดูข้อมูลคอร์ส'],
            ['id' => '10', 'name' => 'product-group', 'display_name' => 'เพิ่ม ลบ และแก้ไขกลุ่มสินค้า'],
            ['id' => '11', 'name' => 'receive-return', 'display_name' => 'รับสินค้าและคืนสินค้า'],
            ['id' => '12', 'name' => 'treatment', 'display_name' => 'รักษา'],
            ['id' => '13', 'name' => 'sales', 'display_name' => 'POS'],
            ['id' => '14', 'name' => 'report', 'display_name' => 'รายงาน'],
            ['id' => '15', 'name' => 'dr-working', 'display_name' => 'ตารางการทำงานหมอ'],
            ['id' => '16', 'name' => 'appointment', 'display_name' => 'ตารางนัดลูกค้า'],
            ['id' => '17', 'name' => 'product', 'display_name' => 'เพิ่ม แก้ไข และลบสินค้า'],
            ['id' => '18', 'name' => 'product-read', 'display_name' => 'ดูข้อมูลสินค้า'],
            ['id' => '19', 'name' => 'branch', 'display_name' => 'การจัดการสาขา'],
            ['id' => '20', 'name' => 'vendor', 'display_name' => 'การจัดการ suppiler'],
            ['id' => '21', 'name' => 'course-type', 'display_name' => 'เพิ่ม ลบ และแก้ไขประเภทคอร์ส'],
            ['id' => '22', 'name' => 'payment', 'display_name' => 'ชำระเงิน'],
            ['id' => '23', 'name' => 'setting', 'display_name' => 'ตั้งค่า'],
            ['id' => '24', 'name' => 'permission', 'display_name' => 'กำหนดสิทธิ'],


        ]);
        DB::table('roles')->delete();

        $sale = \App\Models\Role::create(['id' => '1', 'name' => 'Sale', 'display_name' => 'พนักงานขาย']);
        $sale->perms()->sync([]);

        $po = \App\Models\Role::create(['id' => '2', 'name' => 'PO', 'display_name' => 'พนักงานสั่งซื้อสินค้า']);
        $po->perms()->sync([5,11]);

        $stock = \App\Models\Role::create(['id' => '3', 'name' => 'Stock', 'display_name' => 'พนักงานจัดการสินค้า']);
        $stock->perms()->sync([10,17,18]);

        $doctor = \App\Models\Role::create(['id' => '4', 'name' => 'Doctor', 'display_name' => 'แพทย์']);
        $doctor->perms()->sync([]);

        $manager = \App\Models\Role::create(['id' => '5', 'name' => 'Manager', 'display_name' => 'ผู้บริหาร']);
        $manager->perms()->sync([14]);

        $recp = \App\Models\Role::create(['id' => '6', 'name' => 'Reception', 'display_name' => 'พนักงานต้อนรับ']);
        $recp->perms()->sync([1,2,3,4,6,12,13,16,18,22]);

        \App\Models\Role::create(['id' => '7', 'name' => 'Marketing', 'display_name' => 'พนักงานการตลาด']);
        $it = \App\Models\Role::create(['id' => '11', 'name' => 'IT', 'display_name' => 'พนักงานไอที']);
        $it->perms()->sync([]);

        $super = \App\Models\Role::create(['id' => '95', 'name' => 'super-admin', 'display_name' => 'Super Admin']);
        $super->perms()->sync([]);

        $root = \App\Models\Role::create(['id' => '99', 'name' => 'root', 'display_name' => 'Root']);
        $root->perms()->sync([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]);



    }
}
