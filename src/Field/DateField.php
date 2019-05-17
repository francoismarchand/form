<?php

namespace francoismarchand\form\Field;

use francoismarchand\form\Field\InputField;

class DateField extends InputField
{
    protected $type = 'date';

    public function render(): string {
        if (!empty($this->getValue())) {
            $this->setValue(
                $this->getValue()->format('Y-m-d')
            );
        }

        return parent::render();
    }
}
