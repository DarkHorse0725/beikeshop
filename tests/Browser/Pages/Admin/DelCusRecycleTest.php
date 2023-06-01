<?php

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\CustomerPage;
use Tests\Data\Admin\LoginData;
use Tests\DuskTestCase;

class DelCusRecycleTest extends DuskTestCase
{
   /**
    * A basic browser test example.
    * @return void
    */

//场景1 email不合法

   public function testDelCusRecycle()
   {

       $this->browse(function (Browser $browser) {
           $browser->visit(AdminLoginPage::Admin_Login['login_url'])
               //1.登录
               ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
               ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
               ->press(AdminLoginPage::Admin_Login['login_btn'])
               ->pause(2000)
               ->click(AdminPage::TOP['mg_customers'])
               //先删除一个客户
               ->press(CustomerPage::Group_list['del_customer'])
               ->press(CustomerPage::Group_list['sure_btn'])
               ->pause(1000)
               //2.点击回收站
               ->click(CustomerPage::Left['re_station']);
               $customer_text = $browser->text(CustomerPage::Empty_Recycle['customer_text']);
               echo $customer_text;
               //3.点击删除按钮
               $browser->press(CustomerPage::Empty_Recycle['recycle_del'])
               ->pause(2000)
               ->press(CustomerPage::Empty_Recycle['sure_btn'])
               //验证客户信息是否存在于页面
               ->assertSee($customer_text)
               ->pause(5000);
       });
   }
}
