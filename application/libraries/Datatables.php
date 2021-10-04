<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Datatables {

    static $db_host;
    static $db_name;
    static $db_user;
    static $db_pass;

    public function __construct()
    {
        self::$db_host = $GLOBALS['adflex']['db_host'];
        self::$db_name = $GLOBALS['adflex']['db_name'];
        self::$db_user = $GLOBALS['adflex']['db_user'];
        self::$db_pass = $GLOBALS['adflex']['db_pass'];
    }


    static function data_output($columns, $data)
    {
        $out = array();
        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();
            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];
                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];
                }
            }
            $out[] = $row;
        }
        return $out;
    }


    static function limit($request, $columns)
    {
        $limit = '';
        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        } else {
            $limit = "LIMIT 0, 10";
        }
        return $limit;
    }


    static function order($db, $request, $columns)
    {
        $order = '';
        if (isset($request['order']) && count($request['order'])) {
            $orderBy   = array();
            $dtColumns = self::pluck($columns, 'dt');
            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx     = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx     = array_search($requestColumn['data'], $dtColumns);
                $column        = $columns[$columnIdx];
                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                            'ASC' :
                            'DESC';

                    $column['db'] = $db->real_escape_string($column['db']);

                    $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }
            if (count($orderBy)) {
                $order = 'ORDER BY ' . implode(', ', $orderBy);
            }
        }
        return $order;
    }


    static function filter($db, $request, $columns)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns    = self::pluck($columns, 'dt');
        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];


            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx     = array_search($requestColumn['data'], $dtColumns);
                $column        = $columns[$columnIdx];
                if ($requestColumn['searchable'] == 'true') {

                    $str            = $db->real_escape_string($str);
                    $globalSearch[] = "`" . $column['db'] . "` LIKE '%" . $str . "%'";
                }
            }
        }
        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx     = array_search($requestColumn['data'], $dtColumns);
                $column        = $columns[$columnIdx];
                $str           = $requestColumn['search']['value'];
                if ($requestColumn['searchable'] == 'true' &&
                        $str != '') {

                    $str            = $db->real_escape_string($str);
                    $columnSearch[] = "`" . $column['db'] . "` LIKE '%" . $str . "%'";
                }
            }
        }
        // Combine the filters into a single string
        $where = '';
        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }
        if (count($columnSearch)) {
            $where = $where === '' ?
                    implode(' AND ', $columnSearch) :
                    $where . ' AND ' . implode(' AND ', $columnSearch);
        }
        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }

        return $where;
    }


    public function fetch($table, $primaryKey = null, $columns = null, $whereAll = array())
    {
        return self::complex($table, $primaryKey, $columns, false, $whereAll);
    }


    static function complex($table, $primaryKey, $columns, $whereResult = null, $whereAll = array())
    {
        $whereAll = self::where($whereAll);


        $request          = $_POST;
        $columns          = self::prep_columns($columns);
        $db               = self::sql_connect();
        $localWhereResult = array();
        $localWhereAll    = array();
        $whereAllSql      = '';
        // Build the SQL query string from the request
        $limit            = self::limit($request, $columns);
        $order            = self::order($db, $request, $columns);
        $where            = self::filter($db, $request, $columns);
        $whereResult      = self::_flatten($whereResult);

        $whereAll = self::_flatten($whereAll);
        if ($whereResult) {
            $where = $where ? $where . ' AND ' . $whereResult : 'WHERE ' . $whereResult;
        }

        if ($whereAll) {
            $where       = $where ? $where . ' AND ' . $whereAll : 'WHERE ' . $whereAll;
            $whereAllSql = 'WHERE ' . $whereAll;
        }
        // Main query to actually get the data
        $data = self::sql_exec($db, "SELECT `" . implode("`, `", self::pluck($columns, 'db')) . "`
			 FROM $table
			 $where
			 $order
			 $limit"
        );

        $recordsFiltered = self::sql_count($db, "SELECT COUNT(`{$primaryKey}`) FROM $table  $where");

        $recordsTotal = self::sql_count($db, "SELECT COUNT(`{$primaryKey}`) FROM  $table " . $whereAllSql);

        return array(
            "query"           => $_POST['search']['value'],
            "draw"            => isset($request['draw']) ? intval($request['draw']) : 0,
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data)
        );
    }


    static function prep_columns($columns)
    {
        $out = [];

        foreach ($columns as $value) {
            $out[] = ['db' => $value, 'dt' => $value];
        }

        return $out;
    }


    static function sql_connect()
    {
        $db = @new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);

        $db->set_charset("utf8");

        if ($db->connect_errno) {
            self::fatal("Error database connect!");
        }

        return $db;
    }


    static function sql_exec($db, $sql)
    {
        $out = [];

        //echo $sql;
        if ($result = $db->query($sql)) {

            while ($row = $result->fetch_array()) {
                $out[] = $row;
            }
        }

        return $out;
    }


    static function sql_count($db, $sql)
    {
        if ($result = $db->query($sql)) {

            $row = $result->fetch_row();

            return $row[0];
        }

        return 0;
    }


    static function fatal($msg)
    {
        echo json_encode(array(
            "error" => $msg
        ));
        exit(0);
    }


    static function pluck($a, $prop)
    {
        $out = array();
        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }
        return $out;
    }


    static function _flatten($a, $join = ' AND ')
    {
        if (!$a) {
            return '';
        } else if ($a && is_array($a)) {
            return implode($join, $a);
        }
        return $a;
    }


    static function where($array, $join = 'AND')
    {
        if (!is_array($array)) {
            return $array;
        }

        if (!$array) {
            return '';
        }

        $where = '';

        foreach ($array as $key => $value) {

            $key   = explode(' ', $key);
            $dir   = isset($key[1]) ? $key[1] : '=';
            $value = addslashes($value);

            $where .= "`{$key[0]}` {$dir} '{$value}' {$join} ";
        }

        return rtrim($where, "{$join} ") . " ";
    }


}
