<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/app/Http/Controllers');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $original = $content;
        
        // Fix for Pemeliharaan
        $content = preg_replace(
            '/Pemeliharaan::selectRaw\(\s*\'COUNT\(\*\)\'\s*\)\s*->whereColumn\(\s*\'batch_id\'\s*,\s*\'pemeliharaan\.batch_id\'\s*\)/ms',
            "Pemeliharaan::selectRaw('COUNT(*)')->from('pemeliharaan as p_sub')->whereColumn('p_sub.batch_id', 'pemeliharaan.batch_id')",
            $content
        );
        
        // Fix for Peminjaman
        $content = preg_replace(
            '/Peminjaman::selectRaw\(\s*\'COUNT\(\*\)\'\s*\)\s*->whereColumn\(\s*\'batch_id\'\s*,\s*\'peminjaman\.batch_id\'\s*\)/ms',
            "Peminjaman::selectRaw('COUNT(*)')->from('peminjaman as p_sub')->whereColumn('p_sub.batch_id', 'peminjaman.batch_id')",
            $content
        );

        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            echo "Updated: " . $file->getPathname() . "\n";
        }
    }
}
