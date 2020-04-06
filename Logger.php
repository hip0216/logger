<?php

//namespace Php\Exam\Logger;

class Logger{
   public $connection = null;
   function __construct($msg){
      $this->connection = new PDO('sqlite:syslog.sqlite3.db');
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $this->connection->exec("CREATE TABLE IF NOT EXISTS logs(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            level VARCHAR(10) NOT NULL,
            message TEXT NOT NULL
      );");
      }
   private function inner_use($name,$input){
      $insert="INSERT INTO logs (id,level,message) VALUES (:id,:level,:message)";
      $stmt=$this->connection->prepare($insert);
      $stmt->bindValue(':level',$name,PDO::PARAM_STR);
      $stmt->bindValue(':message',$input,PDO::PARAM_STR);
      $stmt->execute();
   }
   function debug($input){
      $this->inner_use("debug",$input);
   }
   function notice($input){
      $this->inner_use("notice",$input);
   }
   function critical($input){
      $this->inner_use("critical",$input);
   }
   function error($input){
      $this->inner_use("error",$input);
   }
   function info($input){
      $this->inner_use("info",$input);
   }
}

$a=new Logger([1,2,3]);
$a->debug("test1");
$a->notice("test2");
$a->critical("test3");
$a->error("test4");