<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 17:04:32
 * Description: 策略模式（处理分支逻辑），根据业务来切换模式，比如根据用户性别显示不同的广告信息
 * 减少耦合关系，方便替换
 */
class FemaleUserStrategy implements UserStrategy{
    
    public function showAd() {
        echo '今年新款女装';
    }

    public function showCategory() {
        echo '女装';
    }

}
class MaleUserStrategy implements UserStrategy{
    
    public function showAd() {
        echo 'IPhone10';
    }

    public function showCategory() {
        echo '电子';
    }

}

interface UserStrategy{
    function showAd();
    function showCategory();
}