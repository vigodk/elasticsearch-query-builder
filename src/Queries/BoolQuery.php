<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

use Spatie\ElasticsearchQueryBuilder\Exceptions\BoolQueryTypeDoesNotExist;

class BoolQuery implements Query
{
    protected array $must = [];
    protected array $filter = [];
    protected array $should = [];
    protected array $must_not = [];

    public static function create(): self
    {
        return new self();
    }

    public function add(Query $query, string $type = 'must'): self
    {
        if (! in_array($type, ['must', 'filter', 'should', 'must_not'])) {
            throw new BoolQueryTypeDoesNotExist($type);
        }

        $this->{$type}[] = $query;

        return $this;
    }

    public function toArray(): array
    {
        $bool = [
            'must' => array_map(fn (Query $query) => $query->toArray(), $this->must),
            'filter' => array_map(fn (Query $query) => $query->toArray(), $this->filter),
            'should' => array_map(fn (Query $query) => $query->toArray(), $this->should),
            'must_not' => array_map(fn (Query $query) => $query->toArray(), $this->must_not),
        ];

        return [
            'bool' => array_filter($bool),
        ];
    }
}
