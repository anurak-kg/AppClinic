<?php

class BranchTest extends TestCase
{
    public function testLogin()
    {
        $this->visit('/login')
            ->type('admin', 'username')
            ->type('1234', 'password')
            ->press('เข้าสู่ระบบ')
            ->seePageIs('/');
        $this->currentBranch();
        $this->authTest();

    }

    public function testLogout()
    {
        $this->visit('/login')
            ->type('admin', 'username')
            ->type('1234', 'password')
            ->press('เข้าสู่ระบบ')
            ->visit('user/logout')
            ->seePageIs('/login');
        $this->assertNull(\App\Branch::getCurrentId());

    }

    public function currentBranch()
    {
        $this->assertEquals(10, \App\Branch::getCurrentId());
        $this->assertEquals('Tokyo', \App\Branch::getCurrentName());

    }

    public function authTest()
    {
        $this->assertEquals('admin', Auth::user()->username);
    }
}