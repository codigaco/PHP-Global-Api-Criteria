<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Data\Domain\ValueObject;

class QueryData
{
    private $value;

    public function __construct($data)
    {
        $this->value = $data;
    }

    public static function create($data): self
    {
        return new static($data);
    }

    public function value()
    {
        return $this->value;
    }

    public function isCollection(): bool
    {
        return is_array($this->value) && (
                empty($this->value) || array_keys($this->value) === range(0, count($this->value) - 1)
            );
    }

    public function isNull(): bool
    {
        return null === $this->value;
    }

    public function isElement(): bool
    {
        return !$this->isNull() && !$this->isCollection();
    }
}
