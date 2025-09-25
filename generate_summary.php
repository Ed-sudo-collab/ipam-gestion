<?php
$folders = [
    'app/Models',
    'app/Http/Livewire',
    'app/Http/Controllers', // <-- ajouté pour inclure les controllers
    'database/migrations',
    'routes',
    'resources/views',
];

$outputFile = 'project_summary.txt';
file_put_contents($outputFile, "Résumé compressé du projet Laravel\n\n");

foreach ($folders as $folder) {
    if (!is_dir($folder)) continue;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getRealPath());
            $content = preg_replace('/\s+/', ' ', $content); // compact whitespace
            file_put_contents($outputFile, "=== {$file->getPathname()} ===\n$content\n\n", FILE_APPEND);
        } elseif ($file->isFile() && in_array($file->getExtension(), ['blade.php'])) {
            $content = file_get_contents($file->getRealPath());
            $content = preg_replace('/\s+/', ' ', $content);
            file_put_contents($outputFile, "=== {$file->getPathname()} ===\n$content\n\n", FILE_APPEND);
        }
    }
}

echo "Fichier résumé généré : {$outputFile}\n";
