<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\User;
use App\Models\UserRobotPackage;
use Illuminate\Http\Request;

class PackageController extends AdminBaseController
{

    public function userRobotPackage(Request $request)
    {
        $db = UserRobotPackage::select('*');
        if ($request->get('username')) {

            $user = User::where('username', $request->get('username'))->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $request->get('username'))->where('role_id', 2)->first();
            }

            if ($user) {
                $db->where('user_id', $user->id);
            } else {
                $db->where('user_id', -1);
            }
        }
        $record = $db->orderBy('id', 'desc')->paginate(10);

        return $this->success([
            'record' => $record,
        ], '');
    }
}
