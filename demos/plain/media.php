<?php require_once __DIR__.'/mediabox.php'; ?>
<?php include_once __DIR__.'/partials/head.php'; ?>

    <div class="flex mb-4 mt-4 pb-20">
        <div class="w-2/3 mx-auto">
            <div class="flex content-center mb-8">
                <div class="w-full">
                    <h2 class="inline-block text-2xl tracking-tight font-bold"><?php echo $mediabox->getRootFolderName(); ?></h2>
                </div>
            </div>

            <div class="flex content-center mb-8">
                <div class="w-full">
                    <a href="index.php?<?php echo url_params(['p' => $mediabox->getCurrentPath(), 'f' => '']) ?>" class="text-sm inline-block">Back</a>
                </div>
            </div>

            <div class="max-w rounded overflow-hidden border border-gray-200 shadow-lg">
                <object class="w-full overflow-hidden block rounded p-2" data="<?php echo __storage($file) ?>" type="<?php echo $file->mimetype() ?>"></object>
                <!-- <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-gray-700 text-base">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
                    </p>
                </div> -->
            </div>

        </div>
    </div>

<?php include_once __DIR__.'/partials/footer.php'; ?>
