<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\Ticket;
use Auth;
use Illuminate\Http\Request;

class CustomerController extends AdminBaseController
{
    public function ticketList(Request $request)
    {
        $db = Ticket::select('*');
        $record = $db->orderBy('id', 'desc')->paginate(10);
        return $this->success([
            'record' => $record,
        ], '');
    }

    public function countRead(Request $request)
    {
        return $this->success([
            'record' => Ticket::where('admin_read', 0)->count(),
        ], '');
        return $this->jsonResponse([
            'code' => 0,
            'data' => [],
        ]);
    }

    public function markRead(Request $request)
    {
        $data['admin_read'] = 1;
        $record = Ticket::where('id', $request->get('id'))->update($data);
        return $this->success([
            'record' => $record,
        ], '');
    }

    public function ticketInfo(Request $request)
    {
        return $this->success([
            'record' => Ticket::where('id', $request->get('id'))->first(),
        ], '');
        return $this->jsonResponse([
            'code' => 0,
            'data' => [],
        ]);
    }

    public function ticketControl(Request $request)
    {
        $user = Auth::user();
        $data = $request->only('rebody');
        $data['ruid'] = $user->id;
        $data['re_time'] = date('Y-m-d h:i:s');
        $data['user_read'] = 0;
        $record = Ticket::where('id', $request->get('id'))->update($data);
        return $this->success([
            'record' => $record,
        ], '');
    }
}
