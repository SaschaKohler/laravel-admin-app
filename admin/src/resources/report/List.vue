<template>
    <v-row>
        <v-col cols="12" lg="12">
            <base-material-card :icon="resource.icon" :title="title">
                <va-list
                    :filters="filters"
                    :include="['customer']"
                    disable-create
                    disable-global-search
                    disable-export
                >
                    <va-data-table
                        :fields="fields"
                        disable-select
                        disable-actions
                    >
                        <template v-slot:[`field.users`]="{ value }">
                            <va-reference-field
                                reference="users"
                                v-for="(item, i) in value"
                                :key="i"
                                color="green lighten-2"
                                :item="item"
                                action=""
                            >

                                    <h3>{{ item.name }}</h3>
                                <p v-if="item.pivot['hours']">
                                    {{ item.pivot['hours'] }} h
                                </p>
                                <p v-else>
                                    kein Eintrag
                                </p>

                            </va-reference-field>
                        </template>
                    </va-data-table>
                </va-list>
            </base-material-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: [
                {
                    source: 'users',
                    type: 'select',
                    attributes: {
                        reference: 'users',
                        itemValue: 'name',
                    }
                },
                {
                    source: 'starts_after',
                    type: 'date',
                    attributes: {
                        format: 'short',
                    },
                },
                {
                    source: 'starts_before',
                    type: 'date',
                    attributes: {
                        format: 'short',
                    },
                },
                {
                    source: 'finished',
                    type: 'Boolean',
                },
            ],
            fields: [
                'type',
                {source: 'start', type: 'date', sortable: true},
                {
                    source: 'customer',
                    type: 'reference',
                    attributes: {reference: 'customers', action: 'show', itemText: 'last'},
                },
                {
                    source: 'users',
                    sortable: false,
                    attributes: {
                        itemText: () => {
                            return 'Hello World'
                        },
                    }
                },
                {source: 'sumHours', sortable: true},
            ],
        };

    },

};
</script>

<style scoped></style>
