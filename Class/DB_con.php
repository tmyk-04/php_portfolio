<?php
class DB_con
{
    // local
    // private const DB_URL = '';
    // private const DB_USER = '';
    // private const DB_PASS = '';
    // server
    private const DB_URL = '';
    private const DB_USER = '';
    private const DB_PASS = '';
    public function con()
    {
        try {
            //code...
            return new PDO(DB_con::DB_URL, DB_con::DB_USER, DB_con::DB_PASS);
        } catch (PDOException $e) {
            die("接続できません: " . $e->getMessage());
        }
    }
}