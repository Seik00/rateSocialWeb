<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Common\AdminBaseController;
use App\Models\Deposit;
use App\Models\DynamicBonus;
use App\Models\FundTransfer;
use App\Models\SpecialBonus;
use App\Models\SponsorBonus;
use App\Models\StaticBonus;
use App\Models\User;
use App\Models\WalletReloadRecord;
use App\Models\WithdrawCoin;
use Illuminate\Http\Request;

class ExportController extends AdminBaseController
{
    public function exportUser(Request $request)
    {
        $db = User::select('*');
        $db->where('role_id', 2);
        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->get();
        $export['data'] = array();
        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['id'] = $record[$i]->id;
            $export['data'][$i]['username'] = $record[$i]->username;
            $export['data'][$i]['fullname'] = $record[$i]->fullname;
            $export['data'][$i]['email'] = $record[$i]->email;
            $export['data'][$i]['rank'] = $record[$i]->rank->rank_name_en;
            $export['data'][$i]['package'] = $record[$i]->package->package_name_en;
            if (isset($record[$i]->sponsor->username)) {
                $export['data'][$i]['sponsor'] = $record[$i]->sponsor->username;
            } else {
                $export['data'][$i]['sponsor'] = '';
            }

            $export['data'][$i]['point1'] = $record[$i]->point1;
            $export['data'][$i]['point2'] = $record[$i]->point2;
            $export['data'][$i]['add_time'] = $record[$i]->created_at;
        }

        $export['title'] = ['Id', 'Username', 'FullName', 'Email','Rank', 'Package', 'Sponsor', 'Insurance Wallet', 'Cash wallet', 'Join time'];

