<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\Deposit;
use App\Models\DepositCoin;
use App\Models\Ticket;
use App\Models\WalletReloadRecord;
use App\Models\WithdrawCash;
use App\Models\WithdrawCoin;
use DB;
use Illuminate\Http\Request;

class DashboardController extends AdminBaseController
{
    public function home(Request $request)
    {
        $result = array();
        /*
        $request->get('from')
        $request->get('to')
         */
        $bonus_type = $this->bonus_type();
        for ($i = 0; $i < count($bonus_type); $i++) {
            $table = $this->search_record(DB::table($bonus_type[$i]['key'])->select('*'), $request);
            $bonus_type[$i]['total'] = $table->sum('founds');
        }
        $total_withdraw = WithdrawCoin::select('*');
        $total_deposit = WalletReloadRecord::select('*');

        $total_withdraw = $this->search_record($total_withdraw, $request);
        $total_deposit = $this->search_record($total_deposit, $request);

        $result['total_deposit'] = $total_deposit->sum('amount');
        $result['total_withdraw'] = $total_withdraw->sum('amount');

        $result['from'] = $request->get('from');
        $result['to'] = $request->get('to');

        return $this->success([
            'record' => $result,
            'bonus_type' => $bonus_type,
        ], '');
    }
    public function header(Request $request)
    {

        $result['total_withdraw'] = WithdrawCoin::where('status', 0)->count();
        $result['total_withdraw'] += WithdrawCash::where('status', 0)->count();
        $result['total_deposit'] = Deposit::where('status', 0)->count();
        $result['total_deposit'] += DepositCoin::where('status', 0)->count();
        $result['total_ticket'] = Ticket::where('admin_read', 0)->count();
        
        return $this->success([
            'record' => $result,
        ], '');
    }
}
