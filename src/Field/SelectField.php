<?php

namespace francoismarchand\form\Field;

use francoismarchand\form\Field\AbstractField;

class SelectField extends AbstractField
{
    private $options = [];
    private $default;

    public function render(): string
    {
        $html = '';

        if (!empty($this->getLabel())) {
            $html .= sprintf(
                '<label id="%s_label" for="%s">%s</label>',
                $this->getId(),
                $this->getId(),
                $this->getLabel()
            );
        }

        $extras = '';
        if (!empty($this->getClass())) {
            $extras .= sprintf(' class="%s"', $this->getClass());
        }

        if (!empty($this->getMaxLength())) {
            $extras .= sprintf(' maxlength="%s"', $this->getMaxLength());
        }

        if ($this->getRequired()) {
            $extras .= ' required';
        }

        if ($this->getDisabled()) {
            $extras .= ' disabled';
        }

        return $html . sprintf(
            '<select id="%s" name="%s" value="%s"%s>%s</select>',
            $this->getName(),
            $this->getName(),
            $this->getValue(),
            $extras,
            $this->renderOptions()
        );
    }

    private function renderOptions(): string
    {
        $html = '';

        foreach ($this->options as $value => $label) {
            $selected = '';
            $selectedtValue = (empty($this->getValue())) ? $this->default  : $this->getValue();
            if ( $value == $selectedtValue) {
                $selected = ' selected';
            }

            $html .=  sprintf(
                '<option value="%s"%s>%s</options>',
                $value,
                $selected,
                $label
            );
        }

        return $html;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default): self
    {
        $this->default = $default;

        return $this;
    }
}
