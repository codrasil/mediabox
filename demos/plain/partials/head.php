<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width, shrink-to-fit=no">

    <title>Codrasil/Mediabox Demo</title>

    <link href="https://unpkg.com/tailwindcss@^1.2.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.2.45/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="overflow-x-hidden">
    <div class="flex mb-4 mt-4">
        <div class="w-4/5 md:w-2/3 mx-auto my-6">
            <h5 class="text-gray-600 font-bold mb-0 text-xs uppercase">Demo</h5>
            <div class="flex space-between">
                <div class="w-full inline-block mt-3 mb-6">
                    <img width="200" src="../logo.svg" alt="">
                </div>
                <div class="w-full inline-block">
                    <nav class="flex w-full justify-end text-right">
                        <a class="ml-6 bg-white hover:bg-gray-100 py-1 px-3 border border-gray-400 rounded shadow focus:shadow-inner text-sm" target="_blank" title="github@codrasil/mediabox" href="https://github.com/codrasil/mediabox"><i class="mdi mdi-github">&nbsp;</i> View on GitHub</a>
                    </nav>
                </div>
            </div>
            <p class="text-gray-700 mb-3 text-base">All operations are contained inside <code class="bg-blue-100 border border-blue-200 p-1 rounded relative text-xs"><?php echo $mediabox->getRootPath(); ?></code> folder.</p>
            <!-- /codrasil/mediabox/demos/plain/storage/ -->
            <p class="text-gray-700 mb-3 text-base">This file showcases the library when used in a plain, no framework PHP project.</p>
        </div>
    </div>
