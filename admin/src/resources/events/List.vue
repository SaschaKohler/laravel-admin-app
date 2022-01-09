<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list :filters="filters" :include="['customer','vehicles']">
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
                            class="white--text"
                        >
                            {{ item.branding }} / KM: {{ item.pivot.kmSum }}
                        </va-reference-field>
                    </v-chip-group>
                </template>


            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ["resource", "title"],
    data() {
        return {
            filters: ["type"],
            fields: [
                {source: "type", sortable: true},
                {
                    source: "start",
                    type: "date",
                    attributes: {format: "short"},
                    sortable: true
                },
                {
                    source: "event_id",
                    type: "reference",
                    attributes: {reference: "events"},
                },
                {
                    source: "customer",
                    sortable: true,
                    type: "reference",
                    attributes: {reference: "customers", chip: true, color: "green"},
                },
                {
                    source: "vehicles",
                    type: "reference",
                    attributes: {reference: "vehicles"},
                },

            ],
        };
    },
};
</script>
