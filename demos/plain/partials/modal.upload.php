<div id="modal-upload" tabindex="0" class="modal-window fixed pin z-50 overflow-auto bg-black top-0 left-0 w-screen h-screen bg-opacity-25 flex">
  <div class="modal relative w-1/3 mx-auto flex-col p-8 flex">
    <form action="../ops/upload.php" method="post" enctype="multipart/form-data">
      <div class="bg-white border border-gray-200 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-8">
          <div class="text-xl mb-3 block font-semi-bold">Upload</div>
          <div class="mb-4">
            <input type="hidden" name="parent" value="<?php echo get_p_value(); ?>">
            <input class="appearance-none shadow-inner block w-full bg-gray-200 text-gray-700 border border-gray-300 rounded py-3 px-2 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" name="file" type="file">
          </div>
        </div>
        <div class="flex items-center justify-start space-x-4">
          <button type="submit" class="align-baseline bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 border border-blue-400 rounded shadow focus:shadow-inner">
            Upload
          </button>
          <a role="button" class="align-baseline bg-white hover:bg-gray-200 text-gray-700 py-2 px-4 hover:text-gray-800 border rounded shadow focus:shadow-inner" href="#">
            Cancel
          </a>
        </div>
      </div>
    </form>
  </div>
</div>
