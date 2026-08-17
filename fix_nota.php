<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$peminjamans = App\Models\Peminjaman::whereNull('no_nota')->orWhere('no_nota', '')->get();

foreach ($peminjamans as $p) {
    $p->update([
        'no_nota' => 'PNJ-' . date('YmdHis', strtotime($p->created_at)) . '-' . str_pad($p->user_id, 3, '0', STR_PAD_LEFT)
    ]);
}

echo "Berhasil update " . count($peminjamans) . " data peminjaman.";
