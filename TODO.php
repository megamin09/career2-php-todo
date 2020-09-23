<?php

date_default_timezone_set('Asia/Tokyo');
 
require 'vendor/autoload.php';

use Dotenv\Dotenv;

class Todo
{
    private $dotenv;
    private $dbh;

    const STATUS = [
        '未着手',
        '作業中',
        '完了',
    ];

    // コンストラクタ
    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__);
        $this->dotenv->load();

        $this->dbh = new PDO('mysql:dbname='.$_ENV['DB_NAME'].';host=localhost:8111', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    }

    /**
     * タスクを昇順に取得する
     * @return array
     */
    public function getList()
    {
        $stmt = $this->dbh->query("SELECT * FROM `todo` WHERE `deleted_at` IS NULL ORDER BY `due_date` ASC");
        return array_map(function ($todo) {
            $todo["status"] = intval($todo["status"]);
            $todo["status_for_display"] = self::STATUS[$todo["status"]];
            return $todo;
        }, $stmt->fetchAll());
    }

    /**
     * タスクを保存する
     * @param string $title
     * @param string $due_date
     */
    public function post(string $title, string $due_date)
    {
        $stmt = $this->dbh->prepare("INSERT INTO `todo` (title, due_date) VALUES (:title, :due_date)");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
        $stmt->execute();
    }

    /*タスクの削除*/ 
    public function delete()
    {
        $sql = "UPDATE `todo` SET `deleted_at` = NOW()";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
    }


    /**
     * 進捗を更新する
     * @param string $id
     * @param string $status
     */
    public function update(int $id, int $status)
    {
        $sql = "UPDATE `todo` SET status = :status WHERE id = :id"; //指定したidのデータを取得
        $stmt = $this->dbh->prepare($sql);                          //sqlの実行準備
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);               //データのセット
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);       //データのセット
        $stmt->execute();                                           //更新
    }

}