<?php

namespace francoismarchand\form;

use francoismarchand\form\Field\AbstractField;

abstract class AbstractType
{
    private $fields = [];
    protected $id = 'form';
    protected $method = 'POST';
    protected $action = null;

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

    public function getId()
    {
        return $this->id;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getAction()
    {
        return $this->action;
    }
}
