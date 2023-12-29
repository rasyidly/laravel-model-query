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
     * Get loadable relations.
     */
    private function getLoadableRelations(): array
    {
        $rels = $this->loadable ?? [];
        $result = [];
        foreach ($rels as $element) {
            $parts = explode('.', $element);
            $temp = '';
            foreach ($parts as $part) {
                $temp .= $part;
                if (!in_array($temp, $result)) {
                    array_push($result, $temp);
                }
                $temp .= '.';
            }
        }
        return $result;
    }
}
