<?php

namespace Tests\Browser\Pages\Front;


use Laravel\Dusk\Browser;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\CataLoginData;
use Tests\Data\Catalog\LoginPage;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;
use Tests\Data\Catalog\IndexPage;

//已注册客户且有地址，直接购买商品
class RemoveCartTest extends DuskTestCase
{
    public function testRemoveCart()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
            //1.用户登录
            ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
            ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
            ->press(LoginPage::Login['login_btn'])
            ->pause(2000)
            //2.点击home跳转到首页
            ->click(AccountPage::Account['go_index'])
            //3.向下滑动页面直到找到元素
            ->scrollIntoView(IndexPage::Index['product_img'])
            ->pause(2000)
            //4.点击要加入购物车的商品
            ->press(IndexPage::Index['product_img'])
            ->pause(2000)
            //5.点击加入购物车
            ->press(ProductOne::Product['add_cart'])
            ->pause(3000)
            //6.点击购物车按钮
            ->click(IndexPage::Index_Cart['cart_icon'])
            ->pause(3000)
            //7.点击移除按钮
            ->click(IndexPage::Index_Cart['Delete_btn'])
            ->pause(3000)
            ->assertSeeIn(IndexPage::Index_Cart['product_num'], '0')
            ->pause(3000);
        });
    }
}
