const folderMenus = [

  { name: '<span class="mr-2"><i class="mdi mdi-content-copy">&nbsp;</i></span>Make a copy', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=copy]').click()
  }},

  { name: '<span class="mr-2"><i class="mdi mdi-download-outline">&nbsp;</i></span>Download', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=download]').click()
  } },

  { name: '<span class="mr-2"><i class="mdi mdi-form-textbox">&nbsp;</i></span>Rename...', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    console.log(parent.find('[data-action=rename]'))
    parent.find('[data-action=rename]').get(0).click()
  }},

  {},

  { name: '<span class="mr-2"><i class="mdi mdi-delete-outline">&nbsp;</i></span>Delete', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=delete]').click()
  }},

]

const fileMenus = [
  { name: '<span class="mr-2"><i class="mdi mdi-magnify">&nbsp;</i></span>Preview', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=preview]').get(0).click()
  }},
].concat(folderMenus)

new ContextMenu('table .contextmenu.dir td, table .contextmenu.dir .contextmenu-target', folderMenus, {
  minimalStyling: false,
  className: 'max-w w-48 rounded overflow-hidden shadow-lg border border-gray-200 bg-white focus:outline-none',
});

new ContextMenu('table .contextmenu.file td, table .contextmenu.file .contextmenu-target', fileMenus, {
  minimalStyling: false,
  className: 'max-w w-48 rounded overflow-hidden shadow-lg border border-gray-200 bg-white focus:outline-none',
});
