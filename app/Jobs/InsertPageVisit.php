<?php
/**
 * Topic: PageVisit
 * Author: Victor Wang
 * Created: 24/05/2021
 * Last Updated: 21/09/2021
 * Description: This is the job which is responsible for record page visit information
 */

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

// Models
use App\Models\PageVisit;

class InsertPageVisit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pageName;
    private $ipAddress;
    private $visitedAt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pageName, $ipAddress, $visitedAt)
    {
        $this->pageName = $pageName;
        $this->ipAddress = $ipAddress;
        $this->visitedAt = $visitedAt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            PageVisit::create(
                [
                    'page_name' => $this->pageName,
                    'ip_address' => $this->ipAddress,
                    'visited_at' => $this->visitedAt
                ]
            );
            Log::info(
                'Successfully inserted page visit information with'
                ." page: {$this->pageName}"
                ." ip: {$this->ipAddress}"
                ." and visit time: {$this->visitedAt}"
            );
            return true;
        } catch (\Throwable $e) {
            Log::error(
                "[".$e->getCode().'] "'.$e->getMessage().'" on line '
                .$e->getTrace()[0]['line'].' of file '.$e->getFile()
                ." page: {$this->pageName}"
                ." ip: {$this->ipAddress}"
                ." and visit time: {$this->visitedAt}"
            );
            return false;
        }
    }
}
