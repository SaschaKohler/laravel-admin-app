export default [
    {
        name: 'users',
        icon: 'mdi-hand-saw',
        label: 'name',
        routes: ['list', 'show']
    },
    {
        name: 'offers',
        icon: 'mdi-account',
        label: 'offer',
        permissions: ['admin', 'employee'],
        include: ['customer']

    },
    {
        name: 'events',
        icon: 'mdi-card-account-details',
        label: 'type',
        permissions: ['admin']
    },
    {
        name: 'active_events',
        api: 'events',
        icon: 'mdi-account',
        permissions: ['employee'],
        include: ['vehicles', 'customers', 'users', 'tools']
    },
    {
        name: 'logbook',
        api: 'events',
        icon: 'mdi-notebook-edit',
        permissions: ['admin']
    },
    {
        name: 'active-logbook',
        api: 'events',
        icon: 'mdi-notebook-edit',
        permissions: ['employee'],
        include: ['vehicles', 'users', 'tools']
    },
    {
        name: 'customers',
        icon: 'mdi-account-group',
        label: (customers) => {
            switch (customers.type) {
                case 1 :
                    return customers.last + ', ' + customers.first + ' / ' + customers.city + ' (Privat)';
                case 2:
                    return customers.last + ', ' + customers.first + ' / ' + customers.city + ' -- ' + customers.brand + ' (Firma)';
                case 3:
                    return customers.last + ', ' + customers.first + ' / ' + customers.county + ' (Gemeinde)';
            }
        },
        permissions: ['admin', 'employee'],
    },
    {
        name: 'private-customers',
        api: 'customers',
        icon: 'mdi-account',
        label: (customers) => {
            return (
                customers.first + ' ' + customers.last + ' ' + customers.city
            );
        },
        permissions: ['admin', 'employee'],
    },
    {
        name: 'brand-customers',
        api: 'customers',
        icon: 'mdi-account-hard-hat',
        label: (customers) => {
            return (
                customers.brand + ' ' + customers.last + ' ' + customers.city
            );
        },
        permissions: ['admin', 'employee'],
    },

    {
        name: 'county-customers',
        api: 'customers',
        icon: 'mdi-account-tie',
        label: (customers) => {
            return (
                customers.first + ' ' + customers.last + ' ' + customers.city
            );
        },
        permissions: ['admin', 'employee'],
    },
    {
        name: 'vehicles',
        icon: 'mdi-car',
        label: 'branding',
        permissions: ['admin'],
        include: ['events']
    },
    {
        name: 'tools',
        icon: 'mdi-tool',
        label: 'title',
        permissions: ['admin']
    },
    {
        name: 'tickets',
        icon: 'mdi-ticket',
        label: 'ticket',
        permissions: ['admin', 'employee'],
        include: ['event', 'user']
    },
    {
        name: 'report',
        icon: 'mdi-ticket',
        permissions: ['admin']
    },

]
