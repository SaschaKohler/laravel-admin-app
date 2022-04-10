<template>
    <va-show-layout>
        <va-show :item="item">
            <v-row justify="center">
                <v-col sm="6">
                    <base-material-card>
                        <template v-slot:heading>
                            <div class="display-2">
                                 Angebot für
                                {{ item.customer.last }}, {{ item.customer.first }} / {{ item.type }}
                            </div>
                        </template>
                        <v-card-text>
                            <va-field source="type"></va-field>
                            <p>Weitere Details</p>
                            <va-rich-text-field
                                source="detail"
                                label="Beschreibung">
                            </va-rich-text-field>
                            <va-text-field
                                source="notes">
                            </va-text-field>
                            <va-field
                                source="customer_id"
                                reference="customers"
                                :label="$t('va.customer')"
                                class="text-lg-h2"
                            >{{ item.customer.last }} /
                                {{ item.customer.street }} /
                                {{ item.customer.phone }}
                            </va-field>
                            <va-image-field
                                    source="images"
                                    type="image"
                                    src="thumbnails.small"
                                    class="pb-4"
                                ></va-image-field>
                            <va-field
                                source="created_at"
                                type="date"
                            ></va-field>
                            <va-field
                                source="updated_at"
                                type="date"
                            ></va-field>

                        </v-card-text>
                    </base-material-card>
                </v-col>
            </v-row>
        </va-show>
    </va-show-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
