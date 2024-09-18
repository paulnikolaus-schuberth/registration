<?php

namespace App\Models;

enum DownloadableFileType: string
{
    case APPF = 'appf';

    case Rules = 'rules';

    case Flyer = 'flyer';

    public function path(): string
    {
        return match ($this) {
            self::APPF => 'APPF 2025.pdf',
            self::Rules => 'Verhaltensregeln 2025.pdf',
            self::Flyer => 'Flyer ET 2025.pdf'
        };
    }

    public function displayName(): string
    {
        return match ($this) {
            self::APPF => 'APPF',
            self::Rules => 'Verhaltensregeln',
            self::Flyer => 'Infoflyer'
        };
    }
}
