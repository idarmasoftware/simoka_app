<?php

$files = [
    'resources/views/welcome.blade.php',
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/layouts/app.blade.php',
    'resources/views/layouts/partials/sidebar.blade.php'
];

foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        // Change favicon type if applicable
        $content = str_replace('type="image/png" href="{{ asset(\'simonita.png\') }}"', 'type="image/svg+xml" href="{{ asset(\'simonita.svg\') }}"', $content);
        // Change img src
        $content = str_replace('simonita.png', 'simonita.svg', $content);
        file_put_contents($path, $content);
        echo "Updated in $file\n";
    }
}
