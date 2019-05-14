<?php

namespace francoismarchand\form\Field;

use francoismarchand\form\Field\AbstractField;

class TextAreaField extends AbstractField
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

        return $html . sprintf(
            '<textarea id="%s" name="%s" %s>%s</textarea>',
            $this->getId(),
            $this->getName(),
            $extras,
            $this->getValue()
        );
    }
}
