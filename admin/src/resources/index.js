export default [
    {
        name: 'users',
        icon: 'mdi-account',
        label: 'name',
        routes: ['list', 'show'],
    },
    {
        name: 'events',
        icon: 'mdi-account',
        label: 'event',
        permissions: ['admin', 'employee'],
        include: ['vehicles', 'customers', 'users', 'tools'],
    },

    {
        name: 'customers',
        icon: 'mdi-alien',
        label: 'last',
        permissions: ['admin'],
    },
    {
        name: 'logbook',
        api: 'events',
        icon: 'mdi-alien',
        permissions: ['admin'],
        include: ['vehicles'],
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
