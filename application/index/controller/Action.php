<?php
namespace app\index\controller;

use app\index\model\Chat;
use app\index\model\FdTmp;
use app\index\model\Friend;
use app\index\model\Users;
use think\Db;
use think\Request;
use think\Session;

class Action
{
    public function __construct()
    {
        if ( ! Session::get('uid'))
        {
            return redirect('/Login')->remember();
        }
    }

    public function index()
    {
        $param = Request::instance()->post();
        switch ($param['type'])
        {
            case 'addFriend':
                $ret = self::addFriend($param['from_uid'], $param['to_uid']);
                break;
            case 'friendLists':
                $ret = self::friendLists($param['from_uid']);
                break;
            case 'loadHistory':
                $ret = self::loadHistory($param['from_uid'], $param['to_uid']);
                break;
            case 'sendMessage':
                $ret = self::sendMessage($param['from_uid'], $param['to_uid'], $param['message']);
                break;
            default:
                echo json_encode(array('data'=>''));
                exit;
        }

        if ($ret)
        {
            self::to_json($ret);
        }
        else
        {
            self::to_json($ret, $ret);
        }

    }

    private static function addFriend($from_uid, $to_uid)
    {
        $friend = Friend::get(['from_uid' => $from_uid, 'to_uid' => $to_uid]);
        if ($friend)
        {
            if( ! $friend['to_uid'])
            {
                if($from_uid == $to_uid)
                {
                    return 2;
                }
                else
                {
                    $ret = Users::get(['id' => $to_uid]);
                    if ($ret)
                    {
                        $nickname = $ret['nickname'];
                        if($nickname)
                        {
                            $friend = new Friend();
                            $friend->from_uid = $from_uid;
                            $friend->to_uid   = $to_uid;
                            $friend->nickname = $nickname;
                            $friend->save();

                            return array('to_uid' => $to_uid, 'nickname' => $nickname);
                        }
                        else
                        {
                            return 3;
                        }
                    }
                }
            }
            else
            {
                return 4;
            }
        }
        else
        {
            return 0;
        }
    }

    private static function friendLists($from_uid)
    {
        $sql = " select `id`,`nickname` from `users` where `id` != '{$from_uid}' ";
        $users = Db::query($sql);
        if($users) {
            $lists = [];
            $fd_tmp = (new FdTmp())->select();
            $fd_tmps = array();
            if ($fd_tmp)
            {
                foreach ($fd_tmp as $val)
                {
                    $fd_tmps[$val['uid']] = $val['fd'];
                }
            }

            foreach ($users as $value)
            {
                $value['status'] = empty($fd_tmps[$value['id']]) ? 'offline' : 'online';
                $lists[] = $value;
            }

            return $lists;
        } else {
            return 0;
        }
    }

    private static function loadHistory($from_uid, $to_uid)
    {
        $sql = " select `from_uid`,`to_uid`,`message`,`send_time` from `chat` where  ( (`from_uid` = '{$from_uid}' and `to_uid` = '{$to_uid}') or (`to_uid` = '{$from_uid}' and `from_uid` = '{$to_uid}') ) order by `send_time` desc";
        $query = Db::query($sql);
        if($query) {
            return $query;
        } else {
            return 0;
        }
    }

    private static function sendMessage($from_uid, $to_uid, $message)
    {
        $time = date('Y-m-d H:i:s');
        $chat           = new Chat();
        $chat->from_uid = $from_uid;
        $chat->to_uid   = $to_uid;
        $chat->message  = $message;
        $chat->send_time= $time;
        $chat->save();
        if($chat->id) {
            return $chat->id;
        } else {
            return 0;
        }
    }

    public static function to_json($data, $code = '-1')
    {
        echo json_encode(array('code' => $code,'data'=>$data));
        exit;
    }

}
