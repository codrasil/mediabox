<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Codrasil/Mediabox Demo</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.2.45/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="pattern-topograpy h-16 w-screen"></div>
    <div class="flex mb-4 mt-4">
        <div class="w-2/3 mx-auto">
            <h5 class="text-gray-800 mb-0 text-xs uppercase">Demo</h5>
            <h1 class="mb-8 text-xl tracking-tight font-bold">Mediabox</h1>
            <p class="text-gray-700 mb-3 text-base">This is the <code class="font-semibold">codrasil/mediabox</code> demo page.</p>
            <p class="text-gray-700 mb-3 text-base">All operations are contained inside <code class="bg-blue-100 border border-blue-200 p-1 rounded relative text-xs"><?php echo $mediabox->getRootPath(); ?></code> folder.</p>
            <p class="text-gray-700 mb-3 text-base">This file showcases the library when used in a plain, no framework PHP project.</p>
        </div>
    </div>
