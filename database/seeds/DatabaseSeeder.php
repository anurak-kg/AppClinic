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

         $this->call('UnitTypeTableSeeder');
        $this->call('UserTableSeeder');

        Model::reguard();
    }
}
class UnitTypeTableSeeder extends Seeder {

    public function run()
    {
        DB::table('unit')->delete();

        Unit::create(['UnitName' => 'ชิ้น']);
        Unit::create(['UnitName' => 'ลัง']);
        Unit::create(['UnitName' => 'โหล']);

    }

}
class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['username' => 'admin' ,'name' => 'Admin' ,'email' => 'admin@fiin.in.th','password' => bcrypt('1234')]);


    }

}