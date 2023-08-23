<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class resetsampel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resetsampel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command membuat data sampel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Menghapus isi direktori storage/public
        Storage::deleteDirectory('public/gambar');

        $this->call('migrate:reset');

        // Jalankan perintah kedua
        $this->call('migrate:fresh');

        // Jalankan perintah ketiga
        $this->call('db:seed', ['--class' => 'DataSampel']);

        $this->info('Data Sampel selesai dibuat');
    }
}
