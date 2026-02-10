<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\InstagramProfile;
use App\Services\Instagram\InstagramSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncInstagramProfileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Número de tentativas
     */
    public int $tries = 3;

    /**
     * Timeout em segundos (5 minutos para download de imagens)
     */
    public int $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $instagramProfileId,
        public int $postsLimit = 12
    ) {}

    /**
     * Execute the job.
     */
    public function handle(InstagramSyncService $syncService): void
    {
        $profile = InstagramProfile::find($this->instagramProfileId);

        if (!$profile) {
            Log::warning('Instagram profile not found for sync', [
                'profile_id' => $this->instagramProfileId,
            ]);
            return;
        }

        Log::info('Starting Instagram profile sync', [
            'profile_id' => $profile->id,
            'username' => $profile->username,
            'posts_limit' => $this->postsLimit,
            'attempt' => $this->attempts(),
        ]);

        $result = $syncService->syncProfile($profile, $this->postsLimit);

        // Verificar se os dados vieram vazios/null
        $profile->refresh();
        $isDataEmpty = empty($profile->full_name) &&
                       empty($profile->follower_count) &&
                       empty($profile->biography);

        if ($isDataEmpty && $this->attempts() < $this->tries) {
            Log::warning('Instagram sync returned empty data, will retry', [
                'profile_id' => $profile->id,
                'username' => $profile->username,
                'attempt' => $this->attempts(),
                'max_tries' => $this->tries,
            ]);

            // Liberar o job de volta para a fila para tentar novamente
            $this->release(5); // Aguarda 5 segundos antes de tentar novamente
            return;
        }

        if (!empty($result['errors'])) {
            Log::error('Instagram sync completed with errors', [
                'profile_id' => $profile->id,
                'username' => $profile->username,
                'errors' => $result['errors'],
            ]);
        } elseif ($isDataEmpty) {
            Log::error('Instagram sync failed - empty data after all retries', [
                'profile_id' => $profile->id,
                'username' => $profile->username,
                'attempts' => $this->attempts(),
            ]);
        } else {
            Log::info('Instagram sync completed successfully', [
                'profile_id' => $profile->id,
                'username' => $profile->username,
                'profile_updated' => $result['profile_updated'],
                'posts_synced' => $result['posts_synced'],
                'attempt' => $this->attempts(),
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Instagram sync job failed', [
            'profile_id' => $this->instagramProfileId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
