<?php

namespace Php\Exam;

use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface{
   private $connection=null;
   function __construct(){
      $this->connection=$connection;
      $createLogsTableInstruction="CREATE TABLE IF NOT EXISTS logs(
         id INTEGER PRIMARY KEY AUTOINCREMENT,
         level VARCHAR(10) NOT NULL,
         message TEXT NOT NULL
      );";
      $this->connection = new \PDO('sqlite:syslog.sqlite3');
      $this->connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
      $this->connection->exec($createLogsTableInstruction);
      }
   private function insertValuesToLogsTable($level,$message){
      $insertToLogsTable="INSERT INTO logs (id,level,message) VALUES (:id,:level,:message)";
      $insertSQLInstruction=$this->connection->prepare($insertToLogsTable);
      $insertSQLInstruction->bindValue(':level',$level,\PDO::PARAM_STR);
      $insertSQLInstruction->bindValue(':message',$message,\PDO::PARAM_STR);
      $insertSQLInstruction->execute();
   }
   public function debug($level,$message){
      $this->insertValuesToLogsTable($level,$message);
   }
   public function notice($level,$message){
      $this->insertValuesToLogsTable($level,$message);
   }
   public function critical($level,$message){
      $this->insertValuesToLogsTable($level,$message);
   }
   public function error($level,$message){
      $this->insertValuesToLogsTable($level,$message);
   }
   public function info($level,$message){
      
   }
}
