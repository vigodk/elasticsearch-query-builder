<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class MultiMatchQuery implements Query
{
    protected string $query;

    protected array $fields;

    /**
     * @var int|string|null
     */
    protected $fuzziness = null;

    protected ?string $type = null;

    public const TYPE_BEST_FIELDS = 'best_fields';
    public const TYPE_MOST_FIELDS = 'most_fields';
    public const TYPE_CROSS_FIELDS = 'cross_fields';
    public const TYPE_PHRASE = 'phrase';
    public const TYPE_PHRASE_PREFIX = 'phrase_prefix';
    public const TYPE_BOOL_PREFIX = 'bool_prefix';

    /**
     * @var int|string|null $fuzziness
     */
    public static function create(string $query, array $fields, $fuzziness = null, ?string $type = null): self
    {
        return new self($query, $fields, $fuzziness, $type);
    }

    /**
     * @var int|string|null $fuzziness
     */
    public function __construct(string $query, array $fields, $fuzziness = null, ?string $type = null)
    {
        $this->query = $query;
        $this->fields = $fields;
        $this->fuzziness = $fuzziness;
        $this->type = $type;
    }

    public function toArray(): array
    {
        $multiMatch = [
            'multi_match' => [
                'query' => $this->query,
                'fields' => $this->fields,
            ],
        ];

        if ($this->fuzziness) {
            $multiMatch['multi_match']['fuzziness'] = $this->fuzziness;
        }

        if ($this->type) {
            $multiMatch['multi_match']['type'] = $this->type;
        }

        return $multiMatch;
    }
}
