<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list
            :filters="filters"
            :include="['customer', 'vehicles', 'users', 'tools']"
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
                <template v-slot:[`item.actions`]="{ item }">
                    <send-mail-button
                        :item="item"
                        :confirm="true"
                    ></send-mail-button>
                    <send-mail-button
                        :item="item"
                        :confirm="false"
                    ></send-mail-button>
                </template>
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
import SendMailButton from '@/components/buttons/SendMailButton';

export default {
    components: { SendMailButton },
    props: ['resource', 'title', 'item'],
    data() {
        return {
            filters: ['customer', 'users', 'vehicles', 'type'],
            fields: [
                { source: 'type', sortable: true },
                {
                    source: 'start',
                    type: 'date',
                    attributes: { format: 'long' },
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
                    sortable: true,
                },
                {
                    source: 'vehicles',
                },
                { source: 'finished', type: 'boolean', sortable: true },
                { source: 'fixed', type: 'boolean', sortable: true },
            ],
        };
    },
    methods: {},
};
</script>
