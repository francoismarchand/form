<?php

namespace francoismarchand\form;

use Psr\Http\Message\ServerRequestInterface;
use fesseeo\form\AbstractType;
use fesseeo\form\Form;

class Builder
{
    public function create(ServerRequestInterface $request, AbstractType $type,  stdObject &$object): Form
    {
        $form = new Form();

        if (empty($request->getParsedBody())) {
            $form->setSubmited(true);
            $object = $this->mapRequest($request);
        }

        $form = $this->mapFormFromObject($object);

        return $form;
    }

    private function mapFormFromObject(AbstractType $type, stdClass $object): Form
    {
        foreach ($type->getFields() as $field) {

        }
    }

    private function mapObjectFromRequest(ServerRequestInterface $request): stdObject
    {
        
    }
}
