<?php

namespace Php\Exam;

use Psr\Log\LoggerInterface;

/**
 * this class give to run.php use
 */
class Logger implements LoggerInterface
{
    protected $connection = null;
    /**
    *this method when class load will create database syslog.sqlite3 and create table logs
    */
    public function __construct()
    {
        $this->connection = $connection = null;
        $createLogsTableInstruction = "CREATE TABLE IF NOT EXISTS logs(
         id INTEGER PRIMARY KEY AUTOINCREMENT,
         level VARCHAR(10) NOT NULL,
         message TEXT NOT NULL
      );";
        $this->connection = new \PDO('sqlite:syslog.sqlite3');
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->connection->exec($createLogsTableInstruction);
    }
    /**
    *this method give to run.php insert attribute to logs table
    */
    private function insertValuesToLogsTable($useFuncName, $context)
    {
        $insertToLogsTable = "INSERT INTO logs (level,message) VALUES (:level,:message)";
        $insertSQLInstruction = $this->connection->prepare($insertToLogsTable);
        $insertSQLInstruction->bindValue(':level', $useFuncName, \PDO::PARAM_STR);
        $insertSQLInstruction->bindValue(':message', $context, \PDO::PARAM_STR);
        $insertSQLInstruction->execute();
    }
    /**
    *these method from LoggerInterface implements to  run.php insert attribute
    */
    public function debug($message, array $context = array())
    {
        $this->insertValuesToLogsTable('debug', $message);
    }
    public function notice($message, array $context = array())
    {
        $this->insertValuesToLogsTable('notice', $message);
    }
    public function critical($message, array $context = array())
    {
        $this->insertValuesToLogsTable('critical', $message);
    }
    public function error($message, array $context = array())
    {
        $this->insertValuesToLogsTable('error', $message);
    }
    public function info($message, array $context = array())
    {
        $this->insertValuesToLogsTable('info', $message);
    }
    /**
    *these method from LoggerInterface implements are not give to run.php
    */
    public function warning($message, array $context = array())
    {
    }
    public function alert($message, array $context = array())
    {
    }
    public function emergency($message, array $context = array())
    {
    }
    public function log($level, $message, array $context = array())
    {
    }
}
