<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$profile = App\Models\InstagramProfile::where('username', 'cristiano')->first();

if ($profile) {
    echo "✅ Sincronização concluída!\n";
    echo "Perfil: @{$profile->username}\n";
    echo "Nome: {$profile->full_name}\n";
    echo "Seguidores: " . number_format($profile->follower_count) . "\n";
    echo "Posts: {$profile->media_count}\n";
    echo "Verificado: " . ($profile->is_verified ? 'SIM' : 'NÃO') . "\n";
    echo "Última sync: " . $profile->last_synced_at?->format('d/m/Y H:i:s') . "\n";

    $postsCount = App\Models\InstagramPost::where('instagram_profile_id', $profile->id)->count();
    echo "\nPosts salvos no banco: {$postsCount}\n";

    if ($postsCount > 0) {
        echo "\nÚltimos 3 posts:\n";
        $posts = App\Models\InstagramPost::where('instagram_profile_id', $profile->id)
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
        foreach ($posts as $post) {
            echo "- {$post->shortcode} | Curtidas: " . number_format($post->like_count) . "\n";
        }
    }
} else {
    echo "❌ Perfil não encontrado\n";
}
