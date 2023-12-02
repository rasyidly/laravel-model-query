<?php

namespace Rasyidly\ModelQuery\Loadable;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Loadable
{
    /**
     * Scope a query to apply eager loading through loadable relations.
     */
    public function scopeLoadable($builder, array $array): Builder
    {
        return $builder->with(array_intersect($this->getLoadableRelations(), $array));
    }

    /**
     * Lazy load relations through loadable relations.
     */
    public function loadable(array $array)
    {
        return $this->load(array_intersect($this->getLoadableRelations(), $array));
    }

    /**
     * Get loadable releations.
     */
    private function getLoadableRelations(): array
    {
        return $this->loadable ?? [];
    }
}
