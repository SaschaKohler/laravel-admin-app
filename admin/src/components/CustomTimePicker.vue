<template>
    <va-input v-bind="$props">
        <v-time-picker
            format="24h"
            use-seconds
            :value="value"
            @change="update"
            @input="update"
        >
        </v-time-picker>

    </va-input>
</template>

<script>
import Input from "vuetify-admin/src/mixins/input";

export default {
    mixins: [Input],
    props: {
        value: {
            default: 0,
        }
    },

};
</script>
