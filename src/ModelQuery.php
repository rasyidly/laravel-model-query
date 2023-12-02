<?php

namespace Rasyidly\ModelQuery;

use Rasyidly\ModelQuery\Loadable\Loadable;
use Rasyidly\ModelQuery\Searchable\Searchable;
use Rasyidly\ModelQuery\Sortable\Sortable;
use Rasyidly\ModelQuery\Trashable\Trashable;

trait ModelQuery
{
    use Searchable, Loadable, Sortable, Trashable;
}
