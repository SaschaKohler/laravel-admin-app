<template>
    <va-show-layout>
        <va-show :item="item">
            <v-row justify="center">
                <v-col sm="6">
                    <base-material-card>
                        <template v-slot:heading>
                            <div class="display-2">
                                {{ title }}
                            </div>
                        </template>
                        <v-card-text>
                            <va-field source="owner"></va-field>
                            <va-field source="type"></va-field>
                            <va-field source="branding"></va-field>
                            <va-date-field source="permit"></va-date-field>
                            <va-field source="insurance_type"></va-field>
                            <va-date-field
                                source="inspection"
                                name="Inspektion"
                            ></va-date-field>
                            <va-field source="kmAll"></va-field>
                            <va-field source="insurance_company"></va-field>
                            <va-field source="insurance_manger"></va-field>
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
}
</script>
