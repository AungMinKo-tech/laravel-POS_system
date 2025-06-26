<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\payment_history;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //direct user home page
    public function userHome()
    {
        $products = Product::select('products.id as product_id', 'products.name', 'products.price', 'products.description', 'products.image', 'products.category_id', 'categories.id', 'categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->when(request('categoryId'), function($query){
                                $query->where('products.category_id', request('categoryId'));
                            })
                            ->when(request('searchKey'), function($query){
                                $query->where('products.name', 'like', '%'.request('searchKey').'%');
                            })
                            //min = true | max = true
                            ->when(request('minPrice') != null && request('maxPrice') != null , function ($query) {
                                $query->whereBetween('products.price', [request('minPrice'), request('maxPrice')]);
                            })
                            //min = true | max = false
                            ->when(request('minPrice') != null && request('maxPrice') == null , function ($query) {
                                $query->where('products.price', '>=', request('minPrice'));
                            })
                            //min = false | max = true
                            ->when(request('minPrice') == null && request('maxPrice') != null , function ($query) {
                                $query->where('products.price', '<=', request('maxPrice'));
                            })
                            ->when(request('sortingType'), function($query){
                                $sortingRules = explode("," , request('sortingType'));
                                $query->orderBy('products.' . $sortingRules[0] , $sortingRules[1]); //(field name, asc desc)
                            })
                            ->get();

        $categories = Category::select('id', 'name')->get();

        return view('user.home',compact('products', 'categories'));
    }

    //driect product details page
    public function productDetails($id){

        $product = Product::select('products.id as product_id', 'products.name', 'products.price', 'products.description', 'products.image', 'products.stock', 'products.category_id', 'categories.id', 'categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->where('products.id', $id)
                            ->first();

                            // dd($product->toArray());

        $comments = Comment::select('comments.id as comment_id', 'comments.message', 'comments.created_at', 'users.id as user_id', 'users.profile', 'users.name', 'users.nickname')
                            ->where('comments.product_id',$id)
                            ->leftJoin('users','users.id','comments.user_id')
                            ->orderBy('comments.created_at','desc')
                            ->get();

        $stars = number_format(Rating::where('product_id', $id)->avg('count'));

        $userRating = number_format(Rating::where('product_id', $id)->where('user_id', Auth::user()->id)->value('count'));

        // dd($userRating);

        return view('user.details', compact('product','comments', 'stars', 'userRating'));
    }

    //comment
    public function comment(Request $request){
        Comment::create([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'message' => $request->comment
        ]);
        Alert::success('Title', 'Comment Created Successfully');
        return back();
    }

    //delete comment
    public function commentDelete($id){
        Comment::where('id', $id)->delete();
        return back();
    }

    //rating
    public function rating(Request $request)  {
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId,
        ],[
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'count' => $request->productRating
        ]);
        Alert::success('title', 'Thanks for rating');
        return back();
    }

    //direct cart page
    public function cart(){
        $cart = Cart::select('carts.id as card_id', 'carts.qty', 'products.id as product_id', 'products.name', 'products.price', 'products.image')
                ->leftJoin('products', 'carts.product_id', 'products.id')
                ->where('carts.user_id', Auth::user()->id)
                ->get();

        $total = 0;

        foreach($cart as $item){
            $total += $item->price * $item->qty;
        }

        // dd($cart->toArray());
        return view('user.cart', compact('cart','total'));
    }

    //add to cart
    public function addToCart(Request $request){
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->qty
        ]);

        Alert::success('Title', 'ကုန်ပစ္စည်းကို စျေးခြင်းတောင်းထဲသို့ ပေါင်းထည့်ခဲ့သည်။');
        return back();
        // dd($request->all());
    }

    //cart delete
    public function cartDelete(Request $request){

        $cartId = $request['cartId'];

        Cart::where('id', $cartId)->delete();

        return response()->json([
            'status' => 'success' ,
            'message' => 'cart success'
        ],200);
    }

    //temp storage
    public function tempStorage(Request $request){
        $orderTemp = [];

        foreach($request->all() as $item){
            array_push($orderTemp,[
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
                'finalAmt' => $item['finalAmt'],
            ]);
        }
        Session::put('tempCart', $orderTemp);

        return response()->json([
            'status' => 'success',
            'message' => 'temp storage store successfully'
        ],200);
    }

    //direct payment page
    public function paymentPage(){
        $paymentAcc = Payment::select('id', 'account_name', 'account_number', 'type')->orderby("type", 'asc')->get();
        $orderTemp = Session::get('tempCart');

        // dd($orderTemp);
        return view('user.payment',compact('paymentAcc', 'orderTemp'));
    }

    //order product
    public function order(Request $request){
        $request->validate([
            'name' => 'required|min:3|max:50',
            'phone' => 'required|numeric|min:8',
            'paymentType' => 'required',
            'address' => 'required|min:10|max:2000',
            'payslipImage' => 'required|mimes:jpg,jpeg,png,gif,webp,svg,heic,avif',
        ]);

        $orderTemp = Session::get('tempCart');

        // dd($orderTemp);

        $paymentHistoryData = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' =>$request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount
        ];

        if($request->hasFile("payslipImage")){
            $fileName = uniqid() . $request->file("payslipImage")->getClientOriginalName();
            $request->file("payslipImage")->move(public_path(). "/payslip_image/", $fileName);
            $paymentHistoryData["payslip_image"] = $fileName;
        }

        PaymentHistory::create($paymentHistoryData);

        foreach($orderTemp as $item){
            Order::create([
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code']
            ]);

            Cart::where('user_id', $item['user_id'])->where('product_id', $item['product_id'])->delete();
        }

        Alert::success('Thank for your order', 'Order Created Successfully');
        return to_route('user#orderList');
    }

    //direct to orderList
    public function orderList(){
        $orderList = Order::where('user_id', Auth::user()->id)
                    ->groupBy('order_code')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('user.orderList',compact('orderList'));
    }

    //direct to contact page
    public function contactPage(){
        return view('user.contact');
    }

    public function contact(Request $request){
        // dd($request->toArray());

        Contact::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'message' => $request->message
        ]);

        Alert::success('Thank for your contact', 'Message Sent Successfully!');
        return back();
    }
}
