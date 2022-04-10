<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                color="black lighten-1"
                v-bind="attrs"
                dark
                fab
                depressed
                v-on="on"
                text
                class="text-decoration-underline text-h4"
            >
                Mail
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="text-h4 grey lighten-2">
                Kunden-Verständigung
            </v-card-title>
            <v-card-text>
                Um den Kunden per Mail zu verständigen ? Bitte wählen.
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <va-action-button
                    :item="item"
                    @click="sendConfirmMail"
                    :label="$t('va.actions.event.enable')"
                    icon="mdi-mail"
                    color="success"
                    text
                ></va-action-button>
                <va-action-button
                    :item="item"
                    @click="sendDismissMail"
                    :label="$t('va.actions.event.disable')"
                    icon="mdi-mail"
                    color="error"
                    text
                ></va-action-button>
                <v-btn @click="dialog = false" text>Abbrechen</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'SendMailButton',
    props: {
        item: Object,
        icon: Boolean,
        confirm: Boolean,
        dialog: Boolean,
    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
    methods: {
        async sendConfirmMail() {
            try {
                const resp = await this.$admin.http.post(
                    `/api/events/${this.item.id}/sendConfirmMail`
                );
                this.dialog = false;
                this.$admin.toast.success(resp.data.message);
            } catch ({ response }) {
                this.$admin.toast.error(response.data.message);
            }
        },
        async sendDismissMail() {
            try {
                const resp = await this.$admin.http.post(
                    `/api/events/${this.item.id}/sendDismissMail`
                );
                this.dialog = false;
                this.$admin.toast.success(resp.data.message);
            } catch ({ response }) {
                this.$admin.toast.error(response.data.message);
            }
        },
    },
};
</script>
