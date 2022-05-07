<template>
    <va-form :id="id" :item="item" :create="create">
        <v-row justify="center">
            <v-col sm="10">
                <base-material-tabs-card
                    :tabs="[
                        {
                            id: 'attributes',
                            label: $i18n.t('tabs.attributes'),
                            icon: 'mdi-ticket',
                        },
                        {
                            id: 'users',
                            label: $i18n.t('tabs.users'),
                            icon: 'mdi-account',
                        },
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
                            id: 'images',
                            label: $i18n.t('tabs.images'),
                            icon: 'mdi-image-multiple',
                        },
                    ]"
                >
                    <template v-slot:attributes>
                        <v-card-text>
                            <va-select-input
                                source="type"
                                required
                                v-model="typeSelected"
                            ></va-select-input>
                            <va-text-input
                                v-if="typeSelected === 'Sonstiges'"
                                source="special"
                            ></va-text-input>
                            <va-date-input
                                source="start"
                                v-model="picker"
                            ></va-date-input>

                            <va-boolean-input
                                source="allDay"
                                v-model="isTimed"
                            ></va-boolean-input>
                            <v-row v-if="!isTimed">
                                <v-col>
                                    <h3>Start</h3>
                                    <CustomTimePicker
                                        v-bind="$props"
                                        headercolor="green darken-1"
                                        v-model="form.startTime"
                                        model="startTime"
                                        @change="update"
                                    ></CustomTimePicker>
                                </v-col>
                                <v-col>
                                    <h3>Ende</h3>
                                    <CustomTimePicker
                                        v-bind="$props"
                                        v-model="form.endTime"
                                        headercolor="green darken-1"
                                        model="endTime"
                                        @change="update"
                                    >
                                    </CustomTimePicker>
                                </v-col>
                            </v-row>
                            <va-select-input
                                source="recurrence"
                                :choices="recurrence_choices"
                                required
                            ></va-select-input>

                            <va-autocomplete-input
                                source="customer_id"
                                reference="customers"
                                :label="$t('va.customer')"
                                min-chars="2"
                                required
                                >
                            </va-autocomplete-input>

                            <va-boolean-input
                                source="is_job_order"
                                v-model="isJobOrder">
                            </va-boolean-input>
                            <v-card v-if="isJobOrder">
                                <v-card-title>Lohnauftrag</v-card-title>
                                <v-card-text>
                                    <va-select-input
                                        source="order_by_id"
                                        reference="customers"
                                        :label="$t('va.job_for_customer')"
                                        :filter=" {can_job_order : true }"

                                        required
                                    >
                                    </va-select-input>

                                    <va-text-input source="location"
                                                   hint="Musterstrasse 12 / 1234 Musterhausen"></va-text-input>
                                </v-card-text>
                            </v-card>

                        </v-card-text>
                    </template>
                    <template v-slot:users>
                        <v-card-text>
                            <va-select-input
                                :label="$t('va.users')"
                                source="users"
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
                                :label="$i18n.t('input.select.vehicles')"
                                source="vehicles"
                                reference="vehicles"
                                multiple
                                clearable
                                required
                            ></va-select-input>
                        </v-card-text>
                    </template>
                    <template v-slot:tools>
                        <v-card-text>
                            <va-select-input
                                :label="$i18n.t('input.select.tools')"
                                source="tools"
                                reference="tools"
                                required
                                multiple
                                clearable
                            ></va-select-input>
                        </v-card-text>

                        <v-divider></v-divider>
                        <v-card>
                            <v-card-title>Material / Hilfsmittel</v-card-title>
                            <v-card-text>
                                <va-rich-text-input
                                    source="material"
                                ></va-rich-text-input>
                            </v-card-text>
                        </v-card>
                    </template>
                    <template v-slot:images>
                        <v-card-text>
                            <va-file-input
                                :label="$i18n.t('input.select.images')"
                                source="images"
                                multiple
                                preview
                                lg="3"
                                src="thumbnails.large"
                                color="success"
                            ></va-file-input>
                        </v-card-text>
                    </template>
                    <template v-slot:footer>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <va-save-button></va-save-button>
                        </v-card-actions>
                    </template>
                </base-material-tabs-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
import Input from 'vuetify-admin/src/mixins/input';

export default {
    mixins: [Input],
    props: ['id', 'title', 'item', 'create'],
    data() {
        return {
            value: null,
            tools: [],
            vehicles: [],
            isTimed: false,
            typeSelected: null,
            isJobOrder: false,
            form: {
                startTime: '07:00:00',
                endTime: '08:00:00',
            },

            picker: new Date(
                Date.now() - new Date().getTimezoneOffset() * 60000
            )
                .toISOString()
                .substring(0, 10),
            recurrence_choices: [
                {value: 10, text: 'keine'},
                {value: 1, text: 'täglich'},
                {value: 2, text: 'wöchentlich'},
                {value: 3, text: '14 tägig'},
                {value: 4, text: 'monatlich'},
                {value: 5, text: 'alle 3 Monate'},
                {value: 6, text: 'halbjährlich'},
            ],
        };
    },
    methods: {
        updateTimed() {
        },
        show(val) {
            console.log(val);
        },
        getDefaults() {
            if (this.item.timed) {
                this.timed = this.item.timed;
            } else {
                this.timed = false;
            }
            if (this.item.startTime) {
                this.form.startTime = this.item.startTime; //.substring(0,5);
            } else {
                this.form.startTime = '0:19';
            }
            if (this.item.endTime) {
                this.form.endTime = this.item.endTime; //.substring(0,5);
            } else {
                this.form.endTime = '0:39';
            }
        },
    },
    watch: {},
    created() {
        this.getDefaults();
    },
};
</script>
