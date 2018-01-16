import MenuView from "../../dashboard/components/menu/MenuView"
import MenuAddView from "../../dashboard/components/menu/MenuAdd"
import BackSubmenu from "../../dashboard/components/submenu/Back"
import MenuSubmenu from "../../dashboard/components/submenu/MenuManagement"

export default [
    {
        path: '/menu',
        name: 'menu',
        components: {
            default: MenuView,
            title: { template: '<h1>Menu entries</h1>' },
            submenu: MenuSubmenu
        }
    },
    {
        path: '/menu/add',
        name: 'addEntry',
        components: {
            default: MenuAddView,
            title: { template: '<h1>Add menu entry</h1>' },
            submenu: BackSubmenu
        }
    },
]