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
        $sql = "SELECT authme.*, luckperms_players.primary_group FROM authme LEFT JOIN luckperms_players on authme.username = luckperms_players.username WHERE username = '".$playerusername."'";
        return mysqli_query($this->conn, $sql);
    }
}