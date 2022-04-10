<template>
    <base-material-card
        :icon="resource.icon"
        :title="$i18n.t('menu.brand-customers')"
    >
        <va-list :filters="filters" :filter="{ type: 2 }">
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
                'last',
                'first',
                'brand',
                { source: 'offer', type: 'boolean' },
            ],

            fields: [
                { source: 'brand', sortable: true },
                {
                    source: 'last',
                    sortable: true,
                    attributes: { label: 'customers' },
                },
                { source: 'email', sortable: true },
                { source: 'phone', sortable: false },
                { source: 'street', sortable: true },
                { source: 'city', sortable: true },
                { source: 'offer', type: 'boolean', sortable: true },
            ],
        };
    },
    methods: {},
};
</script>
