<?php

namespace Michaeld555\FilamentCroppie;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Michaeld555\FilamentCroppie\Services\UpdateFile;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentCroppieServiceProvider extends PackageServiceProvider
{

    public static string $name = 'filament-croppie';

    public static string $viewNamespace = 'filament-croppie';

    public function configurePackage(Package $package): void
    {

        $package->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews();

        $package->hasInstallCommand(function (InstallCommand $command) {

            $command
                ->startWith(function (InstallCommand $command) {

                    if ($command->confirm('Would you like to publish the config file?', false)) {
                        $command->callSilent('vendor:publish', ['--tag' => 'filament-croppie-config', '--force' => true]);
                    }

                    if ($command->confirm('Would you like to publish the translations?', false)) {
                        $command->callSilent('vendor:publish', ['--tag' => 'filament-croppie-translations', '--force' => true]);
                    }

                    if ($command->confirm('Great! Would you like to show some love by starring Filament Croppie on GitHub?', true)) {
                        exec(PHP_OS_FAMILY === 'Darwin' ? 'open https://github.com/michaeld555/filament-croppie' : (PHP_OS_FAMILY === 'Windows' ? 'start https://github.com/michaeld555/filament-croppie' : (PHP_OS_FAMILY === 'Linux' ? 'xdg-open https://github.com/michaeld555/filament-croppie' : throw new \RuntimeException('Unable to open browser. OS not supported.'))));
                    }

                })
                ->publishAssets()
                ->endWith(function (InstallCommand $command) {

                    $command->info('Enjoy using Filament Croopie!');

                });

        });

        Livewire::component('filament-croppie::update-file', UpdateFile::class);

        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

    }

    /**
     * @return array<\Filament\Support\Assets\Asset>>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('filament-croppie', __DIR__ . '/../resources/dist/filament-croppie.css')->loadedOnRequest(),
            Js::make('filament-croppie', __DIR__ . '/../resources/dist/filament-croppie.js')->loadedOnRequest()
        ];
    }

    protected function getAssetPackageName(): string
    {
        return 'michaeld555/filament-croppie';
    }

}
