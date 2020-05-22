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
