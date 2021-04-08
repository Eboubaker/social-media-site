<?php

namespace App\CustomRelationShip;

use App\CustomRelationShip\Relations\Custom;
use Closure;

trait HasCustomRelations
{
    /**
    * Define a custom relationship.
    *
    * @param  string    $related
    * @param  \Closure  $baseConstraints
    * @param  \Closure  $eagerConstraints
    * @param  \Closure  $eagerMatcher
    * @return \App\CustomRelationShip\Relations\Custom
    */
    public function custom($related, Closure $baseConstraints, Closure $eagerConstraints, Closure $eagerMatcher)
    {
        $instance = new $related;
        $query = $instance->newQuery();

        return new Custom($query, $this, $baseConstraints, $eagerConstraints, $eagerMatcher);
    }
}
