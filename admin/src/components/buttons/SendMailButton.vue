<template>
    <va-action-button
        v-if="item && confirm"
        :item="item"
        @click="sendConfirmMail"
        hide-label
        :label="$t('va.actions.event.enable')"
        icon="mdi-mail"
        color="success"
        text
    ></va-action-button>
    <va-action-button
        v-else
        :item="item"
        @click="sendDismissMail"
        hide-label
        :label="$t('va.actions.event.disable')"
        icon="mdi-mail"
        color="error"
        text
    ></va-action-button>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: 'SendMailButton',
    props: {
        item: Object,
        icon: Boolean,
        confirm: Boolean,
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
                this.$admin.toast.success(resp.data.message);
                /**
                 * Full reload to home
                 */
            } catch ({ response }) {
                this.$admin.toast.error(response.data.message);
            }
        },
        async sendDismissMail() {
            try {
                const resp = await this.$admin.http.post(
                    `/api/events/${this.item.id}/sendDismissMail`
                );
                this.$admin.toast.success(resp.data.message);
                /**
                 * Full reload to home
                 */
            } catch ({ response }) {
                this.$admin.toast.error(response.data.message);
            }
        },
    },
};
</script>
