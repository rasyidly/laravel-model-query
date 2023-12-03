<?php

namespace Rasyidly\ModelQuery\Sortable;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Sortable
{
    /**
     * Scope a query to sort through sortable columns.
     */
    public function scopeSortable(Builder $builder, $string = ''): Builder
    {
        $col = explode(',', $string);
        if (count($col) == 2 && preg_match('/(?i)\w+,(?:asc|desc)/', $string) && in_array($col[0], $this->getSortableColumns())) {
            return $builder->orderBy($col[0], $col[1]);
        }
        return $builder;
    }

    /**
     * Get sortable columns.
     */
    private function getSortableColumns(): array
    {
        return $this->sortable ?? [];
    }
}
