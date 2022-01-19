<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list
            :filters="filters"
            :include="['vehicles']"
            disable-create
            disable-export
        >
            <va-data-table :fields="fields">
                <template v-slot:[`field.vehicles`]="{ value }"
                    >
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
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
import {mapState} from "vuex";

export default {
    props: ["resource", "title", "item"],
    data() {
        return {
            filters: ["vehicles", "type"],
            fields: [
                {source: "type", sortable: true},
                {
                    source: "start",
                    type: "date",
                    attributes: {format: "short"},
                    sortable: true,
                },
                {
                    source: "event_id",
                    type: "reference",
                    attributes: {
                        reference: "events",
                    },
                },
                {
                    source: "vehicles",
                    type: "reference",
                    attributes: {reference: "vehicles"},
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
