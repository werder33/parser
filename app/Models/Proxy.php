<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 19.05.2016
 * Time: 9:15
 */

namespace app\Models;

use core\DataBase;
use PDO;
use PDOException;

class Proxy
{
    public function saveProxy($proxies)
    {

        $db = DataBase::getInstance();
        $stmt = $db->prepare('INSERT INTO proxy (ip) VALUES (:ip)');
        try {
            $db->beginTransaction();
            foreach ($proxies as $proxy) {
                // echo $proxy."\n";
                $stmt->bindValue(':ip', trim(strip_tags($proxy)));
                $stmt->execute();
            }
            $db->commit();
        } catch (PDOException $e) {
            $db->rollBack();
        }
    }

    public function saveOneProxy($ip)
    {
        $db = DataBase::getInstance();


        $sql = "INSERT INTO proxy (ip) VALUES (:ip)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':ip' => $ip
        ));
        echo "SAVE \n";
    }


    public function getProxy()
    {
        $db = DataBase::getInstance();
        $arr = [];
        $sql = "SELECT * FROM proxy ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
            $arr[$key] = $value;

        }
        return $arr;

    }

    public function updateProxy($id)
    {
        $db = DataBase::getInstance();
        $sql = "UPDATE proxy SET status = 'good'
                                       WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':id' => $id,));
        echo "UPDATE \n";
    }


    public function clearProxy()
    {
        $sql = "TRUNCATE TABLE proxy";
        $db = DataBase::getInstance();
        $db->query($sql);
    }


    public function getGoodProxy()
    {
        $db = DataBase::getInstance();
        $sql = "SELECT * FROM proxy WHERE status = 'good'";
        $stm = $db->query($sql);
        $arr = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $arr;
    }

    public function getProxyLimit($start, $end)
    {
        $db = DataBase::getInstance();
        $arr = [];
        $sql = "SELECT * FROM proxy LIMIT $start,$end";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($row as $key => $value) {
            $arr[$key] = $value;

        }
        return $arr;
    }
}
