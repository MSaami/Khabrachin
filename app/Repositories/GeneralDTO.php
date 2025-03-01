<?php

namespace App\Repositories;

class GeneralDTO
{
    public function loadFromArray(array $loadableArray)
    {
        $class_vars = get_class_vars(get_class($this));
        foreach ($class_vars as $field => $value) {
            if (isset($loadableArray[$field])) {
                $this->$field = $loadableArray[$field];
            }
        }
    }
}
