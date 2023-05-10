<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

require_once dirname(__FILE__) . '/../../data/admin/login.php';
require_once dirname(__FILE__) . '/../../data/admin/login_page.php';
require_once dirname(__FILE__) . '/../../data/admin/admin_page.php';

class GoVipTest extends DuskTestCase
{
        /**
         * A basic browser test example.
         * @return void
         */
        public function testGoVip()
        {

        $this->browse(function (Browser $browser) {
            $browser->visit(admin_login['login_url'])
                //1.登录
                ->type(admin_login['login_email'], admin_true_login['email'])
                ->type(admin_login['login_pwd'], admin_true_login['password'])
                ->press(admin_login['login_btn'])
                ->pause(2000)
                //2.点击vip图标
                ->click(admin_top['VIP'])
                ->pause(2000)
                //3.切换到第二个窗口并获取断言
                ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);
                $browser->assertSee(admin_assert['vip_assert']);
        });
    }
}
