<?php
/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: databas.class.php
 * Desc: Class Databas for Projekt
 *
 * Robin Jönsson
 * rojn1700
 * rojn1700@student.miun.se
 ******************************************************************************/


class Databas
{

    private $dsn;
    private $user;
    private $password;
    private $dbname;
    private $pgdb;
    private $queryAnswer;
    private $result;

    public function __construct()
    {
        include "config.php";
        $this->dsn = $host;
        $this->user = $dbuser;
        $this->password = $dbpassword;
        $this->dbname = $database;
        $this->pgdb = pg_connect("host=" . $this->dsn . " user=" . $this->user . " password=" . $this->password . " dbname=" . $this->dbname);

    }

    public function queryToDb($pg_user_query)
    {
        if (isset($this->pgdb)) {
            $this->queryAnswer = pg_query($this->pgdb, $pg_user_query);
        }
    }

    public function getNextResult()
    {
        $this->result = pg_fetch_array($this->queryAnswer);
        return $this->result;
    }
}