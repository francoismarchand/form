<?php

namespace francoismarchand\form;

use Psr\Http\Message\ServerRequestInterface;

class Form
{
    const TYPE_INPUT = 0;
    const TYPE_TEXT = 1;
    const TYPE_EMAIL = 2;
    const TYPE_PASSWORD = 3;
    const TYPE_DATE = 4;
    const TYPE_HEURE = 5;
    const TYPE_CHECKBOX = 6;
    const TYPE_SELECT = 7;
    const TYPE_TEXTAREA = 8;
    const TYPE_SUBMIT = 9;

    private $name;
    private $method;
    private $action;
    private $submited = false;
    private $valid = false;
    private $html;
    private $errors;

    public function __construct(?string $name = 'form', ?string $method = 'POST', ?string $action = '')
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): string
    {
        $this->action $action;

        return $this;
    }

    public function setSubmited(bool $submited): self
    {
        $this->submited = $submited;
    }

    public function isSubmited(): bool
    {
        return $this->submited;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function createView(): string
    {
        $html = '';
        //form renderer

        return $html();
    }
}
