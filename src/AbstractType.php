<?php

namespace francoismarchand\form;

use francoismarchand\form\Field\AbstractField;

abstract class AbstractType
{
    private $fields = [];

    public function buildForm()
    {

    }

    public function setData()
    {

    }

    public function add(AbstractField $field): self
    {
        $this->fields [] = $field;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
}
