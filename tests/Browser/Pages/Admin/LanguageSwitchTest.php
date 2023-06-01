<?php

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;




class LanguageSwitchTest extends DuskTestCase
{
        /**
         * A basic browser test example.
         * @return void
         */
        public function testLanguageSwitch()
        {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])
                //1.登录
                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
                //2.点击切换语言
                ->click(AdminPage::TOP['sw_language'])
                //3.切换为英文
                ->click(AdminPage::TOP['en_language'])
                ->pause(4000)
                ->assertSee(AdminPage::Assert['en_assert'])
                //切换回中文
                ->click(AdminPage::TOP['sw_language'])
                ->click(AdminPage::TOP['ch_language'])
                ->assertSee(AdminPage::Assert['ch_assert']);
        });
    }
}
