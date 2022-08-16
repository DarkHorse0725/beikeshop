<?php
/**
 * AdminUserController.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Edward Yang <yangjin@opencart.cn>
 * @created    2022-08-01 11:44:54
 * @modified   2022-08-01 11:44:54
 */

namespace Beike\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Beike\Admin\Repositories\AdminUserRepo;
use Beike\Admin\Http\Requests\AdminUserRequest;

class AdminUserController extends Controller
{
    /**
     * 获取后台用户列表
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'admin_users' => AdminUserRepo::getAdminUsers(),
            'admin_roles' => Role::query()->get()
        ];
        return view('admin::pages.admin_users.index', $data);
    }


    /**
     * 创建后台管理员
     *
     * @param AdminUserRequest $request
     * @return array
     */
    public function store(AdminUserRequest $request)
    {
        $adminUser = AdminUserRepo::createAdminUser($request->toArray());
        return json_success(trans('common.created_success'), $adminUser);
    }


    /**
     * 更新后台管理员
     *
     * @param AdminUserRequest $request
     * @param int $adminUserId
     * @return array
     */
    public function update(AdminUserRequest $request, int $adminUserId)
    {
        $adminUser = AdminUserRepo::updateAdminUser($adminUserId, $request->toArray());
        return json_success(trans('common.updated_success'), $adminUser);
    }


    public function destroy(Request $request, int $adminUserId)
    {
        AdminUserRepo::deleteAdminUser($adminUserId);
        return json_success(trans('common.deleted_success'));
    }
}
