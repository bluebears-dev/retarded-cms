import UsersTable from "../../dashboard/components/user/UsersTable"
import AddUserView from "../../dashboard/components/user/AddUser"
import BackSubmenu from "../../dashboard/components/submenu/Back"
import UserManagementSubmenu from "../../dashboard/components/submenu/UserManagement"

export default [
    {
        path: '/users',
        name: 'users',
        components: {
            default: UsersTable,
            title: { template: '<h1>User Management</h1>' },
            submenu: UserManagementSubmenu
        }
    },
    {
        path: '/users/add',
        name: 'addUserView',
        components: {
            default: AddUserView,
            title: { template: '<h1>Add User</h1>' },
            submenu: BackSubmenu
        }
    },
];