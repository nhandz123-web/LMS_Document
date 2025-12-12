<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Google\Service\Drive as GoogleServiceDrive;
use Illuminate\Filesystem\FilesystemAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('google', function ($app, $config) {

            $client = new \Google_Client();
            // Đường dẫn TỚI file JSON service account (đảm bảo file tồn tại)
            $client->setAuthConfig(storage_path('credentials/itdocs-uploader-b76e335b5ce3.json'));
            $client->addScope(GoogleServiceDrive::DRIVE);   // hoặc DRIVE_FILE

            $service = new GoogleServiceDrive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folderId']);

            $filesystem = new Filesystem($adapter);

            return new FilesystemAdapter($filesystem, $adapter, $config);
        });
    }
    public function register() {}
}