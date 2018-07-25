<?php

/**
 * Author: skylong
 * CreateTime: 2018-7-23 20:49:49
 * Description: 自定义模板引擎类
 */
class MyTpl {

    /**
     * 模板文件目录
     *
     * @var string 
     */
    public $template_dir = 'templates';

    /**
     * 通过模板引擎组合后文件存放目录
     *
     * @var string
     */
    public $compile_dir = 'templates_c';

    /**
     * 模板中嵌入动态数据左定界符
     *
     * @var string
     */
    public $left_delimiter = '<{';

    /**
     * 模板中嵌入动态数据右定界符
     *
     * @var string
     */
    public $right_delimiter = '}>';

    /**
     * 内部使用的临时变量
     *
     * @var array
     */
    private $tpl_vars = array();

    /**
     * 数据分配到tpl_vars属性中，用于模板变量替换
     * 
     * @param string $tpl_var
     * @param mixed $value
     */
    public function assign($tpl_var, $value = null) {
        ($tpl_var != '') && $this->tpl_vars[$tpl_var] = $value;
    }

    /**
     * 加载模板文件，并通过模板引擎生成完整的页面
     * 
     * @param string $file_name 模板文件名
     */
    public function display($file_name) {
        $tpl_file = $this->template_dir . DIRECTORY_SEPARATOR . $file_name;
        if (!file_exists($tpl_file)) {
            die("模板文件{$tpl_file}不存在");
        }
        $compile_file_name = $this->compile_dir . DEIRECTORY_SEPARATOR . "com_{$file_name}.php";
        if (!file_exists($compile_file_name) || filemtime($compile_file_name) < filemtime($tpl_file)) {
            $replace_content = $this->tpl_replace(file_get_contents($tpl_file));
            file_put_contents($compile_file_name, $replace_content);
        }
        include($compile_file_name);
    }
    
    /**
     * 将模板文件内容替换
     * 
     * @param string $content
     * @return string
     */
    private function tpl_replace($content) {
        $left    = preg_quote($this->left_delimiter, '/');
        $right   = preg_quote($this->right_delimiter, '/');
        $pattern = array(
            '/' . $left . '\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*' . $right . '/i',
            '/' . $left . '\s*if\s*(.+?)\s*' . $right . '(.+?)' . $left . '\s*\/if\s*' . $right . '/ies',
            '/' . $left . '\s*else\s*if\s*(.+?)\s*' . $right . '/ies',
            '/' . $left . '\s*else\s*' . $right . '/is',
            '/' . $left . '\s*loop\s+\$(\S+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff])\s*' . $right . '(.+?)' . $left . '\s*\/loop\s*' . $right . '/is',
            '/' . $left . '\s*loop\s+\$(\S+)\s+\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff])\s*=>\s*\$(\S+)\s*' . $right . '(.+?)' . $left . '\s*\/loop\s*' . $right . '/is',
            '/' . $left . '\s*include\s+[\"\']?(.+?)[\"\']?\s*' . $right . '/ie',
        );

        $replacement     = array(
            '<?php echo $this->tpl_vars["${1}"]; ?>',
            '<?php $this->stripvtags(\'<?php if(${1}) { ?>\',\'${2}<?php }?>\')>',
            '<?php $this->stripvtags(\'<?php } elseif(${1}) { ?>\',"")>',
            '<?php }else{ ?>',
            '<?php foreach($this->tpl_vars["${1}"] as $this->tpl_vars["${2}"]){ ?>${3} <?php } ?>',
            '<?php foreach($this->tpl_vars["${1}"] as $this->tpl_vars["${2}"] => $this->tpl_vars["${3}"]){ ?>${4} <?php } ?>',
            '<?php file_get_contents($this->template_dir.DEIRECTORY_SEPARATOR."${1}") ?>',
        );
        $replace_content = preg_replace($pattern, $replacement, $content);
        if (preg_match('/' . $left . '([^(' . $right . ')]{1,})' . $right . '/', $replace_content)) {
            $replace_content = $this->tpl_replace($replace_content);
        }

        return $replace_content;
    }

    /**
     * 变量替换成对应的值
     * 
     * @param string $expr
     * @param string $statement
     * @return string
     */
    private function stripvtags($expr, $statement = '') {
        $var_pattern = '/\s*\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\s*/is';
        $expr        = preg_replace($var_pattern, '$this->tpl_vars["${1}"]', $expr);
        $expr        = str_replace("\\\"", "\"", $expr);
        $statement   = str_replace("\\\"", "\"", $statement);
        return $expr . $statement;
    }

}
