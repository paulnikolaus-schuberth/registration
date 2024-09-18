<?php

namespace Tests\Models;

use App\Models\DownloadableFileType;

it('returns values for APPF', function () {
    expect(DownloadableFileType::APPF)
        ->path()->toBe('APPF 2025.pdf')
        ->displayName()->toBe('APPF');
});

it('returns values for flyer', function () {
    expect(DownloadableFileType::Flyer)
        ->path()->toBe('Flyer ET 2025.pdf')
        ->displayName()->toBe('Infoflyer');
});

it('returns values for rules', function () {
    expect(DownloadableFileType::Rules)
        ->path()->toBe('Verhaltensregeln 2025.pdf')
        ->displayName()->toBe('Verhaltensregeln');
});
