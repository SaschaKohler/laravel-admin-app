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
        label: 'type',
        permissions: ['admin'],
        include: ['vehicles', 'customers', 'users', 'tools'],
    },
    {
        name: 'active_events',
        api: 'events',
        icon: 'mdi-account',
        routes: ['list', 'edit', 'show'],
        permissions: ['employee'],
        include: ['vehicles', 'customers', 'users', 'tools'],
    },
    {
        name: 'logbook',
        api: 'events',
        icon: 'mdi-notebook-edit',
        permissions: ['admin'],
        include: ['vehicles', 'users', 'tools'],
    },
    {
        name: 'active-logbook',
        api: 'events',
        icon: 'mdi-notebook-edit',
        permissions: ['employee'],
        routes: ['list', 'edit'],
        include: ['vehicles', 'users', 'tools'],
    },
    {
        name: 'customers',
        icon: 'mdi-account-group',
        label: (customers) => {
            return (customers.first + ' ' + customers.last + ' / ' + customers.city  );
        },
        permissions: ['admin'],
    },
    {
        name: 'vehicles',
        icon: 'mdi-car',
        label: 'branding',
        permissions: ['admin'],
        include: ['events'],
    },
    {
        name: 'tools',
        icon: 'mdi-tool',
        label: 'title',
        permissions: ['admin'],
    },
    {
        name: 'tickets',
        icon: 'mdi-ticket',
        label: 'ticket',
        permissions: ['admin', 'employee'],
        include: ['event', 'user'],
    },
];
