<?php

namespace App\Filament\Resources\BlogPostResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // Informações Básicas
                Section::make('Informações do Post')
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set, $context) {
                                if ($context === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL amigável. Ex: como-crescer-no-instagram')
                            ->columnSpanFull(),

                        Textarea::make('excerpt')
                            ->label('Resumo')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Descrição breve do post')
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Conteúdo')
                            ->required()
                            ->fileAttachmentsDirectory('blog/attachments')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'link',
                                'codeBlock',
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                    ]),

                // Sidebar
                Section::make('Publicação')
                    ->columnSpan(1)
                    ->schema([
                        Select::make('author_id')
                            ->label('Autor')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id())
                            ->required(),

                        Toggle::make('is_published')
                            ->label('Publicar')
                            ->default(false)
                            ->live(),

                        DateTimePicker::make('published_at')
                            ->label('Data de Publicação')
                            ->default(now())
                            ->required(fn (Get $get) => $get('is_published'))
                            ->visible(fn (Get $get) => $get('is_published')),

                        Select::make('category')
                            ->label('Categoria')
                            ->options([
                                'Estratégias' => 'Estratégias',
                                'Dicas' => 'Dicas',
                                'Engajamento' => 'Engajamento',
                                'Instagram' => 'Instagram',
                                'Marketing Digital' => 'Marketing Digital',
                                'Redes Sociais' => 'Redes Sociais',
                                'Tendências' => 'Tendências',
                            ])
                            ->searchable()
                            ->preload(),

                        TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Digite e pressione Enter'),

                        FileUpload::make('featured_image')
                            ->label('Imagem Destacada')
                            ->image()
                            ->imageEditor()
                            ->directory('blog')
                            ->maxSize(2048),

                        TextInput::make('reading_time')
                            ->label('Tempo de Leitura (min)')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('Auto'),
                    ]),

                // SEO
                Section::make('Otimização SEO')
                    ->columnSpan(2)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Título')
                            ->maxLength(60)
                            ->helperText('Máx. 60 caracteres'),

                        Textarea::make('meta_description')
                            ->label('Meta Descrição')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Máx. 160 caracteres'),

                        Textarea::make('meta_keywords')
                            ->label('Palavras-chave SEO')
                            ->rows(2)
                            ->placeholder('palavra1, palavra2, palavra3'),

                        TextInput::make('canonical_url')
                            ->label('URL Canônica')
                            ->url()
                            ->placeholder('https://exemplo.com/post'),
                    ]),
            ]);
    }
}
