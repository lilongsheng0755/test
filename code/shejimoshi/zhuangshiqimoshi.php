<?php

/**
 * Author: skylong
 * CreateTime: 2018-8-4 18:06:23
 * Description: 装饰器模式,
 */
/**
 * 装饰器约定接口
 */
interface DrawDecorator {

    function beforeDraw();

    function afterDraw();
}

/**
 * 实现装饰器
 */
class Test implements DrawDecorator {

    protected $decorators = array();

    function show() {
        $this->beforeDraw();
        echo '呵呵哒！';
        $this->afterDraw();
    }

    function addDecorator(DrawDecorator $decorator) {
        $this->decorators[] = $decorator;
    }

    public function afterDraw() {
        $decorators = array_reverse($this->decorators);
        foreach ($decorators as $decorator) {
            $decorator->afterDraw();
        }
    }

    public function beforeDraw() {
        foreach ($this->decorators as $decorator) {
            $decorator->beforeDraw();
        }
    }

}
/**
 * 颜色装饰类
 */
class ColorDrawDecorator implements DrawDecorator {

    protected $color;

    function __construct($color) {
        $this->color = $color;
    }

    public function beforeDraw() {
        echo "<div style='color:{$this->color};'>";
    }
    
    public function afterDraw() {
        echo "</div>";
    }

}
/**
 * 文字大小装饰类
 */
class SizeDrawDecorator implements DrawDecorator {

    protected $size;

    function __construct($color) {
        $this->size = $color;
    }

    public function beforeDraw() {
        echo "<div style='font-size:{$this->size};'>";
    }
    
    public function afterDraw() {
        echo "</div>";
    }

}
$t = new Test();
$t->addDecorator(new ColorDrawDecorator('red'));
$t->addDecorator(new SizeDrawDecorator('20px'));
$t->show();