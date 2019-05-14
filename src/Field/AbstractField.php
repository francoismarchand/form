<?php

namespace francoismarchand\form\Field;

abstract class AbstractField
{
    private $id;
    private $label;
    private $class;
    private $required = false;
    private $maxLength = 0;
    private $disabled = false;
    private $value;

    public function __construct(
        string $name,
        ?string $label = '',
        ?string $class = '',
        ?bool $required = false,
        ?int $maxLength = 0
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->class = $class;
        $this->required = $required;
        $this->maxLength = $maxLength;
    }

    public function getId(): string
    {
        return 'form_' . $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
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

    public function getClass(): string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getRequired(): bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    public function setMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function getDisabled(): string
    {
        return $this->disabled;
    }

    public function setDisabled(string $disabled): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): string
    {
        if (isset($this->type)) {
            return $this->type;
        }

        return '';
    }

    public function render(): string
    {

    }
}
