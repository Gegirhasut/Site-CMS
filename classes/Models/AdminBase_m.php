<?php
require_once('classes/Models/BaseModel.php');

class AdminBase_m extends BaseModel
{
    protected $query = "";

    /**
     * @param $table
     * @param string $fields
     * @return AdminBase_m
     */
    public function select($table, $fields = '*') {
        $this->query = "select $fields from $table";

        return $this;
    }

    /**
     * @param $condition
     * @return AdminBase_m
     */
    public function where($condition) {
        if (strpos($this->query, 'WHERE') !== false) {
            $this->query .= " AND $condition";
        } else {
            $this->query .= " WHERE $condition";
        }

        return $this;
    }

    /**
     * @param $join
     * @return AdminBase_m
     */
    public function join($join) {
        $this->query .= " JOIN $join";

        return $this;
    }

    /**
     * @param $join
     * @return AdminBase_m
     */
    public function rightJoin($join) {
        $this->query .= " RIGHT JOIN $join";

        return $this;
    }

    /**
     * @param $join
     * @return AdminBase_m
     */
    public function leftJoin($join) {
        $this->query .= " LEFT JOIN $join";

        return $this;
    }

    /**
     * @param $l1
     * @param null $l2
     * @return AdminBase_m
     */
    public function limit($l1, $l2 = null) {
        $this->query .= is_null($l2) ? " LIMIT $l1" : " LIMIT $l1, $l2";

        return $this;
    }

    /**
     * @param $field
     * @param bool $asc
     * @return AdminBase_m
     */
    public function orderBy($field, $asc = true) {
        if ($asc) {
            $this->query .= " ORDER BY $field ASC";
        } else {
            $this->query .= " ORDER BY $field DESC";
        }

        return $this;
    }

    /**
     * @param $by
     * @return AdminBase_m
     */
    public function groupBy($by) {
        $this->query .= " GROUP BY $by";

        return $this;
    }

    /**
     * @param $field
     * @return AdminBase_m
     */
    public function orderByNoDirection($field) {
        $this->query .= " ORDER BY $field";

        return $this;
    }

    public $union = '';

    /**
     * @return AdminBase_m
     */
    public function union() {
        $this->union .= '(' . $this->query . ') UNION ';
        $this->query = '';

        return $this;
    }

    /**
     * @return AdminBase_m
     */
    public function closeUnion() {
        if (!empty($this->union)) {
            $this->query = $this->union . '(' . $this->query . ')';
        }

        $this->union = '';

        return $this;
    }

    public function execute() {
        $this->executeQuery($this->query);
    }

    public function fetchAll($identity = null) {
        if (!empty($this->union)) {
            $this->query = $this->union . '(' . $this->query . ')';
        }

        $rows = parent::fetchAll($this->query, $identity);
        $this->union = '';
        return $rows;
    }

    public function fixTextareas($object, &$products) {
        $fields = array();

        foreach ($object['fields'] as $name => $field) {
            if ($field['type'] == 'textarea') {
                $fields[] = array ($name => $field['textarea']);
            }
        }

        if (!empty($fields)) {
            foreach ($products as &$product) {
                foreach ($fields as $fields_descriptions) {
                    foreach($fields_descriptions as $field => $value)
                    {
                        $product[$value] = str_replace("\r\n", "<br/>", $product[$field]);
                    }
                }
            }
        }
    }

    public function delete($table) {
        $this->query = "delete from $table";

        return $this;
    }

    public function truncate($table) {
        $this->query = "truncate table $table";

        return $this;
    }

    public function insert($object, $ignore = false) {
        $ignore = $ignore ? 'ignore' : '';

        $updateFields = $this->_getInsertSqls($object->fields, $fieldsValue, $values);

        $this->query = "insert $ignore into {$object->table} $fieldsValue values $values";

        $this->executeQuery($this->query);

        $id = $this->getInsertedId();

        if (!empty($updateFields))
            return $this->updateInsertedField($object, $updateFields);

        return $id;
    }



    public function update($object) {
        $updateFields = $this->_getUpdateSqls($object, $sets, $identity);

        $this->query = "update {$object->table} $sets $identity";

        $this->executeQuery($this->query);

        if (!empty($updateFields)) {
            $this->updateInsertedField($object, $updateFields);
        }
    }

