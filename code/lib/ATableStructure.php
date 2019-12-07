<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ATableStructure
 *
 * @author lilongsheng
 */
class ATableStructure {

    protected $table_name = '';
    protected $primary_key = '';
    protected $auto_increment = 0;
    protected $default_val = null;
    protected $is_null = 0;
    protected $field_type = '';
    protected $field_length = '';
    protected $unique_key = [];
    protected $index_key = [];
    protected $allow_field_type = ['int', 'bigint', 'tinyint', 'char', 'varchar', 'date', 'datetime', 'year', 'decimal', 'text'];

}
