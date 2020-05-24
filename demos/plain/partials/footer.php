    <div class="fixed bottom-0 bg-white border w-full text-gray-700">
        <div class="flex mb-4 mt-4">
            <div class="w-4/5 md:w-2/3 mx-auto md:space-x-4">
                <div class="flex justify-between">
                    <div class="inline-block">
                        <span class="mdi mdi-chart-arc"></span>
                        <small class="text-sm">Total size: <?php echo $mediabox->totalSize(); ?> (<?php echo $mediabox->totalFileCount(); ?> items)</small>
                    </div>

                    <div class="inline-block md:space-x-4">
                        <div class="inline-block">
                            <span class="mdi mdi-harddisk"></span>
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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="vendor.js"></script>
    <script src="app.js"></script>
</body>
</html>
