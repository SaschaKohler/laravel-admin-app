<template>
    <base-material-card>
        <va-list :filters="filters">
            <va-data-table :fields="fields"> </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: ['id', 'name', 'city'],
            fields: [
                'type',
                { source: 'name', sortable: true },
                { source: 'email', sortable: true },
                { source: 'phone', sortable: false },
                { source: 'street', sortable: true },
                { source: 'city', sortable: true },
            ],
        };
    },
    methods: {},
};
</script>
