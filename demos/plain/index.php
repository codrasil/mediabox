    <?php require_once __DIR__.'/mediabox.php'; ?>
<?php include_once __DIR__.'/partials/head.php'; ?>

    <div class="flex mb-4 mt-4 pb-20">
        <div class="w-4/5 md:w-2/3 mx-auto">
            <div class="flex content-center mb-8">
                <div class="w-full">
                    <h2 class="inline-block text-2xl tracking-tight font-bold"><?php echo $mediabox->getRootFolderName(); ?></h2>
                    <div class="inline-block ml-4 space-x-2">
                        <!-- ADD MODAL -->
                        <?php include 'partials/modal.add.php'; ?>
                        <a role="button" href="#modal-add" title="New Folder" class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded shadow">
                            <i class="mdi mdi-folder-plus">&nbsp;</i>
                            New Folder
                        </a>
                        <!-- ADD MODAL -->
                        <!-- UPLOAD MODAL -->
                        <?php include 'partials/modal.upload.php'; ?>
                        <a role="button" href="#modal-upload" title="Upload file" class="bg-white hover:bg-gray-100 text-gray-800 py-2 px-4 border border-gray-400 rounded shadow">
                            <i class="mdi mdi-upload">&nbsp;</i>
                            Upload File
                        </a>
                        <!-- UPLOAD MODAL -->
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2">
                    <p class="text-sm text-gray-700 mb-4">
                        <a href="<?php echo url_params(['p' => '']) ?>" class="pr-1 text-blue-500 hover:text-blue-800"><i class="mdi mdi-home">&nbsp;</i></a>
                        <?php foreach ($mediabox->breadcrumbs() as $crumb) : ?>
                          <a href="<?php echo $crumb->url; ?>" class="mx-1 text-blue-500 hover:text-blue-800"><span class="mr-2">/</span><?php echo $crumb->text; ?></a>
                        <?php endforeach; ?>
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

            <div class="overflow-x-auto">
                <table style="min-width: max-content;" class="table-auto w-full text-left table-collapse">
                    <thead>
                        <tr class="border-t border-b border-gray-300">
                            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">File</th>
                            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100 text-right">Size</th>
                            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">Type</th>
                            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100">Owner</th>
                            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100 text-right">Permission</th>
                            <th class="text-sm text-left font-semibold text-gray-700 p-2 bg-gray-100 text-right">Last Modified</th>
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
                            <tr data-fragment="<?php echo $file->fragment() ?>" class="<?php echo $file->type() ?> contextmenu focus:bg-gray-200 hover:bg-gray-200" tabindex="0">
                                <td class="text-gray-900 p-2 truncate block">
                                    <?php if ($file->isDir()) : ?>
                                        <a href="<?php echo $file->fragment(); ?>" class="contextmenu-target hover:text-blue-800"><i class="<?php echo $file->icon(); ?>">&nbsp;</i><?php echo $file->name(); ?></a>
                                    <?php else: ?>
                                        <a data-action="preview" target="_blank" href="media.php?<?php echo $file->fragment(); ?>" class="contextmenu-target hover:text-blue-800"><i class="<?php echo $file->icon(); ?>">&nbsp;</i><?php echo $file->name(); ?></a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-gray-900 p-2 text-right">
                                    <?php if ($file->isDir()) : ?>
                                        <?php echo $file->count(); ?> <?php echo $file->count() > 1 ? 'items' : 'item'; ?>
                                    <?php else: ?>
                                        <?php echo $file->size(); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="text-gray-900 p-2"><span title="<?php echo $file->mimetype(); ?>" class="truncate w-32 block"><?php echo $file->mimetype(); ?></span></td>
                                <td class="text-gray-900 p-2"><?php echo $file->ownername(); ?></td>
                                <td class="text-gray-900 p-2 text-right"><?php echo $file->permission(); ?></td>
                                <td class="text-gray-900 p-2 text-right"><?php echo $file->modified()->format('M d, Y h:i a'); ?></td>
                                <td class="text-gray-900 p-2 mx-auto text-center">
                                    <div class="inline-flex space-x-2">
                                        <!-- COPY FORM -->
                                        <form action="ops/copy.php?name=<?php echo $file->filename() ?>" method="post">
                                            <input type="hidden" name="name" value="<?php echo $file->getCopyName(); ?>">
                                            <button data-action="copy" title="Make a copy" class="bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow focus:shadow-inner text-sm">
                                                <i class="mdi mdi-content-copy">&nbsp;</i>
                                            </button>
                                        </form>
                                        <!-- COPY FORM -->

                                        <!-- RENAME FORM -->
                                        <?php include 'partials/modal.rename.php' ?>
                                        <a data-action="rename" role="button" href="#modal-rename-<?php echo $file->fragment(); ?>" title="Rename" class="block bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow focus:shadow-inner text-sm">
                                            <i class="mdi mdi-form-textbox">&nbsp;</i>
                                        </a>
                                        <!-- RENAME FORM -->

                                        <!-- DELETE FORM -->
                                        <form action="ops/delete.php?name=<?php echo $file->filename() ?>" method="post">
                                            <input type="hidden" name="name" value="<?php echo $file->filename(); ?>">
                                            <button data-action="delete" title="Delete" class="bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow focus:shadow-inner text-sm">
                                                <i class="mdi mdi-delete-outline">&nbsp;</i>
                                            </button>
                                        </form>
                                        <!-- DELETE FORM -->

                                        <!-- DOWNLOAD FORM -->
                                        <form action="ops/download.php?f=<?php echo $file->filename(); ?>" method="post">
                                            <input type="hidden" name="name" value="<?php echo $file->filename(); ?>">
                                            <button data-action="download" title="Download" class="bg-white hover:bg-gray-100 text-gray-800 py-1 px-3 border border-gray-400 rounded shadow focus:shadow-inner text-sm">
                                                <i class="mdi mdi-download-outline">&nbsp;</i>
                                            </button>
                                        </form>
                                        <!-- DOWNLOAD FORM -->
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include_once __DIR__.'/partials/footer.php'; ?>
