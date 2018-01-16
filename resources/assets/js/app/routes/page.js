import PageAddView from "../../dashboard/components/page/PageAdd"
import PageEditView from "../../dashboard/components/page/PageEdit"
import PageList from "../../dashboard/components/page/PageView"
import PageSubmenu from "../../dashboard/components/submenu/PageManagement"
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
        name: 'addPage',
        components: {
            default: PageAddView,
            title: { template: '<h1>Create page</h1>' },
            submenu: BackSubmenu
        }
    },
    {
        path: '/pages/edit/:page',
        name: 'editPage',
        components: {
            default: PageEditView,
            title: { template: '<h1>Edit page</h1>' },
            submenu: BackSubmenu
        },
        props: {
            default: true,
            title: false,
            submenu: false
        },
    }
]