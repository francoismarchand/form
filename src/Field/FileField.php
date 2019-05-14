<?php

namespace francoismarchand\form\Field;

use francoismarchand\form\Field\InputField;

class FileField extends InputField
{
    protected $type = 'file';
    protected $fileName;
    protected $directory;

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function setDirectory(string $directory): self
    {
        $this->directory = $directory;

        return $this;
    }
}
