<?php

class DriverSQL
{
    private $hostname = 'opluckycraft.it';
    private $username = 'minecraft';
    private $password = '34gAGozv2U0Pq97TCg';
    private $database = 'minecraft';
    private $conn = null;

    function __construct()
    {
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
    }

    function getConn(){
        return $this->conn;
    }

    function getPlayerInfo($playerusername){
        if ($this->conn == null) return "Can connect db";
        $sql = "SELECT authme.*, luckperms_players.* FROM authme LEFT JOIN luckperms_players on authme.username = luckperms_players.username WHERE authme.username = '".$playerusername."'";
        return mysqli_query($this->conn, $sql);
    }
    function getPlayerStats($playerusername){
        if ($this->conn == null) return "Can connect db";
        $sql = "SELECT statz_kills_players.*, statz_deaths.*, statz_time_played.* FROM statz_kills_players JOIN statz_deaths on statz_kills_players.uuid = statz_deaths.uuid JOIN statz_time_played on statz_kills_players.uuid = statz_time_played.uuid WHERE statz_kills_players.uuid = '".mysqli_fetch_array($this->getPlayerInfo($playerusername))['uuid']."'";
        return mysqli_query($this->conn, $sql);
    }

}