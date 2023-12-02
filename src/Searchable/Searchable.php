<?php

namespace Rasyidly\ModelQuery\Searchable;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Scope a query to search through searchable columns.
     */
    public function scopeSearch(Builder $builder, $search = ''): Builder
    {
        if (strlen($search) && count($columns = $this->getSearchableColumns())) {
            $builder = $builder->where(function ($query) use ($search, $columns) {
                foreach ($columns as $loop => $column) {
                    $cols = explode('.', $column);
                    $query->when(
                        count($cols) == 1,
                        fn ($q) => $q->{$loop == 0 ? 'where' : 'orWhere'}($cols[0], 'like', '%' . $search . '%'),
                        function ($q) use ($loop, $cols, $search) {
                            $col = array_pop($cols);
                            return $q->{$loop == 0 ? 'whereRelation' : 'orWhereRelation'}(implode('.', $cols), $col, 'like', '%' . $search . '%');
                        }
                    );
                }
            });
        }

        return $builder;
    }

    /**
     * Scope a query to search according searchable columns.
     */
    public function scopeSetSearchableColumns(Builder $builder, array $array, bool $replace = false): Builder
    {
        $this->searchable = $replace ? $array : array_merge($this->getSearchableColumns(), $array);

        return $builder;
    }

    /**
     * Get searchable columns.
     */
    private function getSearchableColumns(): array
    {
        return $this->searchable ?? [];
    }
}
