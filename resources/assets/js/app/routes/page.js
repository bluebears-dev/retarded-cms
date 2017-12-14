import PageAddView from "../../dashboard/components/page/PageAdd"
import PageList from "../../dashboard/components/page/PageList"
import PageSubmenu from "../../dashboard/components/submenu/Page"
import BackSubmenu from "../../dashboard/components/submenu/Back"

export default [
    {
        path: '/pages',
        name: 'pages',
        components: {
            default: PageList,
            title: { template: '<h1>Pages</h1>' },
            submenu: PageSubmenu
        }
    },
    {
        path: '/pages/add',
        name: 'addPages',
        components: {
            default: PageAddView,
            title: { template: '<h1>Create page</h1>' },
            submenu: BackSubmenu
        }
    }
]