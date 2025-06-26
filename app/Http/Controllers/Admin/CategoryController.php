<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    //display category list
    public function list(){
        $categories = Category::orderBy('created_at','desc')->paginate(5);
        return view('admin.category.list', compact('categories'));
    }

    //create category
    public function create(Request $request){
        $this->checkValidation($request);

        Category::create([
            'name' => $request->categoryName,
        ]);

        Alert::success('Success Title','အမျိုးအစားအမည်ကို အောင်မြင်စွာ ထည့်သွင်းပြီးပါပြီ။');

        return back();
    }

    //delete category
    public function delete($id){
        Category::where('id', $id)->delete();

        return back();
    }

    //edit category
    public function edit($id){
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }

    //update category
    public function update($id,Request $request){
        $request['id'] = $id; // Add id to the request for validation

        $this->checkValidation($request);

        Category::where('id', $id)->update([
            'name' => $request->categoryName,
        ]);

        Alert::success('Success Title', 'အမျိုးအစားအမည်ကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return to_route('category#List');
    }

    //check validation
    public function checkValidation($request){
        $request->validate([
            'categoryName' => 'required|min:3|max:30|unique:categories,name,'.$request->id
        ], [
            'categoryName.required' => 'ကျေးဇူးပြု၍ အမျိုးအစားအမည်ကို ထည့်သွင်းပါ။',
            'categoryName.min' => 'အမျိုးအစားအမည်သည် အနည်းဆုံး စာလုံး 3 လုံးရှိရမည်။',
            'categoryName.max' => 'အမျိုးအစားအမည်သည် စာလုံး 20 ထက်မပိုရပါ။',
        ]);
    }
}
