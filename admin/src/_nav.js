/* eslint-disable no-unused-vars */

export default (i18n, admin) => [
    {
        icon: 'mdi-view-dashboard',
        text: i18n.t('menu.dashboard'),
        link: '/',
    },
    admin.can(['admin']) && { divider: true },
    admin.can(['admin']) && { heading: i18n.t('menu.business') },

    admin.can(['admin']) && {
        icon: 'mdi-card-account-details',
        text: i18n.t('menu.events'),
        link: '/events',
    },
    admin.can(['admin']) && {
        icon: 'mdi-notebook-edit',
        text: i18n.t('menu.logbook'),
        link: '/logbook',
    },
    admin.can(['admin']) && { divider: true },

    admin.can(['admin']) && {
        text: i18n.t('menu.customers'),
        children: [
            {
                icon: 'mdi-account',
                text: i18n.t('menu.private-customers'),
                link: '/private-customers',
            },
            {
                icon: 'mdi-account-hard-hat',
                text: i18n.t('menu.brand-customers'),
                link: '/brand-customers',
            },
            {
                icon: 'mdi-account-tie',
                text: i18n.t('menu.county-customers'),
                link: '/county-customers',
            },
        ],
    },
    admin.can(['admin']) && { divider: true },

    admin.can(['admin']) && {
        text: i18n.t('menu.employees'),
        children: [
            {
                icon: 'mdi-hand-saw',
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
    admin.getResourceLink('tickets'),

    admin.can(['admin']) && { divider: true },
    admin.can(['admin']) && { heading: i18n.t('menu.reports') },
    admin.can(['admin']) && {
        icon: 'mdi-stats',
        text: i18n.t('menu.reports'),
        link: '/report',
    },
    admin.can(['employee']) && { divider: true },
    admin.can(['employee']) && { heading: i18n.t('menu.my-events') },
    admin.can(['employee']) && {
        icon: 'mdi-card-account-details',
        text: i18n.t('menu.act_events'),
        link: '/active-events',
    },
    admin.can(['employee']) && {
        icon: 'mdi-notebook-edit',
        text: i18n.t('menu.act_logbook'),
        link: '/active-logbook',
    },


];
