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
        $this->assertEquals(10,strlen(getNewSalePK()));
        $this->assertEquals(10,strlen(getNewOrderPK()));
        $this->assertEquals(10,strlen(getNewReceivePK()));
        $this->assertEquals(10,strlen(getNewReturnPK()));
        $this->assertEquals(10,strlen(getNewInvTranPK()));
        $this->assertEquals(10,strlen(getNewPaymentPK()));
        $this->assertEquals(10,strlen(getNewPaymentDetailPK()));
        //$this->assertEquals(10,strlen(getNewCustomerPK()));

    }

}