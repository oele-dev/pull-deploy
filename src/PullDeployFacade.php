<?php

namespace oeleco\PullDeploy;

use Illuminate\Support\Facades\Facade;

/**
 * @see \oeleco\PullDeploy\Skeleton\SkeletonClass
 */
class PullDeployFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pull-deploy';
    }
}
