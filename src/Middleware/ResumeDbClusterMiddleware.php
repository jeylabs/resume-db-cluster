<?php


namespace Jeylabs\ResumeDbCluster\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Jeylabs\ResumeDbCluster\Jobs\ResumeDbClusterJob;

class ResumeDbClusterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        $dbPauseAfter = config('resume-db-cluster.db_pause_after');
        $resumeQuerySent = cache('resume_query_sent');
        if (!$resumeQuerySent) {
            dispatch(new ResumeDbClusterJob());
        }
        cache()->put('resume_query_sent', true, now()->addMinutes($dbPauseAfter));
        return $next($request);
    }
}
