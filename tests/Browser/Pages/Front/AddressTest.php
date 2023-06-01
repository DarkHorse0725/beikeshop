<?php

namespace Tests\Browser\Pages\Front;

use Laravel\Dusk\Browser;
use Tests\Data\Catalog\AccountData;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\LoginPage;
use Tests\DuskTestCase;
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\CataLoginData;

//已注册客户且有地址，直接购买商品
class AddressTest extends DuskTestCase
{
    public function testAddress()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
                //1.用户登录
                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])

                ->pause(5000)
                //2.点击address
                ->click(AccountPage::Account['go_address'])
                //3.点击添加地址
                ->press(AccountPage::Address['add_btn'])
                ->pause(3000)
                //3.1  name
                ->type(AccountPage::Address['add_name'], AccountData::Add_Address['add_name'])
                //3.2 phone
//                ->type(AccountPage::Address['add_phone'], AccountData::Add_Address['add_phone'])
                //3.3 address
                ->type(AccountPage::Address['add_address'], AccountData::Add_Address['add_province'])
//                //3.4 code
//                ->type(AccountPage::Address['add_code'], AccountData::Add_Address['add_code'])
                //3.5 address1
                ->type(AccountPage::Address['add_address1'], AccountData::Add_Address['add_address1'])
//                //3.6 address2
//                ->type(AccountPage::Address['add_address2'], AccountData::Add_Address['add_address2'])
                //3.7 defaule
                ->press((AccountPage::Address['default']))
                //3.8 save
                ->press((AccountPage::Address['save']))
                ->pause(3000)
                ->assertSee(AccountPage::Address['assert']);
        });
    }
}
