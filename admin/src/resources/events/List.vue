<template>
    <base-material-card
        :icon="resource.icon"
        :title="$i18n.t('Auftrags-Liste')"
    >
        <va-list
            :filters="filters"
            disable-export
        >
            <va-data-table :fields="fields">
                <template v-slot:[`field.vehicles`]="{ value }">
                    <v-chip-group column>
                        <va-reference-field
                            reference="vehicles"
                            v-for="(item, i) in value"
                            :key="i"
                            chip
                            small
                            :item="item"
                            action="show"
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
                    <send-mail-button :item="item"></send-mail-button>
                </template>
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
import SendMailButton from '@/components/buttons/SendMailButton';

export default {
    components: {SendMailButton},
    props: ['resource', 'title', 'item'],
    data() {
        return {
            dialog: false,
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
                    source: 'customer',
                    type: 'reference', attributes: {
                        reference: 'customers'
                    }
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
                {
                    source: 'finished',
                    type: 'Boolean',
                },
                {
                    source: 'fixed',
                    type: 'Boolean',
                },

            ],
            fields: [
                { source:'id' , sortable: true},
                { source: 'type', type: 'chip' ,sortable: true , attributes:{
                      color: (v) => this.$eventTypeColor(v),
                    }
                },

                {
                    source: 'start',
                    type: 'date',
                    attributes: {format: 'long'},
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
                    sortable: false,
                    type: 'reference',
                    attributes: {
                        reference: 'customers',
                        chip: true,
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
                {source: 'finished', type: 'boolean', sortable: true},
                {source: 'fixed', type: 'boolean', sortable: true},
                {
                    source: 'allDay',
                    type: 'Boolean',
                },

            ],
        };
    },
    methods: {
        onClick() {
            this.dialog = false;
        },
    },
};
</script>
<style>

span.v-chip.theme--light.v-size--default.blue
{
    color: #fffffb;
    font-size: medium;
 }
span.v-chip.theme--light.v-size--default.purple
{
    color: #fffffb;
    font-size: medium;
 }
span.v-chip.theme--light.v-size--default.grey
{
    color: #fffffb;
    font-size: medium;
 }

</style>
