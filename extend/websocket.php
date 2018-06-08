<?php
/**
 * Created by PhpStorm.
 * User: wison
 * Date: 2018/6/8
 * Time: 12:51
 */

class Websocket
{
    private $serv;
    private $conn;

    public function __construct()
    {
        $database = require_once ('../application/database.php');
        $this->conn = mysqli_connect($database['hostname'],$database['username'],$database['password'],$database['database'], $database['hostport']) or die ('Connect mysql failed ~~'.mysqli_connect_error());
        $this->serv = new swoole_websocket_server('0.0.0.0', 9502);
        $this->serv->on('open', array($this,'onOpen'));
        $this->serv->on('message', array($this,'onMessage'));
        $this->serv->on('close', array($this,'onClose'));
        $this->serv->start();
    }

    public function onOpen($server, $request)
    {
        $this->unbindFd($request->get['uid']);
        $this->bindFd($request->get['uid'], $request->fd);
        echo "Welcome {$request->fd} \n";

        $sql = " select `fd` from `fd_tmp` where `uid` <> '{$request->get['uid']}' ";
        if($query = $this->conn->query($sql))
        {
            while ($row = mysqli_fetch_assoc($query))
            {
                if ($server->exist($row['fd']))
                {
                    $server->push($row['fd'], $this->to_json($request->get['uid'] . ' online', 2));
                }
            }
            mysqli_free_result($query);
        }
    }

    public function onMessage($server, $request)
    {
        $data = json_decode($request->data);
        $from_uid = $data->from_uid;
        $to_uid = $data->to_uid;
        $message = $data->message;
        $from_fd = $this->getFd($from_uid);
        if($from_fd) {
            $to_fd = $this->getFd($to_uid);
            if($to_fd) {
                $server->push($to_fd, $this->to_json($message));
            }
        } else {
            $server->push($request->fd, $this->to_json('from_fd not bind ~~', 0));
        }
    }

    public function onClose($server, $fd)
    {
        $this->unbindFd($fd);
        echo "Goodbye {$fd} \n";
    }

    //get fd
    public function getFd($uid)
    {
        $sql = " select `fd` from `fd_tmp` where `uid` = '{$uid}' ";
        if($query = $this->conn->query($sql)) {
            $row = mysqli_fetch_assoc($query);
            return $row['fd'] ? $row['fd'] : 0;
        } else {
            return 0;
        }
    }

    //bind fd
    public function bindFd($uid, $fd)
    {
        $sql = " delete from `fd_tmp` where `uid` = '{$uid}' ";
        if ( ! $this->conn->query($sql))
        {
            return 0;
        }
        $sql = " insert into `fd_tmp` (`fd`,`uid`) values ('{$fd}','{$uid}') ";
        if($this->conn->query($sql)) {
            return $fd;
        } else {
            return 0;
        }
    }

    //unbind fd
    public function unbindFd($fd)
    {
        $sql = " delete from `fd_tmp` where `fd` = '{$fd}' ";
        if($this->conn->query($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function to_json($data, $code = 1)
    {
        return json_encode(array('data' => $data, 'code' => $code));
    }
}

new Websocket();