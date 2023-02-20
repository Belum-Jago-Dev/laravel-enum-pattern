<?php

namespace App\Enum\User;

enum CheckStatus: string
{
    case INACTIVE = '0';
    case ACTIVE = '1';
    case BLOCKED = '2';

    public function isInactive(): bool
    {
        return $this == self::INACTIVE;
    }

    public function isActive(): bool
    {
        return $this == self::ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this == self::BLOCKED;
    }

    public function getTextLabel(): string
    {
        return match ($this) {
            self::INACTIVE => 'Tidak Aktif',
            self::ACTIVE => 'Aktif',
            self::BLOCKED => 'Di Blokir',
        };
    }
}
