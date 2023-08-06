<?php

namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Helper\Game\Casino2U;
use App\Helper\PaymentGateway\CryptedPay;
use App\Helper\PaymentGateway\Crypto5Pay;
use App\Helper\PaymentGateway\Yodgs;
use App\Helper\SendCloud;
use App\Http\Controllers\Controller;
use App\Models\SystemBank;
use App\Models\Uall;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\WithdrawCoin;
use Carbon\Carbon;
use Illuminate\Http\Request;

//project model//
class APIController extends Controller
{

    public function test(Request $request)
    {
        //$sms = new SmsSendCloud();

        //$sms->sendsms_curl('+60163593238', 897570);
        exit;
        $withdrawCoin = WithdrawCoin::where('id', 1)->first();

        $Crypto5Pay = new Crypto5Pay();
        return $Crypto5Pay->withdraw(10, $withdrawCoin->get_amount, $withdrawCoin);

        $Yodgs = new Yodgs();

        return $Yodgs->withdraw(10, 50);

        $casino = new Casino2U();

        return $casino->transfer(12, 1);

        dump(config('app.env'));
        exit;

        $user = User::where('id', '=', 1000001)->first();
        //  dump(Binaxtion::pull_capital('zx111222')); //
        exit;
        $sendCloud = new SendCloud();
        return $sendCloud->mailTemplate($user, 10, 'forget_password');
        // $this->smtp_mail('philiplim0928@gmail.com', 'Otp', 'Dear <br>Your OTP is 123');
        exit;
        return CryptedPay::withdraw('12131saca', 'ref', 1); //
        exit;

        exit;
        //Binaxtion::deposit('ibo', 100);

        $package = UserGroup::where('display', 1)->where('id', '=', 2)->first();
        Bonus::level_bonus(100, $user->id);
        exit;

        echo $user->check_cap(2000, 'matching');
        exit;
        //$this->introduce();
        $hour = Carbon::now()->format('H');

        // smtp_mail('philipli222m0928@gmail.com', 'Otp', 'Dear ' . $user->username . '.<br>Your OTP is 123');

        //  return $this->sendMail2('philiplim0928@gmail.com', 'Otp', 'Dear ' . $user->username . '.<br>Your OTP is 123');

        $base = 100;
        //     $r = Bonus::sponsor_bonus($base, $user->id);
        //    $r = Bonus::dynamic_bonus($base, $user->id);
        //return $user->checkDownline(1000045,'j');
        //DB::select('call sendBV("' . $user->id . '","' . (int)$user->package->bv . '")');
        // $r = $user->pushMobileNotification('diam7!', 'sohai la you!', 'Creator application approved');

        // $r = Bonus::single_static_bonus(1000007);
        //return $r;
    }
    public function introduce()
    {

        $list = User::where('id', '>', "99998")->get();

        for ($i = 0; $i < count($list); $i++) {

            $jie = Uall::where("user_id", $list[$i]->pid)->first();
            if ($jie) {

                $array = explode(",", $jie->p);
                array_shift($array);
                array_unshift($array, $list[$i]->pid);
                $data['p'] = "0," . implode(",", $array);
                Uall::where("user_id", $list[$i]->id)->update($data);
                echo $list[$i]->pid . ',';
            }
        }
        //$this->setplevel();
    }
    public function setplevel()
    {
        $list = M('users')->where('uid >99999')->select();
        for ($i = 0; $i < count($list); $i++) {
            $p = M('users')->where('uid=' . $list[$i]['pid'])->find();
            $data['plevel'] = $p['plevel'] + 1;
            M('users')->where('uid=' . $list[$i]['uid'])->save($data);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/project/get-deposit-bank",
     *     tags={"Project"},
     *     summary="getDepositBank",
     *     description="get deposit bank",
     *     operationId="getDepositBank",
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getDepositBank(Request $request)
    {

        $user = auth()->user();
        if ($request->get('country_id')) {
            $record = SystemBank::where('is_display', 1)->where('bank_country', $request->get('country_id'))->orderBy('id', 'desc')->get();
        } else {
            $record = SystemBank::where('is_display', 1)->orderBy('id', 'desc')->get();
        }

        return $this->success(
            ['system_bank' => $record,],
            ''
        );
    }
}
