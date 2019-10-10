<?php

namespace Jeylabs\ResumeDbCluster;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeylabs\ResumeDbCluster\Skeleton\SkeletonClass
 */
class ResumeDbClusterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'resume-db-cluster';
    }
}
