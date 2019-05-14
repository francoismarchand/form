<?php

namespace francoismarchand\form;

use francoismarchand\form\Form;
use francoismarchand\form\Field\FileField;

class Renderer
{
    private $html = '';

    public function __construct(Form $form)
    {
        $formContent = '';

        foreach ($form->getFields() as $field) {
            $formContent .= $field->render();
        }

        $this->html = sprintf(
            '<form id="%s" method="%s" action = "%s"%s>
                %s
            </form>'
            ,
            $form->getName(),
            $form->getMethod(),
            $form->getAction(),
            $this->enctype($form->getFields()),
            $formContent
        );
    }

    public function enctype(array $fields): string
    {
        foreach ($fields as $field) {
            if ($field->getType() == 'file') {
                return '  enctype="multipart/form-data"';
            }
        }

        return '';
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}
