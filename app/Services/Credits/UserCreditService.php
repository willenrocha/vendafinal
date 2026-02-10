<?php

namespace App\Services\Credits;

use App\Models\Package;
use App\Models\User;
use App\Models\UserCreditBalance;
use Illuminate\Support\Facades\DB;

class UserCreditService
{
    /**
     * @param  'likes'|'views'|'comments'  $type
     */
    public function add(User $user, string $type, int $amount): UserCreditBalance
    {
        if (! in_array($type, ['likes', 'views', 'comments'], true)) {
            throw new \InvalidArgumentException("Tipo de crédito inválido: {$type}");
        }

        if ($amount <= 0) {
            throw new \InvalidArgumentException('Quantidade de crédito precisa ser maior que zero.');
        }

        return DB::transaction(function () use ($user, $type, $amount): UserCreditBalance {
            $balance = UserCreditBalance::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['likes' => 0, 'views' => 0, 'comments' => 0],
            );

            $balance->increment($type, $amount);

            return $balance->fresh();
        });
    }

    /**
     * @param  'likes'|'views'|'comments'  $type
     */
    public function deduct(User $user, string $type, int $amount): UserCreditBalance
    {
        if (! in_array($type, ['likes', 'views', 'comments'], true)) {
            throw new \InvalidArgumentException("Tipo de crédito inválido: {$type}");
        }

        if ($amount <= 0) {
            throw new \InvalidArgumentException('Quantidade de crédito precisa ser maior que zero.');
        }

        return DB::transaction(function () use ($user, $type, $amount): UserCreditBalance {
            $balance = UserCreditBalance::query()
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if (! $balance || $balance->{$type} < $amount) {
                throw new \InvalidArgumentException('Saldo de créditos insuficiente.');
            }

            $balance->decrement($type, $amount);

            return $balance->fresh();
        });
    }

    public function addPackageBonus(User $user, Package $package): UserCreditBalance
    {
        return DB::transaction(function () use ($user, $package): UserCreditBalance {
            $balance = UserCreditBalance::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['likes' => 0, 'views' => 0, 'comments' => 0],
            );

            $package->bonusItems()
                ->where('is_active', true)
                ->get()
                ->each(function ($item) use ($balance): void {
                    $type = (string) $item->credit_type;
                    $amount = (int) $item->amount;

                    if (! in_array($type, ['likes', 'views', 'comments'], true)) {
                        return;
                    }

                    if ($amount <= 0) {
                        return;
                    }

                    $balance->increment($type, $amount);
                });

            return $balance->fresh();
        });
    }
}
