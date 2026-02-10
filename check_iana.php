<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$profile = App\Models\InstagramProfile::where('username', 'iana_dias_moreira')->first();

if ($profile) {
    echo "✅ Sincronização concluída!\n";
    echo "Perfil: @{$profile->username}\n";
    echo "Nome: " . ($profile->full_name ?? 'N/A') . "\n";
    echo "Seguidores: " . number_format($profile->follower_count ?? 0) . "\n";
    echo "Seguindo: " . number_format($profile->following_count ?? 0) . "\n";
    echo "Posts: " . ($profile->media_count ?? 0) . "\n";
    echo "Verificado: " . ($profile->is_verified ? 'SIM' : 'NÃO') . "\n";
    echo "Bio: " . ($profile->biography ? substr($profile->biography, 0, 60) . '...' : 'N/A') . "\n";
    echo "Última sync: " . $profile->last_synced_at?->format('d/m/Y H:i:s') . "\n";

    $postsCount = App\Models\InstagramPost::where('instagram_profile_id', $profile->id)->count();
    echo "\n📸 Posts salvos no banco: {$postsCount}\n";

    if ($postsCount > 0) {
        echo "\nÚltimos 5 posts:\n";
        $posts = App\Models\InstagramPost::where('instagram_profile_id', $profile->id)
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        foreach ($posts as $post) {
            $images = is_string($post->images) ? json_decode($post->images, true) : $post->images;
            $hasImage = !empty($images[0]['url_original']);
            echo "- {$post->shortcode} | ❤️ " . number_format($post->like_count) . " | 💬 {$post->comment_count} | 🖼️ " . ($hasImage ? 'SIM' : 'NÃO') . "\n";
        }
    }
} else {
    echo "❌ Perfil não encontrado\n";
}
