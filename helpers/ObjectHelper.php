<?php
class ObjectHelper {
    public static function FillObject(&$obj, $record) {
        foreach ($obj->fields as $fieldName => &$fieldDescription) {
            if (isset($record[$fieldName])) {
                $fieldDescription['value'] = $record[$fieldName];
            }
        }
    }
}