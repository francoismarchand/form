<?php

namespace francoismarchand\form\Test;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use francoismarchand\form\Builder;
use francoismarchand\form\Test\Type\TotoType;
use francoismarchand\form\Test\Object\Toto;
use francoismarchand\form\Field\AbstractField;

class BuilderTest extends TestCase
{
    public function testCreateFormHtml()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $builder = new Builder();
        $toto = new Toto();
        $form = $builder->create($request, TotoType::class, $toto);

        if ($form->isSubmited()) {
            $this->fail('Form should not be submited');
            if ($form->isValid()) {
                $this->fail('Form should not be valid');
            }
        }

        $fields = $form->getFields();

        $this->assertContainsOnlyInstancesOf(AbstractField::class, $fields);
        $this->assertSame($fields[0]->getName(), 'title');
        $this->assertSame($fields[0]->getLabel(), 'Title');
        $this->assertSame($fields[0]->getRequired(), true);
        $this->assertSame($fields[0]->getValue(), null);
        $this->assertSame($fields[1]->getLabel(), 'Text');
        $this->assertSame($fields[2]->getLabel(), 'Choice');

        $html = $form->createView();

        $this->assertStringMatchesFormat('<form %A</form>', $html);
    }

    public function testCreateOnPostRequest()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getParsedBody')->willReturn([
            'title' => 'The title',
            'text' => 'The text',
            'choice' => 1,
        ]);
        $builder = new Builder();
        $toto = new Toto();
        $form = $builder->create($request, TotoType::class, $toto);

        if ($form->isSubmited()) {
            if ($form->isValid()) {
                $this->assertSame($toto->getTitle(), 'The title');
                $this->assertSame($toto->getText(), 'The text');
                $this->assertSame($toto->getChoice(), 1);
            } else {
                $this->fail('Form should be valid');
            }
        } else {
            $this->fail('Form should be submited');
        }
    }

    public function testCreateWithExistingObject()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getParsedBody')->willReturn([
            'title' => 'New title',
            'text' => 'New text',
            'choice' => 2,
        ]);
        $builder = new Builder();
        $toto = (new Toto())
            ->setTitle('Old title')
            ->setText('Old text')
            ->setChoice(0)
        ;
        $form = $builder->create($request, TotoType::class, $toto);

        $fields = $form->getFields();
        $this->assertContainsOnlyInstancesOf(AbstractField::class, $fields);
        $this->assertSame($fields[0]->getValue(), 'Old title');
        $this->assertSame($fields[1]->getValue(), 'Old text');
        $this->assertSame($fields[2]->getValue(), 0);

        if ($form->isSubmited()) {
            if ($form->isValid()) {
                $html = $form->createView();
                $this->assertStringMatchesFormat('<form %A</form>', $html);
            } else {
                $this->fail('Form should be valid');
            }
        } else {
            $this->fail('Form should be submited');
        }

        $fields = $form->getFields();
        $this->assertContainsOnlyInstancesOf(AbstractField::class, $fields);
        $this->assertSame($toto->getTitle(), 'New title');
        $this->assertSame($toto->getText(), 'New text');
        $this->assertSame($toto->getChoice(), 2);
    }

    public function testCreateWithMissingRequiredField()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getParsedBody')->willReturn([
            'text' => 'The text',
            'choice' => 1,
        ]);
        $builder = new Builder();
        $toto = new Toto();
        $form = $builder->create($request, TotoType::class, $toto);

        if ($form->isSubmited()) {
            if ($form->isValid()) {
                $this->fail('Form should not be valid');
            } else {
                $this->assertSame($form->getErrors(), 'Le champ Title est obligatoire' . \PHP_EOL);
            }
        } else {
            $this->fail('Form should be submited');
        }

        $fields = $form->getFields();
        $this->assertSame($fields[1]->getValue(), 'The text');
    }
}
