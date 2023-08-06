<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

//project model//
class TeamController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/team/robotTeam",
     *     tags={"Team"},
     *     summary="",
     *     description="Robot Team",
     *     operationId="robotTeam",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function robotTeam(Request $request)
    {
        $user = auth()->user();
        $data = array();
        $data['direct_active'] = User::where('pid', $user->id)->where('pin', '>', 0)->count();
        $data['direct_noactive'] = User::where('pid', $user->id)->where('pin', 0)->count();
        $active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $user->id . "%') and pin >0 "));
        $no_active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $user->id . "%') and pin =0 "));
        $data['team_active'] = $active[0]->total;
        $data['team_noactive'] = $no_active[0]->total;
        $data['team_list'] = User::where('pid', $user->id)->paginate(10);
        return $this->success($data,'');
    }
    /**
     * @OA\Get(
     *     path="/api/team/teamRevenue",
     *     tags={"Team"},
     *     summary="",
     *     description="Robot Team",
     *     operationId="teamRevenue",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *   *      @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="default is #",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *   *      @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="default is #",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function teamRevenue(Request $request)
    {
        $user = auth()->user();
        $data = array();
        $user = User::where('pid', $user->id)->get();
        if ($request->get('start_date')) {
            $where = ' and (ctime>="' . $request->get('start_date') . ' 00:00:00" and ctime<="' . $request->get('end_date') . ' 23:59:59")';
        } else {
            $where = '';
        }
        for ($i = 0; $i < count($user); $i++) {
            $data[$i]['id'] = $user[$i]['id'];
            $data[$i]['name'] = $user[$i]['username'];
            // $revenue = DB::select(DB::raw("SELECT coalesce(SUM(revenue),0)  as revenue FROM jl_quant_robot_revenue WHERE uid = " . $user[$i]['id'] . " " . $where));
            $data[$i]['revenue'] = $revenue[0]->revenue;
        }

        return $this->success($data,'');
    }
    /**
     * @OA\Get(
     *     path="/api/team/downline-new",
     *     tags={"Team"},
     *     summary="",
     *     description="refferal downline new",
     *     operationId="downlineNew",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="parent",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function downlineNew(Request $request)
    {

        $db = User::select('*');
        $me = auth()->user();
        if ($request->get('parent') == '#') {
            $user = auth()->user();
        } else {
            $user = User::where('id', $request->get('parent'))->first();
        }

        if ($user) {
            //  $db->where('p_level', '<=', $me->p_level + 3);
            $db->where('pid', $user->id);
            $all = $db->get();
        } else {
            $all = array();
        }

        $data = array();

        $total_sales = 0;
        if (count($all) > 0) {
            for ($i = 0; $i < count($all); $i++) {
                $team = DB::table('u_all')->where('p', 'like', '%' . $all[$i]->id . '%')->count('user_id');
                $active = DB::select(DB::raw("SELECT count('id') as total FROM users WHERE id in (select user_id from u_all where p like '%" . $all[$i]->id . "%') "));
                $pay = DB::select(DB::raw("SELECT COALESCE(SUM(price),0) as total FROM user_package WHERE status = 1 and user_id in (select user_id from u_all where p like '%" . $all[$i]->id . "%') "));

                $data[] = array
                    (
                    "id" => $all[$i]->id,
                    "p" => $request->get('parent'),
                    "username" => $all[$i]->username,
                    "package" => $all[$i]->package->package_name,
                    "package_en" => $all[$i]->package->package_name_en,
                    "package_icon" => $all[$i]->package->public_image_path,
                    "total_sponsor" => $all[$i]->total_sponsor,
                    "team" => $team,
                    "join_date" => $all[$i]->created_at->toDateString(),
                    "active" => $active[0]->total,
                    "sales" => $pay[0]->total,
                    "rank" => $all[$i]->rank->rank_name,
                    "rank_en" => $all[$i]->rank->rank_name_en,
                );
            }
        }

        return $this->success($data,'');
    }
    /**
     * @OA\Get(
     *     path="/api/team/downline",
     *     tags={"Team"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="downline",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="parent",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function downline(Request $request)
    {

        $db = User::select('*');

        if ($request->get('parent') == '#') {
            $user = auth()->user();
        } else {
            $user = User::where('id', $request->get('parent'))->first();
        }

        if ($user) {
            $db->where('pid', $user->id);
            $all = $db->get();
        } else {
            $all = array();
        }

        $data = array();
        $total_sales = 0;
        if (count($all) > 0) {
            for ($i = 0; $i < count($all); $i++) {
                $data[] = array
                    (
                    "id" => $all[$i]->id,
                    "p" => $request->get('parent'),
                    "text" => $all[$i]->username . "[" . $all[$i]->package->package_name . "](L('SALES'):" . $total_sales . ")",
                    "icon" => "fa fa-user",
                    "children" => true,
                    "type" => "root",
                );
            }
        } else {
            $add_childs = __('site.Register');
            $data[] = array
                (
                "id" => $request->get('parent'),
                "icon" => "fa fa-plus-square icon-state-default",
                "text" => $add_childs,
                "children" => false,
            );
        }
        return $this->success($data,'');
    }
    /**
     * @OA\Get(
     *     path="/api/team/organize",
     *     tags={"Team"},
     *     summary="",
     *     description="refferal downline",
     *     operationId="downline",
     *     deprecated=false,
     *     security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *         name="parent",
     *         in="query",
     *         description="default is #",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function organize(Request $request)
    {

        $db = User::select('*');
        $user = auth()->user();

        if ($request->get('parent') != '#') {
            $check_user = $user->checkDownline($request->get('parent'), 'j');
            $user = $check_user ? User::where('id', $check_user->user_id)->first() : $user;
        }

        $data = array();
        $data[0] = $this->get_team($user->id);
        $data[1] = $this->get_team($user->id, 'group_left');
        $data[2] = $this->get_team($user->id, 'group_right');
        $data[3] = $this->get_team($user->group_left, 'group_left');
        $data[4] = $this->get_team($user->group_left, 'group_right');
        $data[5] = $this->get_team($user->group_right, 'group_left');
        $data[6] = $this->get_team($user->group_right, 'group_right');

        if ($data[3]['username'] == '') {
            $data[7] = $this->get_team(0, 'group_left');
            $data[8] = $this->get_team(0, 'group_right');

        } else {
            $lv3 = User::where('id', $data[3]['parrent'])->first();
            $data[7] = $this->get_team($lv3->id, 'group_left');
            $data[8] = $this->get_team($lv3->id, 'group_right');
        }

        if ($data[4]['username'] == '') {
            $data[9] = $this->get_team(0, 'group_left');
            $data[10] = $this->get_team(0, 'group_right');

        } else {
            $lv4 = User::where('id', $data[4]['parrent'])->first();
            $data[9] = $this->get_team($lv4->id, 'group_left');
            $data[10] = $this->get_team($lv4->id, 'group_right');
        }
        if ($data[5]['username'] == '') {

            $data[11] = $this->get_team(0, 'group_left');
            $data[12] = $this->get_team(0, 'group_right');

        } else {
            $lv5 = User::where('id', $data[5]['parrent'])->first();
            $data[11] = $this->get_team($lv5->id, 'group_left');
            $data[12] = $this->get_team($lv5->id, 'group_right');

        }

        if ($data[6]['username'] == '') {

            $data[13] = $this->get_team(0, 'group_left');
            $data[14] = $this->get_team(0, 'group_right');
        } else {
            $lv6 = User::where('id', $data[6]['parrent'])->first();
            $data[13] = $this->get_team($lv6->id, 'group_left');
            $data[14] = $this->get_team($lv6->id, 'group_right');
        }

        return $this->success($data,'');
    }
    public function get_team($user_id, $position = 'middle')
    {
        if ($user_id == 0) {
            return array
                (
                "parrent" => 0,
                'username' => '',
                'package' => '',
                'left_point' => 0,
                'right_point' => 0,
                'total_lv' => 0,
                'total_rv' => 0,
                'image' => '/images/package/MEMBER.png',
            );
        }
        $user = User::where('id', $user_id)->first();
        if ($position != 'middle') {

            if ($user->$position == 0) {
                return array
                    (
                    "parrent" => 0,
                    'username' => '',
                    'package' => '',
                    'left_point' => 0,
                    'right_point' => 0,
                    'total_lv' => 0,
                    'total_rv' => 0,
                    'image' => '/images/package/MEMBER.png',
                );
            } else {
                $user = User::where('id', $user->$position)->first();
                return array
                    (
                    "parrent" => $user->id,
                    'username' => $user->username,
                    'package' => $user->package->package_name,
                    'left_point' => $user->left_point,
                    'right_point' => $user->right_point,
                    'total_lv' => $user->left_point,
                    'total_rv' => $user->right_point,
                    'image' => $user->package->icon,
                );
            }

        } else {
            return array
                (
                "parrent" => $user->id,
                'username' => $user->username,
                'package' => $user->package->package_name,
                'left_point' => $user->left_point,
                'right_point' => $user->right_point,
                'total_lv' => $user->left_point,
                'total_rv' => $user->right_point,
                'image' => $user->package->icon,
            );
        }

    }
}
