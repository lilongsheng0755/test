<?php

/**
 * Author: skylong
 * CreateTime: 2018-6-20 14:59:27
 * Description: 
 */
/* ------------添加memcached连接池------------- */
$m = new Memcached();
$m->addServers(
        array(
            array('127.0.0.1', 11211),
            array('127.0.0.1', 11212),
            array('127.0.0.1', 11213),
            array('127.0.0.1', 11214),
        )
);


/* ------------把数据写入缓存中--------------- */
//$mysqli  = new mysqli('127.0.0.1', 'test', 'test', 'test');
//$showNum = 1000;
//$mc      = microtime(true);
//for ($page = 1; $page <= 1000; $page++) {
//    $offset = ($page - 1) * $showNum;
//    $sql    = "SELECT * FROM `baseinfo` LIMIT $offset,$showNum";
//    $res    = $mysqli->query($sql);
//    while ($row    = $res->fetch_assoc()) {
//        $m->set('UID_' . $row['uid'], json_encode($row));
//    }
//}
//echo microtime(true) - $mc;
//
//$mysqli->close();
//var_dump($m->getStats());
//$arr = array();
//$mc  = microtime(true);
//for ($i = 1; $i <= 1000000; $i++) {
//    if (empty($m->get('UID_' . $i))) {
//        $arr[] = 'UID_' . $i;
//    }
//}
//var_dump($arr, microtime(true) - $mc);
//var_dump($m->get('UID_1000'));