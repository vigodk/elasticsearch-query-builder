<?php

namespace Spatie\ElasticsearchQueryBuilder\Queries;

class MatchQuery implements Query
{
    protected string $field;

    /**
     * @var string|int
     */
    protected $query;

    /**
     * @var string|int|null
     */
    protected $fuzziness = null;

    /**
     * @var string|int $query
     * @var string|int|null $fuzziness
     */
    public static function create(string $field, $query, $fuzziness = null): self
    {
        return new self($field, $query, $fuzziness);
    }

    /**
     * @var string|int $query
     * @var string|int|null $fuzziness
     */
    public function __construct(string $field, $query, $fuzziness = null)
    {
        $this->field = $field;
        $this->query = $query;
        $this->fuzziness = $fuzziness;
    }

    public function toArray(): array
    {
        $match = [
            'match' => [
                $this->field => [
                    'query' => $this->query,
                ],
            ],
        ];

        if ($this->fuzziness) {
            $match['match'][$this->field]['fuzziness'] = $this->fuzziness;
        }

        return $match;
    }
}
