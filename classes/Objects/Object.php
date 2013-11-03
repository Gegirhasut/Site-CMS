<?php
/**
 * Created by JetBrains PhpStorm.
 * User: максим
 * Date: 03.11.13
 * Time: 2:18
 */
class Object {
    public function __construct() {
        $reflection = new ReflectionClass(get_class($this));
        $properties = $reflection->getProperties();

        if ( ! empty($properties) )
            foreach ( $properties as $property )
                if ( $property->isStatic() ) {
                    $propertyName = $property->getName();
                    $this->{$propertyName} = $property->getValue();
                }
    }
}