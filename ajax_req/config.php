<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/27
 * Time: 20:49
 */
namespace Common;
require_once '../class/class.mypdo.php';
class Config
{
    const
    ACCESS_KEY = 'jz6cvRXwY1vyWWAX6AEL6B4rRzgBTrIHm_u8Z3xp',
    SECRET_KEY = '1cEnusTXzjh_7uE3grZ11FxW4QRBEYWkVBjp3v--',
    BUCKET_NAME = 'ggjk';
}
class myDb extends \MyPDO
{
    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=qspace;charset=utf8';
        $user = 'root';
        $password = '58737d9134';
        parent::__construct($dsn,$user,$password);
    }

}

