<?php
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    // ...
    $framework
        ->defaultLocale('fr')
        ->translator()
            ->defaultPath('%kernel.project_dir%/translations')
    ;
};