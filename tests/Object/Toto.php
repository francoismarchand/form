<?php

namespace francoismarchand\form\Test\Object;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getChoice(): ?int
    {
        return $this->choice;
    }

    public function setChoice(?int $choice): self
    {
        $this->choice = $choice;

        return $this;
    }
}
