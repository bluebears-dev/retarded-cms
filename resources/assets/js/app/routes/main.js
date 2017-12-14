import BlankSubmenu from "../../dashboard/components/submenu/Blank"

export default [
    {
        path: '/',
        name: 'main',
        components: {
            default: null,
            title: { template: '<h1>&nbsp;</h1>' },
            submenu: BlankSubmenu
        }
    },
];