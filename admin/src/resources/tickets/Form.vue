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
                        <va-radio-group-input source="status" row></va-radio-group-input>
                        <va-rating-input source="rating"></va-rating-input>
                        <va-text-input source="body" multiline></va-text-input>

                        <va-select-input
                            source="event"
                            reference="events"
                            model="event_id"
                        ></va-select-input>
                        <va-select-input
                            source="user"
                            reference="users"
                            required
                            model="user_id"
                        ></va-select-input>
                    </v-card-text>
                    <va-save-button></va-save-button>
                </base-material-card>
            </v-col>
        </v-row>
    </va-form>
</template>

<script>
import {mapState} from "vuex";

export default {
    props: ['id', 'title', 'item'],
    data () {
        return {}

    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
};
</script>
