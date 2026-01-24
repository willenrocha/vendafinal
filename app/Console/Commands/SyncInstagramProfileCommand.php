<?php

namespace App\Console\Commands;

use App\Models\InstagramProfile;
use App\Services\Instagram\InstagramSyncService;
use Illuminate\Console\Command;

class SyncInstagramProfileCommand extends Command
{
    protected $signature = 'instagram:sync {profile_id} {--posts=12}';
    protected $description = 'Sincroniza perfil e posts do Instagram';

    public function handle(InstagramSyncService $syncService): int
    {
        $profileId = (int) $this->argument('profile_id');
        $postsLimit = (int) $this->option('posts');

        $profile = InstagramProfile::find($profileId);

        if (!$profile) {
            $this->error("Perfil ID {$profileId} não encontrado");
            return 1;
        }

        $this->info("Sincronizando perfil @{$profile->username}...");

        $result = $syncService->syncProfile($profile, $postsLimit);

        if (!empty($result['errors'])) {
            $this->error('Erros durante sincronização:');
            foreach ($result['errors'] as $error) {
                $this->line("  - {$error}");
            }
        }

        $this->info("✓ Perfil atualizado: " . ($result['profile_updated'] ? 'Sim' : 'Não'));
        $this->info("✓ Posts sincronizados: {$result['posts_synced']}");

        return 0;
    }
}