        return $this->exportExcel($export['title'], $export['data'], 'UserList');

    }
    public function exportWallet(Request $request)
    {
        $db = FundTransfer::select('*');
        $wallet_type = $this->wallet_type();
        if ($request->get('wallet') == 'point2') {
            $db->where(function ($q) {
                $q->where('in_type', 2)
                    ->orWhere('out_type', 2);
            });
            $wallet = $wallet_type[2]['comments_en'];

        } else {
            $db->where(function ($q) {
                $q->where('in_type', 1)
                    ->orWhere('out_type', 1);
            });
            $wallet = $wallet_type[1]['comments_en'];

        }

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->get();

        $export['data'] = array();
        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['previous'] = $record[$i]->previous;
            $export['data'][$i]['current'] = $record[$i]->action . ' ' . $record[$i]->found;
            $export['data'][$i]['after'] = $record[$i]->current;

            $export['data'][$i]['detail'] = $record[$i]->detail;
            $export['data'][$i]['add_time'] = $record[$i]->created_at;
        }

        $export['title'] = ['Username', 'Before', 'Current', 'After', 'Detail', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], $request->get('username') . '_' . $wallet);

    }

    public function exportBonus(Request $request)
    {
        $bonus_type = $this->bonus_type();

        if ($request->get('bonus') == 'sponsor_bonus') {
            $db = SponsorBonus::select('*');
            $bonus = $bonus_type[0];
        } elseif ($request->get('bonus') == 'dynamic_bonus') {
            $db = SpecialBonus::select('*');
            $bonus = $bonus_type[1];
        } elseif ($request->get('bonus') == 'special_bonus') {
            $db = StaticBonus::select('*');
            $bonus = $bonus_type[2];
        } elseif ($request->get('bonus') == 'level_bonus') {
            $db = DynamicBonus::select('*');
            $bonus = $bonus_type[3];
        }

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->get();
        $export['data'] = array();
        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['founds'] = $record[$i]->founds;
            $export['data'][$i]['detail'] = $record[$i]->detail;
            $export['data'][$i]['add_time'] = $record[$i]->add_time;
        }

        $export['title'] = ['Username', 'Amount', 'Detail', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], $bonus['bonus_cn']);
    }
    public function exportWithdrawList(Request $request)
    {
        $db = WithdrawCoin::select('*');
        $db->where('status', 0);
        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->get();

        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['amount'] = $record[$i]->amount;
            $export['data'][$i]['get_amount'] = $record[$i]->get_amount;
            $export['data'][$i]['fee'] = $record[$i]->fee;
            $export['data'][$i]['address'] = $record[$i]->address;
            $export['data'][$i]['date'] = $record[$i]->created_at;
        }

        $export['title'] = ['Username', 'Amount', 'Amount after deduction', 'Fee', 'Address', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], 'WithdrawalList');
    }
    public function exportWithdrawHis(Request $request)
    {
        $db = WithdrawCoin::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->get();

        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['amount'] = $record[$i]->amount;
            $export['data'][$i]['get_amount'] = $record[$i]->get_amount;
            $export['data'][$i]['fee'] = $record[$i]->fee;
            $export['data'][$i]['address'] = $record[$i]->address;
            $export['data'][$i]['txid'] = $record[$i]->txid;
            $export['data'][$i]['status_remark'] = $record[$i]->status_remark;
            $export['data'][$i]['date'] = $record[$i]->created_at;
        }

        $export['title'] = ['Username', 'Amount', 'Get Amount', 'Fee', 'Address', 'txid', 'Status', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], 'WithdrawalHis');
    }
    public function exportReloadRecord(Request $request)
    {
        $db = WalletReloadRecord::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->get();

        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['amount'] = $record[$i]->amount;
            $export['data'][$i]['address'] = $record[$i]->address;
            $export['data'][$i]['txid'] = $record[$i]->txid;
            $export['data'][$i]['date'] = $record[$i]->created_at;
        }

        $export['title'] = ['Username', 'Amount', 'Address', 'txid', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], 'ReloadRecord');
    }
    public function exportTransactionRecord(Request $request)
    {
        $this->validate($request, [
            'wallet' => 'required',
        ]);
        if ($request->get('wallet') == 'point1') {
            $wallet = 1;
        } else if ($request->get('wallet') == 'point2') {
            $wallet = 2;
        } else if ($request->get('wallet') == 'point3') {
            $wallet = 3;
        } else if ($request->get('wallet') == 'point4') {
            $wallet = 4;
        } else {
            $wallet = 10;
        }
        $db = FundTransfer::select('*');
        $username = $request->get('username');
        if ($username) {

            $user = User::where('username', $username)->where('role_id', 2)->first();
            if (!$user) {
                $user = User::where('id', $username)->where('role_id', 2)->first();
            }

            if ($user) {
                $db->where('user_id', $user->id);
            } else {
                $db->where('user_id', -1);
            }
        }

        if ($wallet) {
            $db->where(function ($q) use ($wallet) {
                $q->where('in_type', $wallet)
                    ->orWhere('out_type', $wallet);
            });
        }

        if ($request->get('start_date')) {
            $db->whereBetween('created_at', [$request->get('start_date') . ' 00:00:00', $request->get('end_date') . ' 23:59:59']);
        }

        if ($request->get('found_type')) {
            $found_type = explode(",", $request->get('found_type'));
            $db->wherein('found_type', $found_type);
        }
        $record = $db;

        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['fullname'] = $record[$i]->user->fullname;
            $export['data'][$i]['previous'] = $record[$i]->previous;
            $export['data'][$i]['amount'] = $record[$i]->amount;
            $export['data'][$i]['current'] = $record[$i]->current;
            $export['data'][$i]['detailen'] = $record[$i]->detailen;
            $export['data'][$i]['date'] = $record[$i]->created_at;
        }

        $export['title'] = ['Username', 'Fullname', 'Previous Balance', 'Amount', 'Current Balance', 'Details', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], 'TransactionRecord');
    }
    public function exportDeposit(Request $request)
    {
        $db = Deposit::select('*');

        $db = $this->search_record($db, $request);

        $record = $db->orderBy('id', 'desc')->with('system_bank')->get();

        for ($i = 0; $i < count($record); $i++) {
            $export['data'][$i]['username'] = $record[$i]->user->username;
            $export['data'][$i]['bank'] = $record[$i]->system_bank->bank_name . '<br>' . $record[$i]->system_bank->bank_user . '<br>' . $record[$i]->system_bank->bank_number;
            $export['data'][$i]['amount'] = 'USD' . $record[$i]->amount;
            $export['data'][$i]['currency'] = $record[$i]->country->short_form . '' . $record[$i]->pay_amount;
            $export['data'][$i]['image'] = $record[$i]->uploaded_file[0]->public_image_path;
            $export['data'][$i]['status'] = $record[$i]->status_remark;
            $export['data'][$i]['datetime'] = $record[$i]->created_at;
        }

        $export['title'] = ['Username', 'Bank', 'Amount', 'Currency', 'Image link', 'Status', 'date time'];

        return $this->exportExcel($export['title'], $export['data'], 'Deposit');
    }
}
