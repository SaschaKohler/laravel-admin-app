/* eslint-disable no-unused-vars */

export default (i18n, admin) => [
    {
        icon: "mdi-view-dashboard",
        text: i18n.t("menu.dashboard"),
        link: "/",
    },
    {divider: true},
    {heading: i18n.t("menu.business")},


    admin.can(["admin", "employee"]) && {
        icon: "mdi-globe-model",
        text: i18n.t("menu.events"),
        link: "/events",
        // admin.getResourceLink("events"),
    },

    admin.can(["admin"]) && {
        icon: "mdi-alien",
        text: i18n.t("menu.customers"),
        link: "/customers",
    },
    admin.can(["admin"]) && {
        icon: "mdi-car",
        text: i18n.t("menu.vehicles"),
        link: "/vehicles",
    },
    admin.can(["admin"]) && {
        icon: "mdi-account",
        text: i18n.t("menu.employees"),
        children: [
            {
                text: i18n.t("menu.users"),
                link: "/users",
            },
        ],

    },


];
