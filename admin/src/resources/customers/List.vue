<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list :filters="filters">
            <va-data-table :fields="fields"></va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: ['id', 'city'],
            fields: [
                {source: 'first', sortable: true},
                {source: 'last', sortable: true},
                {source: 'street', sortable: true},
                {source: 'city', sortable: true},
                'phone',
                'notes',
            ],
        }
    },
}
</script>
