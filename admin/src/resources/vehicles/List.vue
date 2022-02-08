<template>
    <v-row>
        <v-col cols="12" lg="12">
            <base-material-card :icon="resource.icon" :title="title">
                <va-list :filters="filters" :include="['events']">
                    <va-data-table :fields="fields">
                        <template v-slot:[`field.events`]="{ value }">
                            <v-chip-group column>
                                <va-reference-field
                                    reference="events"
                                    v-for="(item, i) in value"
                                    :key="i"
                                    :color="item.color"
                                    small
                                    chip
                                    :item="item"
                                >
                                    {{ item.type }}
                                </va-reference-field>
                            </v-chip-group>
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
            filters: ['type', 'branding', 'events'],
            fields: [
                'owner',
                { source: 'type', sortable: true },
                'branding',
                { source: 'kmAll', sortable: true },
                {
                    source: 'permit',
                    type: 'date',
                    sortable: true,
                },
                {
                    source: 'events',
                },
                'insurance_type',
                'license_plate',
                {
                    source: 'inspection',
                    type: 'date',
                    attributes: {
                        format: 'short',
                    },
                    sortable: true,
                },
                'insurance_company',
                'insurance_manager',
            ],
        };
    },
};
</script>
