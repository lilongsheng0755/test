<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 17:33:46
 * Description: 观察者模式,当一个对象状态发生改变是，依赖它的对象全部都会收到通知，并自动更新
 * 场景：一个事件发生后，要执行一连串更新操作。传统的编程方式，就是在事件的代码之后直接加入处理逻辑。当更新的逻辑
 * 增多之后，代码就会变得难以维护。这种方式是耦合的，侵入式的，增加新的逻辑需要修改事件主体的代码
 */

class Event extends EventGenerator{
    function trigger(){
        echo "Event<br/>\n";
        
        //update
//        echo "逻辑1<br/>\n";
//        echo "逻辑2<br/>\n";
//        echo "逻辑3<br/>\n";
        $this->notify();
    }
}

abstract class EventGenerator{
    /**
     * 观察者
     * @var Observer
     */
    private $observers = array();
    function addObserver(Observer $observer){
        $this->observers[]=$observer;
    }
    function notify(){
        foreach ($this->observers as $observer){
            $observer->update();
        }
    }
}

interface Observer{
    function update($event_info = null);
}

class Observer1 implements Observer{
    
    public function update($event_info = null) {
        echo '逻辑1';
    }

}
class Observer2 implements Observer{
    
    public function update($event_info = null) {
        echo '逻辑2';
    }

}


$event = new Event;
$event->addObserver(new Observer1);
$event->addObserver(new Observer2);
$event->trigger();