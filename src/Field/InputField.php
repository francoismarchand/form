<?php

namespace francoismarchand\form\Field;

use francoismarchand\form\Field\AbstractField;

class InputField extends AbstractField
{
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

        $html .= sprintf(
            '<input id="%s" type="%s" name="%s" value="%s"%s/>',
            $this->getId(),
            $this->getType(),
            $this->getName(),
            $this->getValue(),
            $extras
        );

        return $html;
    }
}
