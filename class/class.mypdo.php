<?php
/**
 * Created by PhpStorm.
 * User: gg
 * Date: 2016/11/18
 * Time: 20:28
 */
class MyPDO{
    private $dbh;
    public function __construct($dsn,$user,$password){
        try {
            $this->dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    public function sRow($sql){
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $ret = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $ret[0];
    }
    public function sRows($sql){
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function dbInsert($sql){
        $sth = $this->dbh;
        $count = $sth->exec($sql);
        if($count){
            return true;
        }else {
            return false;
        }
    }
    //insert update
    public function dbIUD($sql){
        $sth = $this->dbh;
        $count = $sth->exec($sql);
        if($count){
            return true;
        }else {
            return false;
        }
    }
    public function dbUC($sql){
        $sth = $this->dbh;
        $count = $sth->exec($sql);
        if($count){
            return $count;
        }else {
            return false;
        }
    }

}