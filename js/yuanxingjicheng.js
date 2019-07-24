/* 
 * 原型继承
 */

/**
 * 实现原型继承
 * 
 * @param {type} Child  子类
 * @param {type} Parent 父类
 * @returns {Boolean}
 */
function inherits(Child, Parent) {
    Child.prototype = Object.create(Parent.prototype);
    Child.prototype.constructor = Child;
    return true;
}

/**
 * 父类构造函数
 * 
 * @param {type} props
 * @returns {Student}
 */
function Student(props) {
    this.name = props.name || 'Unnamed';
}

/**
 * 公共方法绑定
 * 
 * @returns {Boolean}
 */
Student.prototype.hello = function () {
    alert('Hello, ' + this.name + '!');
    return true;
};

/**
 * 子类构造函数
 * 
 * @param {type} props
 * @returns {PrimaryStudent}
 */
function PrimaryStudent(props) {
    Student.call(this, props); // 继承属性
    this.grade = props.grade || 1;
}

// 实现原型继承链:
inherits(PrimaryStudent, Student);

// 绑定其他方法到PrimaryStudent原型:
PrimaryStudent.prototype.getGrade = function () {
    return this.grade;
};

// 创建xiaoming:
var xiaoming = new PrimaryStudent({
    name: '小明',
    grade: 2
});
xiaoming.name; // '小明'
xiaoming.grade; // 2

// 验证原型:
xiaoming.__proto__ === PrimaryStudent.prototype; // true
xiaoming.__proto__.__proto__ === Student.prototype; // true

// 验证继承关系:
xiaoming instanceof PrimaryStudent; // true
xiaoming instanceof Student; // true