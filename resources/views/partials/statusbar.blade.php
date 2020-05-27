<div class="fixed bottom-0 bg-white border w-full text-gray-700">
  <div class="flex mb-4 mt-4">
    <div class="w-4/5 md:w-2/3 mx-auto md:space-x-4">
      <div class="flex justify-between">
        <div class="inline-block">
          <span class="mdi mdi-chart-arc"></span>
          <small class="text-sm">@lang('Total size'): {{ $mediabox->totalSize() }} ({{ $mediabox->totalFileCount() }} @lang('items'))</small>
        </div>

        <div class="inline-block md:space-x-4">
          <div class="inline-block">
            <span class="mdi mdi-harddisk"></span>
            <small class="text-sm">@lang('Free space'): {{ $mediabox->freeDiskSpace() }}</small>
            <em>@lang('of')</em>
            <small class="text-sm">{{ $mediabox->totalDiskSpace() }}</small>
          </div>
          <div class="inline-block">
            <span class="mdi mdi-memory">&nbsp;</span>
            <small class="text-sm">@lang('Memory used'): {{ $mediabox->memoryUsage() }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
