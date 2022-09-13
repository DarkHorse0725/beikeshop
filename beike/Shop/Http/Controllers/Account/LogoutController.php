<?php
/**
 * LogoutController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     TL <mengwb@guangda.work>
 * @created    2022-06-23 20:22:54
 * @modified   2022-06-23 20:22:54
 */

namespace Beike\Shop\Http\Controllers\Account;

use Beike\Models\Customer;
use Beike\Shop\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function auth;
use function back;
use function redirect;
use function view;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        Auth::guard(Customer::AUTH_GUARD)->logout();

        $request->session()->regenerateToken();

        return redirect(shop_route('login.index'));
    }
}
