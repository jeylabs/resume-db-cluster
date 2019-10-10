<?php


namespace Jeylabs\ResumeDbCluster\Jobs;

use Aws\Rds\RdsClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ResumeDbClusterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function handle()
    {
        if (config('resume-db-cluster.db_cluster_identifier')) {
            /**
             * @var RdsClient $client
             */
            $client = app()->make('aws')->createClient('rds', [
                'region' => 'ap-southeast-2'
            ]);

            $result = $client->describeDBClusters([
                'DBClusterIdentifier' => config('resume-db-cluster.db_cluster_identifier'),
            ]);

            $dbCluster = Arr::get($result->get('DBClusters'), 0);
            $capacity = Arr::get($dbCluster, 'Capacity');

            if ($capacity === 0) {
                DB::table('users')->select('id')->where('id', 1)->first();
            }
        }
    }
}
