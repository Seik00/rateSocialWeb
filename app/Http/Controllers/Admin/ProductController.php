<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends AdminBaseController
{
    public function productList(Request $request)
    {
        $db = Product::select('*');
        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }
    public function getProductByPrice(Request $request)
    {
        $db = Product::select('*');
        if ($request->get('price')) {
            $updown = $request->get('price') * 0.1;
            $low = $request->get('price') - $updown;
            $high = $request->get('price') + $updown;
            $record = $db->where('status', 1)->whereBetween('price', [$low, $high])->get();
        } else {
            $record = $db->where('status', 1)->get();
        }

        return $this->success([
            'record' => $record,
        ], '');
    }
    public function productInfo(Request $request)
    {


        return $this->success([
            'record' => Product::where('id', $request->get('id'))->first(),
        ], '');
    }
    public function productControl(Request $request)
    {
        //price,name,name_en,file,status?1:0
        $data = $request->only('name', 'name_en', 'price', 'status');

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/image/product/' . date("Y-m-d"), $filename);
            $path = '/product/' . date("Y-m-d") . '/' . $filename;
            $data['image'] = $path;
        }

        if ($request->get('id')) {
            Product::where('id', $request->get('id'))->update($data);
        } else {
            Product::create($data);
        }
        return $this->success('', 'REQUEST_COMPLETE');
    }
}
