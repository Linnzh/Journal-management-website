<?php

/**
 * 微信小程序端
 * 
 * 获取 article 的 HTML 字符串及其他信息：title time favorite html
 * 路径：app/applet/article_get_html.php
 * 方法：getHtml()
 * 
 * 返回：title time favorite html
 */


require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use app\data\Connection;
// use app\lib\Utils;

$aid = $_GET['aid'] ?? 0;
$conn = Connection::getInstance('../config/journalDB.php');

if($aid) {

    $sql = 'SELECT `title`, `recevied_date` AS `time`, `file_url` AS `url` FROM `article` WHERE `aid` = ' . $aid;
    $stmt = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    if($stmt) {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/src/issues/' . basename($stmt['url']);
        $stmt['html'] = file_get_contents($path);
        echo json_encode($stmt, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    } else {
        $tips = '查询出错！';
        echo json_encode($tips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

} else {
    $tips = '未接收到数据！';
    echo json_encode($tips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}