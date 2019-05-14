<?php

namespace francoismarchand\form\Field;

use francoismarchand\form\Field\AbstractField;

class SubmitField extends AbstractField
{
    public function render(): string
    {
        $extras = '';
        if (!empty($this->getClass())) {
            $extras = sprintf(' class="%s"', $this->getClass());
        }

        return sprintf(
            '<button type="submit" id="%s" name="%s"%s>%s</button>',
            $this->getName(),
            $this->getName(),
            $extras,
            $this->getLabel()
        );
    }
}
