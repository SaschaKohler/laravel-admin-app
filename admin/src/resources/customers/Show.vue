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
                            <va-field source="first"></va-field>
                            <va-field source="last"></va-field>
                            <va-field source="title"></va-field>
                            <va-field source="email"></va-field>
                            <va-field source="street"></va-field>
                            <va-field source="city"></va-field>
                            <va-field source="phone"></va-field>
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
