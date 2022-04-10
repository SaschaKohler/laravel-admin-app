<template>
    <va-form :id="id" :item="item">
        <v-row justify="center">
            <v-col sm="10">
                <base-material-tabs-card
                    :tabs="[
                        {
                            id: 'offer-attributes',
                            label: $i18n.t('tabs.offer-attributes'),
                            icon: 'mdi-ticket',
                        },
                        {
                            id: 'images',
                            label: $i18n.t('tabs.images'),
                            icon: 'mdi-image-multiple',
                        },
                    ]"
                >
                    <template v-slot:offer-attributes>
                        <template  v-for="item in data" >
                            <v-card-title class="text-h3" >
                                Angebot für {{item.prefix}} {{ item.last }} {{item.first }} in {{item.street }} - {{ item.city }}
                            </v-card-title>
                             <va-text-input style="display: none;"  model="customer_id" v-model="customer_id"></va-text-input>

                        </template>

                            <va-select-input v-if="form.id === ''"
                                             source="customer_id"
                                             :label="$t('va.customer')"
                                             reference="customers"
                                             required

                            >
                            </va-select-input>

                            <va-text-input source="type" class="mt-5" required></va-text-input>
                            <va-rich-text-input
                                source="detail"
                                :required="false"
                            ></va-rich-text-input>

                    </template>
                    <template v-slot:images>
                        <v-card-text>
                            <va-file-input
                                :label="$i18n.t('input.select.images')"
                                source="images"
                                multiple
                                preview
                                src="thumbnails.medium"
                                color="success"
                            ></va-file-input>
                            <va-text-input
                                source="notes"
                                :required="false"
                            ></va-text-input>

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

export default {
    props: ['id', 'title', 'item'],
    data() {
        return {
            data: [],
            form: {
                id: '',
                first: '',
                last: '',
            },
            customer_id: '',

        }
    },
    async mounted() {
        if (this.$route.query.customer) {
            this.data = await this.$store.dispatch("customers/getOne", {id: this.$route.query.customer});
            this.form.id = this.data.data.id;
            this.customer_id = this.data.data.id;
        }
    }
}

</script>
