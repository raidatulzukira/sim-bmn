<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$uuid1 = (string) \Illuminate\Support\Str::uuid();
$uuid2 = (string) \Illuminate\Support\Str::uuid();
\App\Models\Pemeliharaan::whereIn('id', [1,2,3,4,5])->update(['batch_id' => $uuid1]);
\App\Models\Pemeliharaan::where('id', 6)->update(['batch_id' => $uuid2]);
echo "Data fixed\n";
