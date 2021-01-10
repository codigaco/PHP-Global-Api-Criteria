<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponse\QueryResponse\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\QueryResponse\Data\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\QueryMetadata;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\QueryResponse\Domain\Exception\InvalidQueryResponseException;

class QueryResponse
{
    private $data;
    private $metadata;

    public function __construct(QueryData $data, QueryMetadata $metadata)
    {
        self::validate($data, $metadata);
        $this->data = $data;
        $this->metadata = $metadata;
    }

    public static function validate(QueryData $data, QueryMetadata $metadata): void
    {
        $expectedItems = $data->isNull() ? 0 : 1;

        if ($data->isCollection()) {
            $expectedItems = count($data->value());
        }

        if ($metadata->items() !== $expectedItems) {
            throw new InvalidQueryResponseException("unexpected items");
        }

    }

    public static function create(QueryData $data, QueryMetadata $metadata): self
    {
        return new static($data, $metadata);
    }

    public function data(): QueryData
    {
        return $this->data;
    }

    public function metadata(): QueryMetadata
    {
        return $this->metadata;
    }
}
