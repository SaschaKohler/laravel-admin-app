export default [
    {
        name: "users",
        icon: "mdi-account",
        routes: ["list"]
    },
    {
        name: "events",
        icon: "mdi-account",
        label: "event",
        permissions: [
            "admin",
            "employee",
            {name: "employee", actions: ['list', 'show', 'edit']}
        ],
        include: {expand: ['vehicles', 'customers']},
    },
    {
        name: "customers",
        icon: "mdi-alien",
        label: "last",
        permissions: [
            "admin",
            {actions: ["add"]}
        ],
    },
    {
        name: "vehicles",
        icon: "mdi-car",
        label: "branding",
        permissions: [
            "admin",
            {actions: ["add"]}
        ],
    },
    {
        name: "statistics",
        icon: "mdi-account",
        label: "branding",
        permissions: [
            "admin",
            {actions: ["add"]}
        ],
    },

];
