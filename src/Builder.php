<?php

namespace francoismarchand\form;

use Psr\Http\Message\ServerRequestInterface;
use francoismarchand\form\AbstractType;
use francoismarchand\form\Form;
use francoismarchand\form\Exception\FormException;;

class Builder
{
    public function create(ServerRequestInterface $request, string $type, &$object, array $data = []): Form
    {
        $form = new Form();

        if (!empty($request->getParsedBody())) {
            $form->setSubmited(true);
            $form->setRequest($request);
        }

        $form = $this->mapFormFromObject($form, $type, $object, $data);

        return $form->setObject($object);
    }

    private function mapFormFromObject(Form $form, string $type, $object, array $data): Form
    {
        $formType = new $type();
        if (!($formType instanceof AbstractType)) {
            throw new FormException('Wrong type');
        }

        $formType->setData($data);
        $formType->buildForm();

        foreach ($formType->getFields() as $field) {
            $getter = 'get' . \ucfirst($field->getName());
            if (method_exists($object, $getter)) {
                $field->setValue($object->$getter());
            }

            $form->addField($field);
        }

        return $form;
    }
}
