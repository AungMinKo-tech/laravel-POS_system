<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;

class OrderController extends Controller
{
    //direct to order list
    public function orderList()  {
        $orderList = Order::select('products.stock', 'products.id as product_id', 'orders.count as order_count','orders.id as order_id', 'orders.order_code', 'orders.created_at', 'orders.status', 'users.name', 'users.nickname')
                    ->leftJoin('users', 'orders.user_id', 'users.id')
                    ->leftJoin('products', 'orders.product_id', 'products.id')
                    ->groupBy('order_code')
                    ->orderBy('orders.created_at','desc')
                    ->get();


        // dd($list);
        return view('admin.order.list', compact('orderList'));
    }

    //order details page
    public function orderDetails($orderCode){
        $order = Order::select('users.name as user_name', 'users.phone', 'users.address','products.id as product_id', 'products.name as product_name', 'products.image', 'products.price','products.stock','orders.id as order_id', 'orders.user_id', 'orders.count as order_count', 'orders.order_code', 'orders.created_at')
                ->leftJoin('products', 'orders.product_id', 'products.id')
                ->leftJoin('users', 'orders.user_id', 'users.id')
                ->where('orders.order_code', $orderCode)
                ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.*', 'payments.type as payment_type')
                        ->leftJoin('payments', 'payments.id', 'payment_histories.payment_method')
                        ->where('order_code', $orderCode)->first();

        $status = true;

        foreach($order as $item){
            // array_push($orderStatus, $item->order_count > $item->stock ? false : true);
            if($item->order_count <= $item->stock) {
                $status = true;
            }else{
                $status = false;
                break;
            }
        }
        // dd($status);
        return view('admin.order.details', compact('order', 'paymentHistory', 'status'));
    }

    //order reject
    public function orderReject(Request $request){
        Order::where('order_code',$request->orderCode)->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order reject successfully...'
        ],200);
    }

    //order status change
    public function orderStatusChange(Request $request){

        // logger($request->all());
        Order::where('order_code',$request->order_code)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order reject successfully...'
        ],200);
    }

    //order confrim
    public function orderConfirm(Request $request){
        Order::where('order_code',$request[0]['orderCode'])->update([
            'status' => 1
        ]);

        foreach($request->all() as $item){
            Product::where('id', $item['productId'])->decrement('stock', $item['count']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'order reject successfully...'
        ],200);
    }
}
