import Options from "../../dashboard/components/options/Options"
import ThemesView from "../../dashboard/components/options/entries/Themes"
import BackSubmenu from "../../dashboard/components/submenu/Back"

export default [
    {
        path: '/options',
        name: 'options',
        components: {
            default: Options,
            title: { template: '<h1>Options</h1>' },
            submenu: BackSubmenu
        }
    },
    {
        path: '/options/themes',
        name: 'themes',
        components: {
            default: ThemesView,
            title: { template: '<h1>Dashboard Themes</h1>' },
            submenu: BackSubmenu
        }
    },
]