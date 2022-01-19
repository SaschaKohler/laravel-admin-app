<template>
    <va-form :id="id" :item="item">
        <v-row justify="center">
            <v-col sm="6">
                <base-material-card>
                    <template v-slot:heading>
                        <div class="display-2">
                            {{ title }}
                        </div>
                    </template>
                    <v-card-text>
                        <va-select-input
                            source="type"
                            required
                        ></va-select-input>
                        <va-select-input source="color" required>
                        </va-select-input>
                        <va-date-input
                            source="start"
                            format="short"
                            v-model="picker"
                        ></va-date-input>
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
                        ></va-select-input>
                        <va-select-input
                            source="users"
                            model="users"
                            reference="users"
                            :label="$t('va.users')"
                            required
                            multiple
                            clearable
                        ></va-select-input>
                    </v-card-text>
                    <v-card-text>
                        <va-select-input
                            source="vehicles"
                            :label="$i18n.t('input.select.vehicles')"
                            reference="vehicles"
                            multiple
                            clearable
                            required
                        ></va-select-input>
                    </v-card-text>
                    <v-card-text>
                        <va-select-input
                            source="tools"
                            reference="tools"
                            :label="$i18n.t('input.select.tools')"
                            required
                            multiple
                            clearable
                        ></va-select-input>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <va-save-button></va-save-button>
                    </v-card-actions>

                </base-material-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
export default {
    props: ['id', 'title', 'item', 'date'],
    data() {
        return {
            value: null,
            tools: [],
            vehicles: [],
            picker: new Date(
                Date.now() - new Date().getTimezoneOffset() * 60000
            )
                .toISOString()
                .substr(0, 10),
            recurrence_choices: [
                {value: 0, text: 'keine'},
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
        onChange() {
            console.log(this.$props.item.vehicles);
        },
        show(val) {
            console.log(val);
        },
    },
};
</script>
