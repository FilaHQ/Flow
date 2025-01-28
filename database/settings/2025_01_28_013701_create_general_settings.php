<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add("general.site_name", "Flow");
        $this->migrator->add(
            "general.site_description",
            "Filament Based Content Engine"
        );
        $this->migrator->add("general.site_active", true);
    }
};
