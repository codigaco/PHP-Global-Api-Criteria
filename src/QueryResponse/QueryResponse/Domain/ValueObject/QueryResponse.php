<?php

namespace QuiqueGilB\GlobalApiCriteria\QueryResponse\QueryResponse\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\QueryResponse\Content\Domain\ValueObject\Content;
use QuiqueGilB\GlobalApiCriteria\QueryResponse\Metadata\Domain\ValueObject\Metadata;

class QueryResponse
{
    private $data;
    private $metadata;

    public function __construct(Content $data, Metadata $metadata)
    {
        $this->data = $data;
        $this->metadata = $metadata;
    }

    public function data(): Content
    {
        return $this->data;
    }

    public function metadata(): Metadata
    {
        return $this->metadata;
    }
}
