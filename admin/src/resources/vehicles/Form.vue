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
                        <va-text-input source="owner" required></va-text-input>
                        <va-text-input source="type" required></va-text-input>
                        <va-text-input
                            source="branding"
                            required
                        ></va-text-input>
                        <va-date-input source="permit" required></va-date-input>
                        <va-text-input
                            source="insurance_type"
                            required
                        ></va-text-input>
                        <va-date-input
                            source="inspection"
                        ></va-date-input>
                        <va-text-input
                            source="insurance_company"
                            required
                        ></va-text-input>
                        <va-text-input
                            source="insurance_manager"
                            required
                        ></va-text-input>
                    </v-card-text>
                    <va-save-button></va-save-button>
                </base-material-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
export default {
    props: ["id", "title", "item"],
};
</script>
