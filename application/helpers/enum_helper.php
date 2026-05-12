<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_enum_values')) {
    function get_enum_values($table, $field) {
        $CI =& get_instance();
        $query = $CI->db->query("SHOW COLUMNS FROM {$table} LIKE '{$field}'");
        $row = $query->row();
        if (!$row) return [];

        $type = $row->Type; // contoh: enum('Website','Mobile','Desktop')

        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        return explode("','", $matches[1]);
    }
}
