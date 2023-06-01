<?php

namespace Tests\Browser\Pages\Admin;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\CustomerPage;


class DelCustomerTest extends DuskTestCase
{
   /**
    * A basic browser test example.
    * @return void
    */

//场景1 email不合法

   public function testDelCustomer()
   {

       $this->browse(function (Browser $browser) {
           $browser->visit(AdminLoginPage::Admin_Login['login_url'])
               //1.登录
               ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
               ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
               ->press(AdminLoginPage::Admin_Login['login_btn'])
               ->pause(2000)
               //2.点击客户管理
               ->click(AdminPage::TOP['mg_customers']);
               $customer_text = $browser->text(CustomerPage::Group_list['get_assert']);
               echo $customer_text;
               $browser->press(CustomerPage::Group_list['del_customer'])
               //确认
               ->press(CustomerPage::Group_list['sure_btn']);
               $browser->pause(2000)
               ->assertDontSee($customer_text)
               ->pause(5000);
       });
   }
}
