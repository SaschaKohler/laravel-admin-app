<template>
    <base-material-card :icon="resource.icon" :title="title">
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
            filters: ['type'],
            fields: [
                { source: 'type', sortable: true },
                'detail',
                {
                    source: 'customer',
                    type: 'reference',
                    attributes: { reference: 'customers' },
                },
                'notes',
            ],
        };
    },
};
</script>
