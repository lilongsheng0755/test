<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 15:58:43
 * Description: SPL标准库演示，几种常用的数据结构
 */
//栈的概念，先进后出：栈内存首先是一片内存区域，存储的都是局部变量
$stack = new SplStack();
$stack->push("data1\n");
$stack->push("data2\n");
echo $stack->pop();
echo $stack->pop();

//队列的概念，先进先出
$queue = new SplQueue();
$queue->enqueue("data1\n");
$queue->enqueue("data2\n");
echo $queue->dequeue();
echo $queue->dequeue();

//堆的概念，数据可以提取：存储的是数组和对象
$heap = new SplMinHeap();
$heap->insert("data1\n");
$heap->insert("data2\n");
echo $heap->extract();
echo $heap->extract();

//固定长度的数组
$array    = new SplFixedArray(10);
$array[0] = 123;
$array[9] = 123;
var_dump($array);
