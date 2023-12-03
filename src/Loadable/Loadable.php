<?php

namespace Rasyidly\ModelQuery\Loadable;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait Loadable
{
    /**
     * Scope a query to apply eager loading through loadable relations.
     */
    public function scopeLoadable($builder, $load): Builder
    {
        return $builder->with(array_intersect($this->getLoadableRelations(), array_filter(explode(',', $load))));
    }

    /**
     * Lazy load relations through loadable relations.
     */
    public function loadable($load)
    {
        return $this->load(array_intersect($this->getLoadableRelations(), array_filter(explode(',', $load))));
    }

    /**
     * Get loadable releations.
     */
    private function getLoadableRelations(): array
    {
        return $this->loadable ?? [];
    }
}
