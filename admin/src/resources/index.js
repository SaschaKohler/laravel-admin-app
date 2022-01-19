export default [
    {
        name: 'users',
        icon: 'mdi-account-hard-hat',
        label: 'name',
        routes: ['list', 'show'],
    },
    {
        name: 'events',
        icon: 'mdi-card-account-details',
        label: 'event',
        permissions: ['admin', 'employee'],
        include: ['vehicles', 'customers', 'users', 'tools'],
    },

    {
        name: 'logbook',
        api: 'events',
        icon: 'mdi-notebook-edit',
        permissions: ['admin', 'employee'],
        include: ['vehicles', 'users', 'tools'],
    },
    // {
    //     name: 'my_events',
    //     api: 'events',
    //     icon: 'mdi-card-account-details',
    //     permissions : ['employee'],
    //     // permissions: [
    //     //     { name: "employee", actions: ["list", "show", "edit",] },
    //     // ],
    //     include: ['vehicles', 'customers', 'users', 'tools'],
    // },
    // {
    //     name: 'my_logbook',
    //     api: 'events',
    //     icon: 'mdi-notebook-edit',
    //     permissions : ['employee'],
    //     // permissions: [
    //     //     { name: 'employee', actions: ["list","show","edit"] }
    //     //     ],
    //     include: ['vehicles', 'users', 'tools'],
    // },
    {
        name: 'customers',
        icon: 'mdi-account-group',
        label: 'last',
        permissions: ['admin'],
    },
    {
        name: 'vehicles',
        icon: 'mdi-car',
        label: 'branding',
        permissions: ['admin'],
    },
    {
        name: 'statistics',
        icon: 'mdi-account',
        label: 'branding',
        permissions: ['admin'],
    },
    {
        name: 'tools',
        icon: 'mdi-tool',
        label: 'title',
        permissions: ['admin'],
    },
];
