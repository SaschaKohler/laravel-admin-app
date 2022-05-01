<template>
    <va-form :id="id" :item="item" :customer="customer">
        <v-row justify="center">
            <v-col sm="8">
                <base-material-card>
                    <template v-slot:heading>
                        <div class="display-2">
                            {{ title }}
                        </div>
                    </template>
                    <v-card elevation="3" class="mt-6">
                        <v-card-title>Kundentypus / Angebot</v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="8">
                                    <va-radio-group-input
                                        source="type"
                                        v-model="customerType"
                                        :choices="choices"
                                        row
                                        required
                                    ></va-radio-group-input>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <va-boolean-input
                                        source="can_job_order"
                                    ></va-boolean-input>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <va-boolean-input
                                        source="offer"
                                        v-model="hasOffer"
                                    ></va-boolean-input>
                                </v-col>
                                <v-col cols="8">
                                    <va-text-input
                                        v-if="hasOffer"
                                        source="offerType"
                                    ></va-text-input>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                    <v-card elevation="3" class="mt-6">
                        <v-card-title>Kundendaten</v-card-title>
                        <v-card-text>
                            <template v-if="customerType === 1">
                                <va-select-input
                                    source="prefix"
                                    required
                                ></va-select-input>
                                <va-text-input source="title"></va-text-input>
                                <va-text-input
                                    source="name"
                                    hint="Nachname (Vorname)"

                                ></va-text-input>
                                <v-divider></v-divider>
                                <va-text-input
                                    source="phone"
                                    required
                                ></va-text-input>
                                <va-text-input source="email"></va-text-input>
                            </template>

                            <template v-if="customerType === 2">
                                <va-text-input
                                    source="brand"
                                    hint="Firmenbezeichner bzw. Name"
                                    required
                                ></va-text-input>
                                <v-expansion-panels>
                                    <v-expansion-panel class="mb-4">
                                        <v-expansion-panel-header
                                        >Ansprechpartner
                                        </v-expansion-panel-header
                                        >
                                        <v-expansion-panel-content>
                                            <va-select-input
                                                source="prefix"
                                                required
                                            ></va-select-input>
                                            <va-text-input
                                                source="manager_title"
                                                hint="Mag. Dr. Prof. Dipl. Ing. Ing etc."
                                            ></va-text-input>
                                            <va-text-input
                                                source="manager"
                                                hint="Nachname Vorname"
                                                required
                                            ></va-text-input>
                                            <va-text-input
                                                source="phone"
                                                required
                                            ></va-text-input>
                                            <va-text-input
                                                source="email"
                                            ></va-text-input>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </template>

                            <template v-if="customerType === 3" class="mt-6">
                                <va-text-input
                                    source="county"
                                    required
                                ></va-text-input>
                                <v-expansion-panels>
                                    <v-expansion-panel class="mb-4">
                                        <v-expansion-panel-header
                                        >Ansprechpartner
                                        </v-expansion-panel-header
                                        >
                                        <v-expansion-panel-content>
                                            <va-select-input
                                                source="prefix"
                                                required
                                            ></va-select-input>
                                            <va-text-input
                                                source="title"
                                            ></va-text-input>
                                            <va-text-input
                                                source="manager"
                                                hint="Nachname Vorname"
                                                required
                                            ></va-text-input>
                                            <va-text-input
                                                source="phone"
                                                required
                                            ></va-text-input>
                                            <va-text-input
                                                source="email"
                                            ></va-text-input>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </template>

                            <va-text-input
                                source="street"
                                hint="Musterweg 12"
                                required
                            ></va-text-input>
                            <va-text-input
                                source="city"
                                hint="1234 Musterbergl"
                                required
                            ></va-text-input>
                        </v-card-text>
                        <v-card-actions>
                            <va-save-button></va-save-button>
                        </v-card-actions>
                    </v-card>
                </base-material-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
    data() {
        return {

customerType:'',
            hasOffer: false,
            choices: [

                {text: 'Privatkunde', value: 1},
                {text: 'Firma', value: 2},
                {text: 'Gemeinde', value: 3},
            ],
        };
    },
    methods: {
        // getDefaults() {
        //     switch (this.item.type) {
        //         case 1:
        //             this.customerType = 1
        //             break;
        //         case 2 :
        //             this.customerType = 2
        //             break;
        //         case 3:
        //             this.customerType = 3
        //             break;
        //         default:
        //             this.customerType = 1;
        //             break;
        //     }
        // }
    },
    mounted() {
        this.getDefaults();
    },
};
</script>
