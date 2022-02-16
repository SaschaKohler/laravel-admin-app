<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list
            :filters="filters"
            disable-create
            disable-export
        >
            <va-data-table
                :fields="fields"
                disable-show
                disable-delete
                disable-clone
                disable-create-redirect
                disable-select
            >
                <template v-slot:[`field.users`]="{ value }">
                    <v-chip-group column>
                        <va-reference-field
                            reference="users"
                            v-for="(item, i) in value"
                            :key="i"
                            color="green lighten-2"
                            chip
                            small
                            :item="item"
                            action="show"
                        >
                            {{ item.name }}
                        </va-reference-field>
                    </v-chip-group>
                </template>

                <template v-slot:[`field.vehicles`]="{ value }">
                    <v-chip-group column>
                        <va-reference-field
                            reference="vehicles"
                            v-for="(item, i) in value"
                            :key="i"
                            color="grey lighten-2"
                            chip
                            small
                            :item="item"
                        >
                            {{ item.branding }}
                        </va-reference-field>
                    </v-chip-group>
                </template>
                <template v-slot:[`field.tools`]="{ value }">
                    <v-chip-group column>
                        <va-reference-field
                            reference="tools"
                            v-for="(item, i) in value"
                            :key="i"
                            color="amber lighten-2"
                            chip
                            small
                            :item="item"
                        >
                            {{ item.title }}
                        </va-reference-field>
                    </v-chip-group>
                </template>
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
import { mapState } from 'vuex';

export default {
    props: ['resource', 'title', 'item'],
    data() {
        return {
            filters: [
                'type',
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
                    source: 'users',
                    type: 'select',
                    attributes: {
                        reference: 'users',
                        itemValue: 'name',
                    },
                },
                {
                    source: 'vehicles',
                    type: 'select',
                    attributes: {
                        reference: 'vehicles',
                    },
                },
            ],
            fields: [
                { source: 'type', sortable: true },
                {
                    source: 'start',
                    type: 'date',
                    attributes: { format: 'short' },
                    sortable: true,
                },
                { source: 'recurrence', sortable: false },
                {
                    source: 'event_id',
                    type: 'reference',
                    sortable: false,
                    attributes: {
                        reference: 'events',
                    },
                },
                {
                    source: 'users',
                    sortable: false,
                },

                {
                    source: 'vehicles',
                    sortable: false,
                },
                {
                    source: 'tools',
                    sortable: false,
                },
                {
                    source: 'finished',
                    type: 'boolean',
                    sortable: true,
                },
                {
                    source: 'updated_at',
                    type: 'date',
                    sortable: true,
                    attributes: {
                        format: 'time',
                    },
                },
            ],
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
};
</script>