    protected function updateInsertedField($object, $updateFields) {
        $id = null;
        if ($object->fields[$object->identity]['value'] == "NULL" || !isset($object->fields[$object->identity]['value'])) {
            $id = $this->getInsertedId();
            $object->fields[$object->identity]['value'] = $id;
        } else {
            $id = $object->fields[$object->identity]['value'];
        }

        foreach ($updateFields as $updateField) {
            $links = explode("-", $object->fields[$updateField]['link']);
            $link = "";

            foreach ($links as $l) {
                $link .= empty($link) ? $object->fields[$l]['value'] : "-" . $object->fields[$l]['value'];
            }

            if ($object->fields[$updateField]['type'] == 'img') {
                if (!empty($object->fields[$updateField]['value'])) {
                    $oldFile = $object->fields[$updateField]['value'];
                    $path_parts = pathinfo($oldFile);

                    $newFile = $this->translitIt($link) . "." . $path_parts['extension'];
                    $object->fields[$updateField]['value'] = $newFile;

                    if (file_exists($object->img['small_path'] . "/" . $newFile)) {
                        @unlink($object->img['small_path'] . "/" . $newFile);
                        @unlink($object->img['upload'] . "/" . $newFile);
                    }
                    rename($object->img['small_path'] . "/" . $oldFile, $object->img['small_path'] . "/" . $newFile);
                    rename($object->img['upload'] . "/" . $oldFile, $object->img['upload'] . "/" . $newFile);
                }
            } else {
                $object->fields[$updateField]['value'] = str_replace("--", "-", $this->translitIt($link));
            }

            if (isset($object->fields[$updateField]['value'])) {
                $query = "update {$object->table} set $updateField = '{$object->fields[$updateField]['value']}' where {$object->identity} = $id";
                $this->executeQuery($query);
            }
        }

        return $id;
    }

	protected function _getInsertSqls($fields, &$fieldsValue, &$values) {
	    $updateFields = array();

        $fieldsValue = "";
        $values = "";

        foreach ($fields as $name => $field) {
            if (isset($field['nofield'])) {
                continue;
            }
            if (isset($field['value'])) {
                $fieldsValue .= $name . ",";
                if ($field['value'] == "NULL") {
                    $values .= "{$field['value']},";
                } else {
                    $values .= "'{$field['value']}',";
                }
            }
            if (isset($field['link'])) {
                $updateFields[] = $name;
            }
        }
        $fieldsValue = rtrim($fieldsValue, ",");
        $fieldsValue = "($fieldsValue)";

        $values = rtrim($values, ",");
        $values = "($values)";

        return $updateFields;
    }

    protected function _getUpdateSqls($object, &$sets, &$identity) {
        $updateFields = array();

        $sets = "set ";
        $identity = "where ";

        foreach ($object->fields as $name => $field) {
            if (isset($field['nofield'])) {
                continue;
            }
            if (isset($field['value'])) {
                if ($name != $object->identity) {
                    $sets .= $this->setField($field['value'], $name) . ",";
                } else {
                    $identity .= $this->setField($field['value'], $name);
                }
            }

            if (isset($field['link']) && $field['type'] == 'img') {
                $updateFields[] = $name;
            }
        }
        $sets = rtrim($sets, ",");

        return $updateFields;
    }

    protected function setField($value, $name, $word = false) {
        if (strpos($value, "NULL") !== false) {
            return "$name = NULL";
        } else {
            return "$name = '$value'";
        }
    }

    protected function translitIt($str)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"jo","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"ju","я"=>"ja",
            "Ё" => "yo", "«" => "-", "»" => "-",
            " " => "-", "," => "-", "." => "", "?" => "", "!" => "",
            "/" => "-", "+" => "", "(" => "", ")" => "", "\"" => "", "’" => "",
            "*" => "-", "№" => "", "'" => "", "#" => "", "\\" => "", ":" => "-", "±" => "",
            "<" => "", ">" => ""
        );
        return strtolower(strtr($str,$tr));
    }
}