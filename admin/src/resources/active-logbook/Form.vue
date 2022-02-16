<template>
    <va-form :id="id" :item="item">
        <v-row justify="center">
            <v-col sm="8">
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
                        {
                            id: 'users',
                            label: $i18n.t('tabs.users'),
                            icon: 'mdi-account',
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
                                    </v-row>
                                    <v-row justify="center">
                                        <v-col cols="12">

                                            <template
                                                v-if="
                                            props.item.type === 'Pickup' ||
                                            props.item.type === 'Pritsche' ||
                                            props.item.type === 'PKW'
                                        "
                                            >
                                                <v-row>
                                                    <v-col cols="6">
                                                        <va-number-input
                                                            v-bind="props"
                                                            source="pivot.kmBegin"
                                                            :label="$t('va.kmBegin')"
                                                        ></va-number-input>
                                                    </v-col>
                                                    <v-col>
                                                        <va-number-input
                                                            v-bind="props"
                                                            source="pivot.kmEnd"
                                                            :label="$t('va.kmEnd')"
                                                        ></va-number-input>
                                                    </v-col>
                                                </v-row>
                                            </template>
                                            <template
                                                v-if="
                                            props.item.type === 'Traktor' ||
                                            props.item.type === 'Mähdrescher'
                                        "
                                            >
                                                <v-row>
                                                    <v-col v-bind="props">
                                                        <v-slider
                                                            v-bind="props"
                                                            :label="$t('pivot.hours')"
                                                            thumb-color="primary"
                                                            min="0.5"
                                                            max="24"
                                                            step="0.5"
                                                            v-model="
                                                        props.item.pivot.hours
                                                    "
                                                        ></v-slider>
                                                    </v-col>
                                                </v-row>
                                            </template>
                                            <template
                                                v-if="props.item.type === 'Anhänger'"
                                            >
                                                <v-row>
                                                    <v-col>
                                                        <p>
                                                            Keine Einträge für dieses
                                                            Fahrzeug
                                                        </p>
                                                    </v-col>
                                                </v-row>
                                            </template>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </CustomComponent>
                        </v-card-text>
                    </template>
                    <template v-slot:tools>
                        <CustomComponent
                            source="tools"
                            model="tools"
                            reference="tools"
                            :label="$i18n.t('va.tools')"
                            v-slot="props"
                        >
                            <v-card-text>
                                <v-row>
                                    <v-col v-bind="props">
                                        <va-text-field
                                            v-bind="props"
                                            source="title"
                                        >
                                        </va-text-field>
                                    </v-col>
                                </v-row>
                                <v-row justify="center">
                                    <v-col cols="12">
                                        <v-slider
                                            v-bind="props"
                                            :label="$t('pivot.hours')"
                                            thumb-color="primary"
                                            thumb-label="always"
                                            min="0.5"
                                            max="10"
                                            step="0.5"
                                            v-model="props.item.pivot.hours"
                                        ></v-slider>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </CustomComponent>
                    </template>
                    <template v-slot:users>
                        <v-card-text>
                            <CustomComponent
                                source="users"
                                model="users"
                                reference="users"
                                :label="$i18n.t('va.users')"
                                v-slot="props"
                            >
                                <v-row>
                                    <v-col v-bind="props">
                                        <va-text-field
                                            v-bind="props"
                                            source="name"
                                        >
                                        </va-text-field>
                                    </v-col>
                                </v-row>
                                <v-row justify="center">
                                    <v-col cols="12">
                                        <v-time-picker
                                            v-bind="props"
                                            format="24h"
                                            v-model="props.item.pivot.startTime"
                                        ></v-time-picker>
                                        <v-time-picker
                                            v-bind="props"
                                            format="24h"
                                            v-model="props.item.pivot.endTime"
                                        >
                                        </v-time-picker>
                                    </v-col>
                                </v-row>
                            </CustomComponent>

                            <v-row justify="right">
                                <v-col cols="6">
                                    <va-boolean-input
                                        :label="$t('va.finished')"
                                        source="finished"
                                    ></va-boolean-input>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </template>

                    <template v-slot:footer>
                        <v-card-text>
                            <v-row justify="center">
                                <v-col>
                                    <va-save-button></va-save-button>
                                </v-col>
                            </v-row>
                        </v-card-text>
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
        return {
            dialog: false,
            startTime: null,
            formState: {
                startTime: null,
            },
        };
    },
    methods: {
        onChange() {
            console.log(this.$props.item.vehicles);
        },
        show(val) {
            console.log(val);
        },
        editItem(item) {
            this.editedId = item.id;
            this.dialog = true;
        },
    },
};
</script>
