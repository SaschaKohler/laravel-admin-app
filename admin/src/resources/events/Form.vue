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
