<?php

namespace francoismarchand\form\Test\Type;

use francoismarchand\form\AbstractType;
use francoismarchand\form\Field\TextField;
use francoismarchand\form\Field\TextAreaField;
use francoismarchand\form\Field\SelectField;
use francoismarchand\form\Field\SubmitField;

class TotoType extends AbstractType
{
    private $categories;

    public function buildForm()
    {
        $this
            ->add(new TextField('title', 'Title', '', true))
            ->add(new TextAreaField('text', 'Text'))
            ->add((new SelectField('choice', 'Choice'))
                ->setOptions($this->categories)
                ->setDefault(0)
            )
            ->add(new SubmitField('submit', 'Ok'))
        ;
    }

    public function setData(array $options = [])
    {
        $this->categories = [
            '0' => 'Option1',
            '1' => 'Option2',
            '2' => 'Option3'
        ];
    }
}
