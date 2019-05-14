<?php

namespace francoismarchand\form;

use francoismarchand\form\Form;
use francoismarchand\form\Field\FileField;

class Renderer
{
    private $form;
    private $html = '';

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function render(?string $fieldName = ''): string
    {
        if (empty($fieldName)) {
            $formContent = '';
            foreach ($this->form->getFields() as $field) {
                $formContent .= $field->render();
            }

            return $this->begin() . $formContent . $this->end();
        }

        return $this->form->getField($fieldName)->render();
    }

    public function begin(): string
    {
        return sprintf(
            '<form id="%s" method="%s" action ="%s"%s>',
            $this->form->getName(),
            $this->form->getMethod(),
            $this->form->getAction(),
            $this->enctype()
        );
    }

    public function end(): string
    {
        return '</form>';
    }

    private function enctype(): string
    {
        foreach ($this->form->getFields() as $field) {
            if ($field->getType() == 'file') {
                return '  enctype="multipart/form-data"';
            }
        }

        return '';
    }
}
