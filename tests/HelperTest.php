<?php

class HelperTest extends TestCase
{
    public function testPkHelper(){
        $this->visit('/login')
            ->type('admin', 'username')
            ->type('1234', 'password')
            ->press('เข้าสู่ระบบ');
        $this->assertEquals(10,strlen(getNewQuoPK()));
        $this->assertEquals(10,strlen(getNewQuoDetailPK()));
    }

}