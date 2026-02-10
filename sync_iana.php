<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$profile = App\Models\InstagramProfile::find(5);
$syncService = app(\App\Services\Instagram\InstagramSyncService::class);

echo "Sincronizando perfil @{$profile->username}...\n\n";

$result = $syncService->syncProfile($profile, 12);

echo "Resultado da sincronização:\n";
echo "Profile updated: " . ($result['profile_updated'] ? 'SIM' : 'NÃO') . "\n";
echo "Posts synced: {$result['posts_synced']}\n";
echo "Errors: " . (empty($result['errors']) ? 'Nenhum' : implode(', ', $result['errors'])) . "\n\n";

// Recarregar perfil
$profile->refresh();

echo "Dados atualizados:\n";
echo "Nome: {$profile->full_name}\n";
echo "Bio: " . ($profile->biography ?? 'NULL') . "\n";
echo "Seguidores: " . number_format($profile->follower_count) . "\n";
echo "Seguindo: " . number_format($profile->following_count) . "\n";
echo "Posts: {$profile->media_count}\n";
