<?php

namespace francoismarchand\form;

use Psr\Http\Message\ServerRequestInterface;
use francoismarchand\form\Renderer;
use francoismarchand\form\Field\AbstractField;
use francoismarchand\form\Field\FileField;

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
    const TYPE_HIDDEN = 10;
    const TYPE_FILE = 11;

    private $object;
    private $request;
    private $name;
    private $method;
    private $action;
    private $submited = false;
    private $valid = false;
    private $fields = [];
    private $errors = '';

    public function __construct(?string $name = 'form', ?string $method = 'POST', ?string $action = '')
    {
        $this->name = $name;
        $this->method = $method;
        $this->action = $action;
    }

    public function getObject(): string
    {
        return $this->object;
    }

    public function setObject(&$object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function setRequest(ServerRequestInterface $request): self
    {
        $this->request = $request;

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

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): string
    {
        $this->action = $action;

        return $this;
    }

    public function setSubmited(bool $submited): self
    {
        $this->submited = $submited;

        return $this;
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
        return $this->mapObjectFromRequest($this->object, $this->request);
    }

    public function addField(AbstractField $field): self
    {
        $this->fields []= $field;

        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getField(string $name): string
    {
        return isset($this->fields[$name]) ? $this->fields[$name] : '';
    }

    public function setField(string $name, $value): self
    {
        if (isset($this->fields[$name])) {
            $this->fields[$name] = $value;
        }

        return $this;
    }

    public function renderField(string $name): string
    {
        return isset($this->fields[$name]) ? $this->fields[$name]->render() : '';
    }

    public function createView(): string
    {
        return (new Renderer($this))->getHtml();
    }

    public function setErrors(string $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function getErrors(): string
    {
        return $this->errors;
    }

    public function upload(string $fieldName, string $fileName, string $directory)
    {
        $file = $this->request->getUploadedFiles()[$fieldName];
        $setter = 'set' . \ucfirst($fieldName);
        if (method_exists($this->object, $setter)) {
            $this->object->$setter($fileName);
        }

        $extension = \strtolower(\substr(\strrchr($file->getClientFilename(), '.'), 1));
        $fileName = $fileName . '.' . $extension;

        try {
            $file->moveTo($directory . $fileName);
        } catch(\RuntimeException $e) {

        }
    }

    private function mapObjectFromRequest(&$object, ServerRequestInterface $request): bool
    {
        $this->errors = '';

        foreach ($this->fields as $idField => $field) {
            if ($field instanceof SubmitField) {
                continue;
            }

            foreach ($request->getParsedBody() as $key => $value) {
                if ($field instanceof FileField) {
                    $file = $request->getUploadedFiles()[$field->getName()];
                    if ($file->getError() > 0) {
                        $this->errors .= "Erreur lors du transfert.</br>";
                    }
                    if ($field->getMaxLength() > 0 && $file->getSize() > $field->getMaxLength()) {
                        $this->errors = "Le fichier est trop volumineux.</br>";
                    }

                    $this->upload(
                        $field->getName(),
                        $field->getOptions()['fileName'],
                        $field->getOptions()['directory']
                    );
                }

                if ($key == $field->getName()) {
                    if ($field->getMaxLength() > 0 && len($value) > $field->getMaxLength()) {
                        $this->errors .= sprintf('Le champ %s ne doit pas dépasser %s caractères%s', $field->getLabel(), $field->getMaxLength(), \PHP_EOL);
                    }

                    $setter = 'set' . \ucfirst($field->getName());
                    if (method_exists($object, $setter)) {
                        $object->$setter($value);
                        $field->setValue($value);
                        $this->fields[$idField]->setValue($value);
                    }
                }
            }

            $setter = 'get' . \ucfirst($field->getName());
            if (method_exists($object, $setter)) {
                if ($field->getRequired() && empty($object->$setter($value))) {
                    $this->errors .= sprintf('Le champ %s est obligatoire%s', $field->getLabel(), \PHP_EOL);
                }
            }
        }

        if (empty($this->errors)) {
            $this->setValid(true);

            return true;
        }

        return false;
    }
}
