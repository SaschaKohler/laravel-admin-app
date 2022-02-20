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
                    ]"
                >
                    <template v-slot:attributes>
                        <v-card-text>
                            <va-select-input
                                source="type"
                                required
                            ></va-select-input>
                            <va-select-input source="color" required>
                            </va-select-input>
                            <va-date-input
                                source="start"
                                v-model="picker"
                            ></va-date-input>
                            <va-boolean-input
                                source="timed"
                                v-model="isTimed"
                            ></va-boolean-input>
                            <v-row v-if="isTimed" justify="center">
                                <v-col cols="4">
                                    <h3>Start</h3>
                                    <CustomTimePicker
                                        v-bind="$props"
                                        v-model="form.startTime"
                                        model="startTime"
                                        @change="update"
                                    ></CustomTimePicker>
                                </v-col>
                                <v-col cols="4">

                                    <h3>Ende</h3>
                                    <CustomTimePicker
                                        v-bind="$props"
                                        v-model="form.endTime"
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
                            <va-select-input
                                source="customer_id"
                                reference="customers"
                                :label="$t('va.customer')"
                                required
                            >
                            </va-select-input>
                        </v-card-text>
                    </template>
                    <template v-slot:users>
                        <v-card-text>
                            <va-select-input
                                :label="$t('va.users')"
                                source="users"
                                reference="users"
                                model="user_ids"
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
                                model="vehicle_ids"
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
                                model="tool_ids"
                                required
                                multiple
                                clearable
                            ></va-select-input>
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
            isTimed : false,
            form: {
                startTime: '07:00',
                endTime: '08:00',
            },

            picker: new Date(
                Date.now() - new Date().getTimezoneOffset() * 60000
            )
                .toISOString().substring(0, 10),
            recurrence_choices: [
                {value: 10, text: 'kein'},
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
                this.form.startTime = (this.item.startTime);//.substring(0,5);
            } else {
                this.form.startTime = '0:19';
            }
            if (this.item.endTime) {
                this.form.endTime = (this.item.endTime);//.substring(0,5);
            } else {
                this.form.endTime = '0:39';
            }
        }
    },
    watch: {

    },
        created(){
        this.getDefaults();
    }


};
</script>
