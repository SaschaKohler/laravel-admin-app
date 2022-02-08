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

                        <va-select-input source="prefix" required></va-select-input>
                        <va-text-input source="title"></va-text-input>
                        <va-text-input
                            source="first"
                            required></va-text-input>
                        <va-text-input source="last" required></va-text-input>
                        <va-text-input source="email" required></va-text-input>
                        <va-text-input source="street" required></va-text-input>
                        <va-text-input source="city" required></va-text-input>
                        <va-text-input source="phone" required></va-text-input>
                    </v-card-text>
                    <va-save-button></va-save-button>
                </base-material-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
};
</script>
