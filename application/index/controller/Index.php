<?php
namespace app\index\controller;

use think\Session;

class Index
{
    public function index()
    {
        if ( ! Session::get('uid'))
        {
            return redirect('/Login')->remember();
        }

        return view('index', ['nickname' => Session::get('nickname'), 'uid' => Session::get('uid')]);
    }
}
