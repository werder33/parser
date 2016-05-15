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
class People
{
    protected $db;


    public function __construct()
    {
        $this->db = DataBase::getInstance();

    }



    public function getPeople()
    {
        $arr = [];
        $sql = "SELECT * FROM names ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
                    $arr[$key] = $value;
           /* foreach ($value as $k => $v) {
                $arr[$k] = $v;
            }*/

        }
        return $arr;
    }

}