<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
