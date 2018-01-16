import BlankSubmenu from "../../dashboard/components/submenu/Blank"
import ChatView from "../../dashboard/components/chat/ChatView"
import MainView from "../../dashboard/components/MainView"

export default [
    {
        path: '/',
        name: 'main',
        components: {
            default: MainView,
            title: {template: '<h1>Dashboard</h1>'},
            submenu: BlankSubmenu
        }
    },
    {
        path: '/chat',
        name: 'chat',
        components: {
            default: ChatView,
            title: { template: '<h1>Chat</h1>' },
            submenu: BlankSubmenu
        }
    },
];