<?php

namespace francoismarchand\form;

use fesseeo\form\Form;

abstract class AbstractType
{
    private $fields = [];

    public function buildForm()
    {
        $fields = [

        ]
    }

    private function getFields(): array
    {
        return $this->fields();
    }
}
