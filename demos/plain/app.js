const folderMenus = [

  { name: 'Make a copy', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=copy]').click()
  }},

  { name: 'Download', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=download]').click()
  } },

  { name: 'Rename...', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    console.log(parent.find('[data-action=rename]'))
    parent.find('[data-action=rename]').get(0).click()
  }},

  {},

  { name: 'Delete', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=delete]').click()
  }},

]

const fileMenus = [
  { name: 'Preview', className: 'hover:bg-gray-200 cursor-pointer py-2 px-4', fn: (target) => {
    let parent = $(target).parents('tr')
    parent.find('[data-action=preview]').get(0).click()
  }},
].concat(folderMenus)

new ContextMenu('table .contextmenu.dir td, table .contextmenu.dir .contextmenu-target', folderMenus, {
  minimalStyling: false,
  className: 'max-w w-20 rounded overflow-hidden shadow-lg border border-gray-200 bg-white focus:outline-none',
});

new ContextMenu('table .contextmenu.file td, table .contextmenu.file .contextmenu-target', fileMenus, {
  minimalStyling: false,
  className: 'max-w w-20 rounded overflow-hidden shadow-lg border border-gray-200 bg-white focus:outline-none',
});
