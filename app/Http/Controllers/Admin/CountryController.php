<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\GlobalCountry;
use App\Models\SystemBank;
use Illuminate\Http\Request;

class CountryController extends AdminBaseController
{
    public function coutryList(Request $request)
    {
        $db = GlobalCountry::select('*');
        $record = $db->orderBy('status', 'desc')->paginate(10);

        return $this->success([
            'record' => $record,
        ], '');
    }
    public function countryInfo(Request $request)
    {
        return $this->success([
            'record' => GlobalCountry::where('id', $request->get('id'))->first(),
        ], '');
    }
    public function countryControl(Request $request)
    {
        //buy,sell,status?1:0
        $data = $request->only('buy', 'sell', 'status');

        if ($request->get('id')) {
            GlobalCountry::where('id', $request->get('id'))->update($data);
        } else {
            GlobalCountry::create($data);
        }
        return $this->success('', 'REQUEST_COMPLETE');
    }

    public function bankList(Request $request)
    {
        $db = SystemBank::select('*');
        $record = $db->orderBy('id', 'desc')->paginate(10);
        $country = GlobalCountry::where('status', 1)->get();
        return $this->success([
            'record' => $record,
            'country' => $country,
        ], '');
    }

    public function bankInfo(Request $request)
    {
        return $this->success([
                'record' => SystemBank::where('id', $request->get('id'))->first(),
            ], 'REQUEST_COMPLETE');
    }
    public function bankControl(Request $request)
    {
        //bank_country = country id
        //is_display = 1/0
        $data = $request->only('bank_country', 'bank_name', 'bank_user', 'bank_number', 'branch', 'swift_code', 'is_display');

        if ($request->get('id')) {
            SystemBank::where('id', $request->get('id'))->update($data);
        } else {
            SystemBank::create($data);
        }
        return $this->success('', 'REQUEST_COMPLETE');
    }
}
