<?php require_once __DIR__.'/mediabox.php'; ?>
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

    <div class="flex mb-4 mt-4 pb-20">
        <div class="w-2/3 mx-auto">
            <div class="flex content-center mb-8">
                <div class="w-full">
                    <h2 class="inline-block text-2xl tracking-tight font-bold"><?php echo $mediabox->getRootFolderName(); ?></h2>
                    <div class="inline-block ml-4">
                        <!-- ADD MODAL -->
                        <?php include 'partials/modal.add.php'; ?>
                        <a role="button" href="#modal-add" title="New Folder" class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded shadow">
                            <i class="mdi mdi-folder-plus">&nbsp;</i>
                            New Folder
                        </a>
                        <!-- ADD MODAL -->
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2">
                    <p class="text-sm text-gray-700 mb-4">
                        <a href="?p" class="pr-1 text-blue-500 hover:text-blue-800 "><i class="mdi mdi-home">&nbsp;</i></a>
                        <?php echo $mediabox->getCurrentPath(); ?>
                    </p>
                </div>
                <div class="w-1/2 text-right">
                    <label class="toggle">
                        <span class="toggle-label">Show hidden files</span>
                        <input onchange="window.location.href = '<?php echo url_params(['h' => !$mediabox->getShowHiddenFilesValue()]) ?>'" class="toggle-checkbox" type="checkbox" <?php echo $mediabox->getShowHiddenFilesValue() ? 'checked' : null ?> name="h" value="1">
                        <div class="toggle-switch"></div>
                    </label>
                </div>
            </div>

            <table class="table-auto w-full text-left table-collapse">
                <thead>
                    <tr class="border-t border-b border-gray-300">
                        <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">File</th>
                        <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">Type</th>
                        <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">Owner</th>
                        <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">Size</th>
                        <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">Permission</th>
                        <th class="text-sm text-center font-semibold text-gray-700 p-2 bg-gray-100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($mediabox->isEmpty()) : ?>
                        <tr>
                            <td colspan="100%" class="p-8 text-gray-600 text-center">
                                <i class="mdi mdi-weather-windy text-6xl"></i>
                                <div>Folder is empty</div>
                                <a href="<?php echo url_params(['p' => null]) ?>" class="text-blue-500 hover:text-blue-800 block py-4">Back to <?php echo $mediabox->getRootFolderName(); ?></a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($mediabox->all() as $file) : ?>
                        <tr>
                            <td class="text-gray-900 p-2">
                                <?php if ($file->isDir()) : ?>
                                    <a href="<?php echo $file->fragment(); ?>" class="hover:text-blue-800"><i class="<?php echo $file->icon(); ?>">&nbsp;</i><?php echo $file->name(); ?></a>
                                <?php else: ?>
                                    <a href="media.php?<?php echo $file->fragment(); ?>" class="hover:text-blue-800"><i class="<?php echo $file->icon(); ?>">&nbsp;</i><?php echo $file->name(); ?></a>
                                <?php endif; ?>
                            </td>
                            <td class="text-gray-900 p-2"><?php echo $file->mimetype(); ?></td>
                            <td class="text-gray-900 p-2"><?php echo $file->ownername(); ?></td>
                            <td class="text-gray-900 p-2 text-right"><?php echo $file->size(); ?></td>
                            <td class="text-gray-900 p-2 text-right"><?php echo $file->permission(); ?></td>
                            <td class="text-gray-900 p-2">
                                <div class="inline-flex space-x-2">
                                    <form action="ops/copy.php?name=<?php echo $file->filename() ?>" method="post">
                                        <input type="hidden" name="name" value="<?php echo $file->getCopyName(); ?>">
                                        <button title="Make a copy" class="bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow text-sm">
                                            <i class="mdi mdi-content-copy">&nbsp;</i>
                                        </button>
                                    </form>

                                    <!-- RENAME FORM -->
                                    <?php include 'partials/modal.rename.php' ?>
                                    <a role="button" href="#modal-<?php echo $file->fragment(); ?>" title="Rename" class="bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow text-sm">
                                        <i class="mdi mdi-form-textbox">&nbsp;</i>
                                    </a>
                                    <!-- RENAME FORM -->

                                    <form action="ops/delete.php?name=<?php echo $file->filename() ?>" method="post">
                                        <input type="hidden" name="name" value="<?php echo $file->filename(); ?>">
                                        <button title="Delete" class="bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow text-sm">
                                            <i class="mdi mdi-delete-outline">&nbsp;</i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="fixed bottom-0 bg-white border w-full text-gray-700">
       <div class="flex mb-4 mt-4">
            <div class="w-2/3 mx-auto space-x-4">
                <div class="inline-block">
                    <span class="inline-block rounded-full bg-gray-500 h-3 w-3 mr-1"></span>
                    <small class="text-sm">Total size: <?php echo $mediabox->totalSize(); ?> (<?php echo $mediabox->totalFileCount(); ?> items)</small>
                </div>
                <div class="inline-block">
                    <span class="mdi mdi-harddisk mr-1"></span>
                    <small class="text-sm">Free space: <?php echo $mediabox->freeDiskSpace(); ?></small>
                    <em>of</em>
                    <small class="text-sm"><?php echo $mediabox->totalDiskSpace(); ?></small>
                </div>
                <div class="inline-block">
                    <span class="mdi mdi-memory">&nbsp;</span>
                    <small class="text-sm">Memory used: <?php echo $mediabox->memoryUsage(); ?></small>
                </div>
            </div>
        </div>
     </div>
</body>
</html>
