<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    //redirect admin dashboard page
    public function dashboard()
    {
        $totalSaleAmt = PaymentHistory::sum('total_amt');
        $orderCount = Order::whereIn('status', [0, 1])->count('id');
        $registerUser = User::where('role', 'user')->count('id');
        $orderPending = Order::where('status', [0])->count('id');

        return view('admin.home.admin_home', compact('totalSaleAmt', 'orderCount', 'registerUser', 'orderPending'));

    }

    //create new admin page
    public function createAdminPage()
    {
        return view('admin.account.newAdmin');
    }

    //create new admin admin acc
    public function createAdmin(Request $request)
    {
        $this->checkAccountValidation($request);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);
        Alert::success('Success Title', 'Admin အကောင့်အသစ်ကို အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');

        return back();
    }

    //admin list page
    public function adminList()
    {
        $admin = User::select('id', 'name', 'nickname', 'email', 'address', 'phone', 'profile', 'created_at', 'role', 'provider')
            ->whereIn('role', ['admin', 'superadmin'])
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['name', 'nickname', 'email', 'address', 'phone', 'provider', 'role'], 'like', '%' . request('searchKey') . '%');
            })
            ->paginate(3);

        return view('admin.account.adminList', compact('admin'));
    }

    //admin delete
    public function adminDelete($id)
    {
        User::where('id', $id)->delete();
        return back();
    }

    //user list page
    public function userList()
    {
        $user = User::select('id', 'name', 'nickname', 'email', 'address', 'phone', 'profile', 'created_at', 'role', 'provider')
            ->whereIn('role', ['user'])
            ->when(request('searchKey'), function ($query) {
                $query->whereAny(['name', 'nickname', 'email', 'address', 'phone', 'provider', 'role'], 'like', '%' . request('searchKey') . '%');
            })
            ->paginate(5);
        return view('admin.account.userList', compact('user'));
    }

    //delete user
    public function userDelete($id)
    {
        User::where('id', $id)->delete();
        return back();
    }

    //check validation
    private function checkAccountValidation($request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:12',
            'confirmPassword' => 'required|same:password',
        ]);
    }

    //sale information
    public function saleInfo()
    {
        $soldProducts = Order::select('users.name as user_name', 'users.nickname','orders.id as order_id', 'orders.product_id', 'orders.count', 'orders.status', 'orders.order_code', 'orders.created_at', 'products.id as product_id', 'products.name as product_name')
                    ->leftJoin('products', 'orders.product_id', 'products.id')
                    ->leftJoin('users', 'orders.user_id', 'users.id')
                    ->where('status', 1)
                    ->orderBy('orders.created_at', 'desc')
                    ->get();

        // dd($soldProducts->toArray());

        return view('admin.home.saleInfo', compact('soldProducts'));
    }
}
