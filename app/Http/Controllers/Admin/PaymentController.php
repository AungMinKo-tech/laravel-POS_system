<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    public function paymentList($action = "default")
    {
        $payments = Payment::select( 'payments.id','payments.account_name', 'payments.account_number', 'payments.type')
            ->when(request()->has('searchKey'), function ($query) {
                $search = request('searchKey');
                $query->where(function ($query) use ($search) {
                    $query  ->where('payments.account_name', 'like', '%' . $search . '%')
                            ->orWhere('payments.account_number', 'like', '%' . $search . '%')
                            ->orWhere('payments.type', 'like', '%' . $search . '%');
                });
            })
            ->orderby('payments.type', 'asc')
            ->get();
        return view('admin.payment.list', compact('payments'));
    }

    //create payment
    public function paymentCreate(Request $request)
    {

        $this->checkPaymentValidation($request);

        Payment::create([
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType
        ]);

        Alert::success('Success Title', 'ငွေပေးချေမှုကို အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');

        return back();
    }

    // delete payment
    public function deletePayment($id)
    {
        Payment::where('id', $id)->delete();

        return back();
    }

    //payment edit
    public function edit($id)
    {
        $payment = Payment::where('id', $id)->first();
        return view('admin.payment.edit', compact('payment'));
    }

    //payment update
    public function update($id, Request $request)
    {
        $request['id'] = $id; // Add id to the request for validation

        $this->checkPaymentValidation($request);

        Payment::where('id', $id)->update([
            'account_number' => $request->accountNumber,
            'account_name' => $request->accountName,
            'type' => $request->accountType
        ]);

        Alert::success('Success Title', 'ငွေပေးချေမှုကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return to_route('payment#list');
    }
    //check validation
    private function checkPaymentValidation($request)
    {
        $request->validate([
            'accountNumber' => 'required',
            'accountName' => 'required|string',
            'accountType' => 'required|string',
        ], [
            'accountNumber.required' => 'ငွေပေးချေမှုအကောင့်နံပါတ် လိုအပ်ပါသည်။',
            'accountName.required' => 'ငွေပေးချေမှုအကောင့်အမည် လိုအပ်သည်။',
            'accountType.required' => 'ငွေပေးချေမှုအမျိုးအစား လိုအပ်ပါသည်။'
        ]);
    }
}
