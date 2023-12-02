<?php

namespace Rasyidly\ModelQuery\Trashable;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Trashable
{
    /**
     * Scope a query to get trashable if matching criteria, this function only works if models use SoftDeletes trait.
     */
    public function scopeTrashable(Builder $builder, $trashed = ''): Builder
    {
        if (method_exists($this, 'bootSoftDeletes')) {
            $types = ['with', 'only', 'without'];

            if (in_array($trashed, $types)) {
                $builder->{$trashed . 'Trashed'}();
            }
        }

        return $builder;
    }
}
