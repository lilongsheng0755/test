<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 17:58:44
 * Description: 原型模式，适用于大对象的创建(需要初始很多数据的对象)；如果每次new一个大对象开销有点大
 * 原型模式仅需内存拷贝即可,例如:创建画布
 */

class Test{
    
}
$t = new Test();

$t1 = clone $t;
$t2 = clone $t;