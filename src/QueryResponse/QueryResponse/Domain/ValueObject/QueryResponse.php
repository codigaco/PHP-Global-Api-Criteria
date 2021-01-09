<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponse\QueryResponse\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\QueryResponse\Content\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\QueryMetadata;

class QueryResponse
{
    private $data;
    private $metadata;

    public function __construct(QueryData $data, QueryMetadata $metadata)
    {
        $this->data = $data;
        $this->metadata = $metadata;
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
