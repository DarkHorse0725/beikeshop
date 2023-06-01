<?php

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\CreProduct;
use Tests\Data\Admin\CreProductPage;
use Tests\Data\Admin\ProductPage;
use Tests\DuskTestCase;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;

class AddProductTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */

//场景1 email不合法
    public function testAddProduct()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])
                //1.登录
                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
                //2.点击商品
                ->click(AdminPage::TOP['mg_product'])
                //2.点击商品管理
                ->click(ProductPage::Product_Left['product_mg'])
                //3.点击创建
                ->press(ProductPage::Product_Top['create_product'])
                //4.填写商品信息
                ->type(CreProductPage::Product_Top['ch_name'], CreProduct::Puoduct_Info['ch_name'])
                ->type(CreProductPage::Product_Top['en_name'], CreProduct::Puoduct_Info['en_name'])
                ->type(CreProductPage::Product_Top['sku'], CreProduct::Puoduct_Info['sku'])
                ->type(CreProductPage::Product_Top['price'], CreProduct::Puoduct_Info['price'])
                ->type(CreProductPage::Product_Top['origin_price'], CreProduct::Puoduct_Info['origin_price'])
                ->type(CreProductPage::Product_Top['cost_price'], CreProduct::Puoduct_Info['cost_price'])
                ->type(CreProductPage::Product_Top['quantity'], CreProduct::Puoduct_Info['quantity'])
                //5.点击保存
                ->press(CreProductPage::Product_Top['save_btn'])
                ->assertSee(ProductPage::Assert['cre_ful_assert']);
                });
    }
}
