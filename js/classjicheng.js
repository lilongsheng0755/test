/* 
 * class继承，ES6的编码方式【部分浏览器支持】
 */

/**
 * **************************************************
 *                     父类定义                     *
 * **************************************************
 */
class Student {

    /**
     * 构造方法，属性初始化
     * 
     * @param {type} name
     * @returns {Student}
     */
    constructor(name) {
        this.name = name;
    }

    hello() {
        alert('Hello, ' + this.name + '!');
    }
}

/**
 * **************************************************
 *                     子类定义                     *
 * **************************************************
 */
class PrimaryStudent extends Student {
    constructor(name, grade) {
        super(name); // 记得用super调用父类的构造方法!
        this.grade = grade;
    }

    myGrade() {
        alert('I am at grade ' + this.grade);
    }
}


