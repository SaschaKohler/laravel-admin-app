<template>
    <div>
        <v-dialog
            ref="menu"
            :value="dialog"
            @input="$emit('input', $event)"
            :return-value:sync="value"
            persistent
            full-width
            width="290px"
        >
            <v-card>
                <p>Dialog content is here</p>
                <p v-if="value !== null">{{ 'Edited id: ' + value }}</p>

                <v-time-picker
                    v-bind:value="value"
                    v-on:input="onInput"
                    full-width
                    @click:minute="$refs.menu.save(value)"
                >
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        class="mr-1"
                        text
                        @click="close"
                    >
                        Close
                    </v-btn>
                </v-time-picker>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: 'MaterialTimePicker',
    props: ['value', 'label', 'dialog'],
    data() {
        return {
            time: this.value,
            modal2: false,
        };
    },
    methods: {
        onInput(value) {
            this.$emit('input', value);
        },
        close() {
            this.$emit('close-dialog');
            if (this.editedId === null) {
                this.$emit('open-dialog');
            }
        },
    },
};
</script>
