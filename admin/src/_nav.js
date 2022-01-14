/* eslint-disable no-unused-vars */

export default (i18n, admin) => [
    {
        icon: 'mdi-view-dashboard',
        text: i18n.t('menu.dashboard'),
        link: '/',
    },
    admin.can(['admin', 'employee']) && { divider: true },
    admin.can(['admin', 'employee']) && { heading: i18n.t('menu.business') },

    admin.can(['admin', 'employee']) && {
        icon: 'mdi-card-account-details',
        text: i18n.t('menu.events'),
        link: '/events',
    },
    admin.can(['admin', 'employee']) && {
        icon: 'mdi-notebook-edit',
        text: i18n.t('menu.logbook'),
        link: '/logbook',
    },

    admin.can(['admin']) && {
        icon: 'mdi-account-group',
        text: i18n.t('menu.customers'),
        link: '/customers',
    },

    admin.can(['admin']) && {
        icon: 'mdi-account',
        text: i18n.t('menu.employees'),
        children: [
            {
                icon: 'mdi-account-hard-hat',
                text: i18n.t('menu.users'),
                link: '/users',
            },
        ],
    },
    admin.can(['admin']) && { divider: true },
    admin.can(['admin']) && { heading: i18n.t('menu.garage') },
    admin.can(['admin']) && {
        icon: 'mdi-car',
        text: i18n.t('menu.vehicles'),
        link: '/vehicles',
    },
    admin.can(['admin']) && {
        icon: 'mdi-tools',
        text: i18n.t('menu.tools'),
        link: '/tools',
    },
    admin.can(['employee']) && { divider: true },
    admin.can(['employee']) && { heading: i18n.t('menu.my-events') },
    admin.can(['employee']) && {
        icon: 'mdi-card-account-details',
        text: i18n.t('menu.my-events'),
        link: '/events',
    },
    admin.can(['employee']) && {
        icon: 'mdi-notebook-edit',
        text: i18n.t('menu.my-logbook'),
        link: '/my-logbook',
    },
];
