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
        icon: 'mdi-globe-model',
        text: i18n.t('menu.events'),
        link: '/events',
    },
    admin.can(['admin']) && {
        icon: 'mdi-globe-model',
        text: i18n.t('menu.logbook'),
        link: '/logbook',
    },


    admin.can(['admin']) && {
        icon: 'mdi-alien',
        text: i18n.t('menu.customers'),
        link: '/customers',
    },

    admin.can(['admin']) && {
        icon: 'mdi-account',
        text: i18n.t('menu.employees'),
        children: [
            {
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
    admin.can(['employee']) && { heading: i18n.t('menu.myEvents') },
    admin.can(['employee']) && {
        icon: 'mdi-tools',
        text: i18n.t('menu.myEvents'),
        link: '/my.events',
    },
];
