<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 11.05.2016
 * Time: 13:02
 */

namespace app\Models;

use core\DataBase;
use PDO;
use PDOException;

class People
{
    protected $db;


    public function __construct()
    {

    }

    public function getPeople()
    {
        $db = DataBase::getInstance();
        $arr = [];
        $sql = "SELECT * FROM names ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
            $arr[$key] = $value;

        }
        return $arr;
    }

    public function saveResult($arr = [], $user_id)
    {
        $db = DataBase::getInstance();
        $title = $arr['title'];
        $snippet = $arr['snippet'];
        $url = $arr['url'];

        $sql = "INSERT INTO result (user_id, title, url, snippet) VALUES (:user_id, :title, :url, :snippet)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':user_id' => $user_id,
            ':title' => $title,
            ':url' => $url,
            ':snippet' => $snippet,
        ));
        echo "SAVE \n";

    }

    public function getResult()
    {
        $db = DataBase::getInstance();
        $arr = [];
        $sql = 'Select user_id from result order by user_id desc';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll();
        foreach ($row as $key => $value) {
            $arr[$key] = $value[0];

        }
        return $arr;

    }

    public function getPeopleLimit($start, $end){

        $db = DataBase::getInstance();
        $arr = [];
        $sql = "SELECT * FROM names LIMIT $start,$end";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
            $arr[$key] = $value;

        }
        return $arr;


    }

}