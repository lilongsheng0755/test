<?php

/**
 * Author: skylong
 * CreateTime: 2018-7-7 21:19:58
 * Description:
 */

/**
 * 清除cookie数据
 *
 * @param $cookie
 */
function clearCookie($cookie)
{
    setcookie($cookie, '', time() - 3600, '/');
}

/**
 * 清除session数据
 */
function clearSession()
{
    //第一步
    session_start();
    //第二步
    $_SESSION = [];
    //第三步
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    //第四步
    session_destroy();
}

/**
 * 计算范围内的日期
 *
 * @param string $start_date 开始日期
 * @param string $end_date   结束日期
 *
 * @return array             返回范围内的所有日期
 */
function calcDate($start_date, $end_date)
{
    $start_time = strtotime($start_date);
    $end_time = strtotime($end_date);
    $arr = [];
    for ($i = $start_time; $i <= $end_time; $i += 86400) {
        $arr[] = date('Y-m-d', $i);
    }
    return $arr;
}

$arr = calcDate('2019-12-18', '2020-03-03');
krsort($arr);
echo implode('\',\'', $arr);