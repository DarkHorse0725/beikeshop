<?php

namespace Tests\Browser\Pages\Combine;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\CreProductPage;
use Tests\Data\Admin\ProductPage;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\LoginData;
class EnableProductTest extends DuskTestCase
{
   /**
    * A basic browser test example.
    * @return void
    */

//启用商品

   public function testEnableProduct()
   {

       $this->browse(function (Browser $browser) {
           $browser->visit(AdminLoginPage::Admin_Login['login_url'])
               //1.登录
               ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
               ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
               ->press(AdminLoginPage::Admin_Login['login_btn'])
               ->pause(2000)
               ->click(AdminPage::TOP['mg_product']);
               $product1_text = $browser->text(ProductPage::Product_Top['get_name']);
               echo $product1_text;
               //编辑商品
               $browser->press(ProductPage::Product_Top['edit_product'])
               //启用商品
               ->click(CreProductPage::Product_Top['Enable'])
               //点击保存
               ->press(CreProductPage::Product_Top['save_btn'])
               ->pause(3000)
               //点击商品，跳转前台
               ->clickLink($product1_text)
               ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);
               //断言页面是否有购买按钮
               $browser->assertVisible(ProductOne::Product['product_1'])
               ->pause(3000);
       });
   }
}
