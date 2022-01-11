<template>
    <va-form :id="id" :item="item">
        <v-row justify="center">
            <v-col sm="6">
                <base-material-tabs-card
                    :tabs="[
                        {
                            id: 'vehicles',
                            label: $i18n.t('tabs.vehicles'),
                            icon: 'mdi-car-estate',
                        },
                        {
                            id: 'tools',
                            label: $i18n.t('tabs.tools'),
                            icon: 'mdi-hammer-screwdriver',
                        },
                    ]"
                >
                    <template v-slot:vehicles>
                        <v-card-text>
                            <CustomComponent
                                source="vehicles"
                                model="vehicles"
                                :label="$i18n.t('menu.vehicles')"
                                v-slot="props"
                            >
                                <v-card-text>
                                    <v-row>
                                        <v-col>
                                            <va-text-field
                                                v-bind="props"
                                                source="branding"
                                            >
                                            </va-text-field>
                                        </v-col>

                                        <template
                                            v-if="
                                                props.item.type === 'Pickup' ||
                                                props.item.type ===
                                                    'Pritsche' ||
                                                props.item.type === 'PKW'
                                            "
                                        >
                                            <v-col v-bind="props">
                                                <va-number-input
                                                    v-bind="props"
                                                    source="pivot.kmBegin"
                                                ></va-number-input>
                                            </v-col>
                                            <v-col>
                                                <va-number-input
                                                    v-bind="props"
                                                    source="pivot.kmEnd"
                                                ></va-number-input>
                                            </v-col>
                                        </template>
                                        <template
                                            v-if="props.item.type === 'Traktor' || props.item.type === 'Mähdrescher'"
                                        >
                                            <v-col v-bind="props">
                                                <va-number-input
                                                    v-bind="props"
                                                    source="pivot.hours"
                                                ></va-number-input>
                                            </v-col>
                                        </template>
                                        <template
                                            v-if="
                                                props.item.type === 'Anhänger'
                                            "
                                        >
                                            <v-col>
                                                <p>
                                                    Keine Einträge für dieses
                                                    Fahrzeug
                                                </p>
                                            </v-col>
                                        </template>
                                    </v-row>
                                </v-card-text>
                            </CustomComponent>
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
    props: ['id', 'title', 'item', 'create'],
    data() {
        return {};
    },
    methods: {
        onChange() {
            console.log(this.$props.item.vehicles);
        },
        show(val) {
            console.log(val);
        },
    },
};
</script>
