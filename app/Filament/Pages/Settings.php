<?php

namespace App\Filament\Pages;

use App\Settings\General;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class Settings extends SettingsPage
{
    protected static ?string $navigationIcon = "heroicon-o-cog-6-tooth";

    protected static string $settings = General::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            Components\TextInput::make("site_name")
                ->label("Site Name")
                ->columnSpanFull()
                ->required(),
            Components\Textarea::make("site_description")
                ->label("Site Description")
                ->columnSpanFull()
                ->required(),
            Components\Checkbox::make("site_active")
                ->label("Site Active")
                ->required(),
        ]);
    }
}
