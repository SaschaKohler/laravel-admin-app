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
                            <va-field
                                source="event_id"
                                type="reference"
                                reference="events"
                            ></va-field>
                            <va-field
                                source="user_id"
                                type="reference"
                                reference="users"
                            ></va-field>
                            <va-field source="rating"></va-field>
                            <va-field source="body" type="string"></va-field>
                            <va-field source="status" type="select"></va-field>
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
