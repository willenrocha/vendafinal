<?php

namespace App\Filament\Resources\InstagramProfiles\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class InstagramProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Perfil')
                    ->schema([
                        ImageEntry::make('profile_pic_base64')
                            ->label('')
                            ->circular()
                            ->defaultImageUrl('/images/default-avatar.png')
                            ->size(120)
                            ->alignCenter(),

                        TextEntry::make('username')
                            ->label('Username')
                            ->prefix('@')
                            ->copyable()
                            ->weight(FontWeight::Bold)
                            ->size('xl')
                            ->alignCenter(),

                        TextEntry::make('full_name')
                            ->label('Nome Completo')
                            ->placeholder('—')
                            ->alignCenter(),

                        TextEntry::make('biography')
                            ->label('Biografia')
                            ->placeholder('—')
                            ->markdown()
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Section::make('Estatísticas')
                    ->schema([
                        TextEntry::make('follower_count')
                            ->label('Seguidores')
                            ->numeric()
                            ->placeholder('—')
                            ->formatStateUsing(fn ($state) => $state ? number_format((int) $state, 0, ',', '.') : '—')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->icon('heroicon-o-users'),

                        TextEntry::make('following_count')
                            ->label('Seguindo')
                            ->numeric()
                            ->placeholder('—')
                            ->formatStateUsing(fn ($state) => $state ? number_format((int) $state, 0, ',', '.') : '—')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->icon('heroicon-o-user-plus'),

                        TextEntry::make('media_count')
                            ->label('Publicações')
                            ->numeric()
                            ->placeholder('—')
                            ->formatStateUsing(fn ($state) => $state ? number_format((int) $state, 0, ',', '.') : '—')
                            ->weight(FontWeight::Bold)
                            ->size('lg')
                            ->icon('heroicon-o-photo'),

                        TextEntry::make('is_verified')
                            ->label('Verificado')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Verificado ✓' : 'Não verificado')
                            ->color(fn ($state) => $state ? 'success' : 'gray')
                            ->icon(fn ($state) => $state ? 'heroicon-o-check-badge' : 'heroicon-o-x-circle'),

                        TextEntry::make('is_business')
                            ->label('Tipo')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Conta Comercial' : 'Conta Pessoal')
                            ->color(fn ($state) => $state ? 'info' : 'gray')
                            ->icon(fn ($state) => $state ? 'heroicon-o-building-storefront' : 'heroicon-o-user'),

                        TextEntry::make('is_active')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state ? 'Ativo' : 'Inativo')
                            ->color(fn ($state) => $state ? 'success' : 'danger')
                            ->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),

                        TextEntry::make('last_synced_at')
                            ->label('Última Sincronização')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Nunca sincronizado')
                            ->icon('heroicon-o-arrow-path'),

                        TextEntry::make('user.email')
                            ->label('Proprietário')
                            ->copyable()
                            ->icon('heroicon-o-user'),
                    ])
                    ->columns(3),

                Section::make('Últimas Publicações')
                    ->description(fn ($record) => 'Mostrando ' . $record->posts()->count() . ' publicações mais recentes')
                    ->schema([
                        RepeatableEntry::make('posts')
                            ->label('')
                            ->state(fn ($record) => $record->posts)
                            ->schema([
                                ImageEntry::make('images')
                                    ->label('Imagem')
                                    ->state(fn ($record) => $record->images[0]['base64'] ?? null)
                                    ->square()
                                    ->size(150),

                                TextEntry::make('caption')
                                    ->label('Legenda')
                                    ->limit(150)
                                    ->placeholder('Sem legenda')
                                    ->columnSpanFull(),

                                TextEntry::make('like_count')
                                    ->label('Curtidas')
                                    ->formatStateUsing(fn ($state) => number_format((int) $state, 0, ',', '.'))
                                    ->icon('heroicon-o-heart')
                                    ->badge()
                                    ->color('danger'),

                                TextEntry::make('comment_count')
                                    ->label('Comentários')
                                    ->formatStateUsing(fn ($state) => number_format((int) $state, 0, ',', '.'))
                                    ->icon('heroicon-o-chat-bubble-left')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('taken_at')
                                    ->label('Publicado em')
                                    ->dateTime('d/m/Y H:i')
                                    ->icon('heroicon-o-calendar'),

                                TextEntry::make('instagram_url')
                                    ->label('Ver no Instagram')
                                    ->formatStateUsing(fn () => 'Abrir')
                                    ->url(fn ($record) => $record->instagram_url)
                                    ->openUrlInNewTab()
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->color('primary'),
                            ])
                            ->columns(4),
                    ])
                    ->visible(fn ($record) => $record->posts()->count() > 0)
                    ->collapsible(),

                Section::make('Pedidos Vinculados')
                    ->description('Pedidos que usaram este perfil')
                    ->schema([
                        TextEntry::make('orders_count')
                            ->label('Total de Pedidos')
                            ->state(fn ($record) => $record->orders()->count())
                            ->badge()
                            ->color('info')
                            ->icon('heroicon-o-shopping-cart'),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Dados Técnicos')
                    ->description('Informações técnicas e JSON completo')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID')
                            ->copyable(),

                        TextEntry::make('created_at')
                            ->label('Criado em')
                            ->dateTime('d/m/Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Atualizado em')
                            ->dateTime('d/m/Y H:i:s'),

                        TextEntry::make('profile_data')
                            ->label('Dados JSON da API')
                            ->formatStateUsing(function ($state) {
                                if (empty($state)) {
                                    return 'Nenhum dado disponível';
                                }
                                return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                            })
                            ->columnSpanFull()
                            ->copyable(),
                    ]),
            ]);
    }
}
