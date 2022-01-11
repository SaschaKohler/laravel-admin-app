<template>
    <va-form :id="id" :item="item" v-model="model">
        <v-row justify="center">
            <v-col sm="6">
                <base-material-tabs-card
                    :tabs="[
                        { id: 'attributes', label: $i18n.t('tabs.attributes'), icon: 'mdi-' },
                        { id: 'vehicles',  label: $i18n.t('tabs.vehicles'),  icon: 'mdi-car-estate' },
                        { id: 'tools', label: $i18n.t('tabs.tools'), icon: 'mdi-hammer-screwdriver'},
                    ]"
                >
                    <template v-slot:attributes>
                        <v-card-text>
                            <va-text-input
                                source="type"
                                required
                            ></va-text-input>
                            <va-text-input
                                source="color"
                                required
                            ></va-text-input>
                            <va-date-input
                                source="start"
                                format="short"
                            ></va-date-input>
                            <va-select-input
                                source="customer_id"
                                reference="customers"
                                required
                            ></va-select-input>
                            <va-select-input
                                source="users"
                                model="users"
                                reference="users"
                                required
                                multiple
                                clearable
                            ></va-select-input>
                        </v-card-text>
                    </template>
                    <template v-slot:vehicles>
                        <v-card-text>
                            <va-select-input
                                source="vehicles"
                                model="vehicles"
                                :label="$i18n.t('input.select.vehicles')"
                                reference="vehicles"
                                multiple
                                clearable
                            ></va-select-input>
                        </v-card-text>
                    </template>
                    <template v-slot:tools>
                        <v-card-text>
                            <va-select-input
                                source="tools"
                                model="tools"
                                reference="tools"
                                :label="$i18n.t('input.select.tools')"
                                required
                                multiple
                                clearable
                                orange
                            ></va-select-input>
                        </v-card-text>
                    </template>
                    <template v-slot:footer>
                        <v-row>
                            <v-card-text>
                                <v-spacer></v-spacer>
                                <va-save-button></va-save-button>
                            </v-card-text>
                        </v-row>
                    </template>
                </base-material-tabs-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
export default {
    props: ["id", "title", "item", "create"],
    data() {
        return {};
    },
    methods: {
        onChange() {
            console.log(this.$props.item.vehicles);
        },
        show(val) {
            console.log(val);
        }

    }
};
</script>
<template>
    <base-material-card :icon="resource.icon" :title="title">
        <va-list
            :filters="filters"
            :include="['customer', 'vehicles', 'users', 'tools']"

        >
            <template v-slot:actions>

                <va-action-button
                    color="green"
                    :label="$i18n.t('action.logbook')"
                    to="events/logbook/"

                ></va-action-button>
                <va-action-button
                    color="green"
                    :label="$i18n.t('action.timerecord')"

                ></va-action-button>

            </template>
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
                            small
                            :item="item"
                            action="show"
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
import {mapState} from "vuex";

export default {
    props: ["resource", "title", "item"],
    data() {
        return {
            filters: ["customer", "users", "vehicles", "type"],
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
                    source: "customer",
                    sortable: true,
                    type: "reference",
                    attributes: {
                        reference: "customers",
                        chip: true,
                        color: "amber lighten-2",
                    },
                },
                {
                    source: "users",
                    type: "reference",
                    sortable: true,
                    attributes: {reference: "users"},
                },
                {
                    source: "vehicles",
                    type: "reference",
                    attributes: {reference: "vehicles"},
                },
                {
                    source: "tools",
                    type: "reference",
                    attributes: {reference: "tools"},
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
