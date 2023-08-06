 <?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Models\User;
use Illuminate\Http\Request;

//project model//
class ChatController extends Controller
{

    public function chatlist(Request $request)
    {
        $record = LiveChat::groupBy('user_id')->orderBy('is_read', 'asc')->paginate(10);
        return $this->success($record, 'REQUEST_COMPLETE');

    }
    public function getChatNotification(Request $request)
    {

        $user = auth()->user();
        $record = LiveChat::where([
            ['message_type', '=', 'user'],
            ['is_read', '=', 0],
        ])->count();

        return $this->success($record, 'REQUEST_COMPLETE');

    }

    public function getChat(Request $request)
    {
        $user = auth()->user();
        $request->get('user_id');

        LiveChat::where([
            ['user_id', '=', $request->get('user_id')],
            ['message_type', '=', 'user'],
            ['is_read', '=', 0],
        ])->update([['is_read', 1]]);
        $record = LiveChat::where('user_id', $request->get('user_id'))->orderBy('id', 'desc')->paginate(10);

        return $this->success($record, 'REQUEST_COMPLETE');

    }

    public function sentChat(Request $request)
    {

        $user = auth()->user();

        $record = $request->only('message');

        $record['user_id'] = $user->id;

        LiveChat::create($record);

        return $this->success(true, 'REQUEST_COMPLETE');

    }
}
