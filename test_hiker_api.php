<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$hikerApi = app(\App\Services\Instagram\HikerApiClient::class);

echo "Testando API Hiker para @iana_dias_moreira...\n\n";

$result = $hikerApi->lookupByUsername('iana_dias_moreira');

echo "Resultado:\n";
echo "Exists: " . ($result['exists'] ? 'SIM' : 'NÃO') . "\n\n";

if ($result['exists'] && isset($result['profile'])) {
    $profile = $result['profile'];
    echo "Dados do perfil:\n";
    echo "Username: " . ($profile['username'] ?? 'N/A') . "\n";
    echo "Full name: " . ($profile['full_name'] ?? 'N/A') . "\n";
    echo "Biography: " . ($profile['biography'] ?? 'N/A') . "\n";
    echo "Followers: " . ($profile['follower_count'] ?? 'N/A') . "\n";
    echo "Following: " . ($profile['following_count'] ?? 'N/A') . "\n";
    echo "Media count: " . ($profile['media_count'] ?? 'N/A') . "\n";
    echo "Is verified: " . ($profile['is_verified'] ? 'SIM' : 'NÃO') . "\n";

    echo "\nTodos os campos retornados:\n";
    print_r(array_keys($profile));
} else {
    echo "API não retornou dados do perfil\n";
}
