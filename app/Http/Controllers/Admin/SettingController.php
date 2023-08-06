<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\GlobalSetting;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SettingController extends AdminBaseController
{
    public function systemConfig(Request $request)
    {
        $global = GlobalSetting::get()->toArray();


        return $this->success([
            'record' => $global,
        ], '');
    }

    public function saveConfig(Request $request)
    {
        $userInput = $request->all();
        foreach ($userInput as $key => $item) {
            $model = GlobalSetting::where('global_key', $key)->first();
            if ($model) {
                $model->key_value = $item;
                $model->save();
            }
        }
        return $this->success('', 'REQUEST_COMPLETE');
    }

    public function packageConfig(Request $request)
    {
        $db = UserGroup::select('*');
        $record = $db->where('display', 1)->get();

        return view('admin.setting.packageConfig')
            ->with('record', $record);
    }

    public function savePackage(Request $request)
    {
        $data = $request->only('package_name_en', 'package_name');

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $filename = time() . $file->getClientOriginalName();
            $file->storeAs('public/uploaded_package/' . date("Y-m-d"), $filename);
            $path = 'public/uploaded_package/' . date("Y-m-d") . '/' . $filename;
            $data['icon'] = $path;
        }

        UserGroup::where('id', $request->get('package_id'))->update($data);


        return $this->success(true, 'REQUEST_COMPLETE');
    }
}
