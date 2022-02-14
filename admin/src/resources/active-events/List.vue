<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list
            disable-query-string
            disable-export
            :include="['customer', 'vehicles', 'users', 'tools']"
            :sort-by="['updated_at']"
            :filter="{
                users_id: user.id,
            }"
        >
            <va-data-table :fields="fields">
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
                <template v-slot:[`field.tools`]="{ value }">
                    <v-chip-group column>
                        <va-reference-field
                            reference="tools"
                            v-for="(item, i) in value"
                            :key="i"
                            color="amber lighten-3"
                            chip
                            :label="$t('va.tools')"
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
                {
                    source: 'event_id',
                    type: 'reference',
                    sortable: false,
                    attributes: {
                        reference: 'events',
                    },
                },
                {
                    source: 'customer',
                    sortable: true,
                    type: 'reference',
                    attributes: {
                        reference: 'customers',
                        chip: true,
                        color: 'amber lighten-2',
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
                { source: 'finished', type: 'boolean' },
                {
                    source: 'updated_at',
                    type: 'date',
                    attributes: { format: 'time' },
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
