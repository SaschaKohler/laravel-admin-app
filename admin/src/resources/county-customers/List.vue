<template>
    <base-material-card
        :icon="resource.icon"
        :title="$i18n.t('menu.county-customers')"
    >
        <va-list :filters="filters" :filter="{ type: 3 }">
            <va-data-table :fields="fields"> </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: [
                'id',
                'city',
                'manager',
                'county',
                'name',
                { source: 'offer', type: 'boolean' },
            ],
            fields: [
                { source: 'county', sortable: true },
                { source: 'manager', sortable: true },
                { source: 'email', sortable: true },
                { source: 'email2', sortable: true },
                { source: 'phone', sortable: false },
                { source: 'phone2', sortable: false },
                { source: 'phone3', sortable: false },
                { source: 'street', sortable: true },
                { source: 'city', sortable: true },
                { source: 'offer', type: 'boolean', sortable: true },
            ],
        };
    },
    methods: {},
};
</script>
