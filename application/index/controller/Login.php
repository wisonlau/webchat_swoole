<?php
namespace app\index\controller;

use app\index\model\Users;
use think\Request;
use think\Session;

class Login
{
    public function index()
    {
        return view('index');
    }

    public function do_login()
    {
        $param = Request::instance()->post();
        $user = Users::get(['nickname' => $param['nickname'], 'username' => $param['username'], 'password' => md5($param['password'])]);

        if($user) {
            $now = date('Y-m-d H:i:s');

            $user->login_time = $now;
            $user->login_num  = ($user->login_num) + 1;
            $user->save();

            Session::set('uid', $user['id']);
            Session::set('nickname', $user['nickname']);

            echo json_encode(array('data' => 1));
        } else {
            echo json_encode(array('data' => 0));
        }

        exit;
    }
}
