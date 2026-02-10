<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$hikerApi = app(\App\Services\Instagram\HikerApiClient::class);
$profile = App\Models\InstagramProfile::find(5);

echo "=== TESTE DE SINCRONIZAÇÃO DETALHADO ===\n\n";

echo "1. Buscar dados da API...\n";
$result = $hikerApi->lookupByUsername('iana_dias_moreira');

echo "Existe: " . ($result['exists'] ? 'SIM' : 'NÃO') . "\n";

if ($result['exists']) {
    $profileData = $result['profile'] ?? [];

    echo "\n2. Dados recebidos da API:\n";
    echo "- full_name: " . ($profileData['full_name'] ?? 'NULL') . "\n";
    echo "- biography: " . ($profileData['biography'] ?? 'NULL') . "\n";
    echo "- follower_count: " . ($profileData['follower_count'] ?? 'NULL') . "\n";
    echo "- following_count: " . ($profileData['following_count'] ?? 'NULL') . "\n";
    echo "- media_count: " . ($profileData['media_count'] ?? 'NULL') . "\n";

    echo "\n3. Tentando atualizar perfil no banco...\n";

    try {
        $updated = $profile->update([
            'full_name' => $profileData['full_name'] ?? null,
            'biography' => $profileData['biography'] ?? null,
            'profile_pic_url' => $profileData['profile_pic_url'] ?? null,
            'follower_count' => $profileData['follower_count'] ?? null,
            'following_count' => $profileData['following_count'] ?? null,
            'media_count' => $profileData['media_count'] ?? null,
            'is_verified' => $profileData['is_verified'] ?? false,
            'is_business' => $profileData['is_business'] ?? false,
            'profile_data' => $profileData,
            'last_synced_at' => now(),
        ]);

        echo "Update retornou: " . ($updated ? 'TRUE' : 'FALSE') . "\n";

        $profile->refresh();

        echo "\n4. Dados salvos no banco:\n";
        echo "- full_name: " . ($profile->full_name ?? 'NULL') . "\n";
        echo "- biography: " . ($profile->biography ?? 'NULL') . "\n";
        echo "- follower_count: {$profile->follower_count}\n";
        echo "- following_count: {$profile->following_count}\n";
        echo "- media_count: {$profile->media_count}\n";

    } catch (\Exception $e) {
        echo "ERRO: " . $e->getMessage() . "\n";
    }
}
