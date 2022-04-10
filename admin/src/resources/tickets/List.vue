<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list :filters="filters" :include="['event', 'user']">
            <va-data-table :fields="fields" disable-clone>
                <template v-slot:[`field.event`]="{ value }">
                    {{ value.type }}({{ value.start }})
                </template>
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: [],
            fields: [
                {
                    source: 'status',
                    type: 'select',
                    sortable: true,
                    attributes: {
                        chip: true,
                        color: (v) => this.$statusColor(v),
                    },
                },
                {
                    source: 'event',
                    type: 'reference',
                    attributes: { reference: 'events' },
                },
                {
                    source: 'user',
                    type: 'reference',
                    attributes: { reference: 'users' },
                },
                { source: 'rating', type: 'rating', sortable: true },
                {
                    source: 'body',
                    type: 'text',
                    attributes: { truncate: 50, multiline: true },
                },
            ],
        };
    },
};
</script>
<style scoped>
div {
    color: white;
}
</style>
