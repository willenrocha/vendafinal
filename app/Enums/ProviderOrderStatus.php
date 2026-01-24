<?php

declare(strict_types=1);

namespace App\Enums;

enum ProviderOrderStatus: string
{
    case Pending = 'Pending';
    case Partial = 'Partial';
    case Canceled = 'Canceled';
    case Processing = 'Processing';
    case InProgress = 'In progress';
    case Completed = 'Completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Partial => 'Parcial',
            self::Canceled => 'Cancelado',
            self::Processing => 'Processando',
            self::InProgress => 'Em Progresso',
            self::Completed => 'Concluído',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Partial => 'info',
            self::Canceled => 'danger',
            self::Processing => 'primary',
            self::InProgress => 'primary',
            self::Completed => 'success',
        };
    }
}
