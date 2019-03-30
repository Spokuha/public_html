<?php
namespace application\lib;
use PDO; // PDO use for every DB, Mysql use only for mysqlDB
class Db
{

    protected $db;

    public function __construct()
    {
        // take array data with name,pass etc.
        $config = require 'application/config/db.php';

        // Connect to Mysql server
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].'',$config['user'],$config['password']);
    }

    public function query($sql, $params = []){

        //Check for SQL injection and protect

        // I cant understand how it works
        $stmt = $this->db->prepare($sql);
        if(!empty($params)){
            foreach ($params as $key => $val){
                $stmt->bindValue(':'.$key,$val); // bind sql query to $stmt
            }
        }
        $stmt->execute(); // execute sql query $stmt
        return $stmt;
    }

    public function row($sql, $params = []){
        $result = $this->query($sql,$params);
        return $result->fetchAll(PDO::FETCH_ASSOC); // return list of row

        //PDO::FETCH_ASSOC remove index from data
        // then: [name] => 'pavel', [0] => 'pavel'
        // now: [name] => 'pavel'
    }

    public function column($sql, $params = []){
        $result = $this->query($sql,$params);
        return $result->fetchColumn(); // return list of column
    }

}