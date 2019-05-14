# Form

Simple OOP Form builder width PSR-7 request

## Basic usage

```php

//Psr\Http\Message\ServerRequestInterface
$request = ServerRequest::fromGlobals();
$toto = new Toto();

$form = $builder->create($request, TotoType::class, $toto);

if ($form->isSubmited()) {
    if ($form->isValid()) {
        $this->fail('Form should not be valid');
    }

    echo $form->getErrors();
}

echo $form->createView();
```

```php
class Toto
{
    private $title;
    private $text;
    private $choice;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    ...
}
```

```php
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
```
