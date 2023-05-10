<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

require_once dirname(__FILE__) . '/../../data/admin/login.php';
require_once dirname(__FILE__) . '/../../data/admin/login_page.php';
require_once dirname(__FILE__) . '/../../data/admin/admin_page.php';
require_once dirname(__FILE__) . '/../../data/admin/cus_grounp.php';
require_once dirname(__FILE__) . '/../../data/admin/customer_page.php';
class EditCusGroupTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */
    public function testEditCusGroup()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(admin_login['login_url'])
                //1.登录
                ->type(admin_login['login_email'], admin_true_login['email'])
                ->type(admin_login['login_pwd'], admin_true_login['password'])
                ->press(admin_login['login_btn'])
                ->pause(2000)
                //2.点击客户管理
                ->click(admin_top['mg_customers'])
                ->pause(3000)
                //4.点击客户组
                ->click(customer_left['customer_group'])
                //5.点击编辑客户组
                ->press(customer_group['edit_cus_group'])
                //4.填写客户组信息
                ->type(cre_cus_group['ch_group_name'], alter_cus_group_info['ch_group_name'])
                ->type(cre_cus_group['en_group_name'], alter_cus_group_info['en_group_name'])
                ->type(cre_cus_group['ch_description'], alter_cus_group_info['ch_description'])
                ->type(cre_cus_group['en_description'], alter_cus_group_info['en_description'])
                ->type(cre_cus_group['discount'], alter_cus_group_info['discount'])
                //5.点击保存
                ->press(cre_cus_group['save_btn'])
                ->pause(5000)
                ->assertSee(alter_cus_group_info['ch_group_name']);
        });
    }
}
