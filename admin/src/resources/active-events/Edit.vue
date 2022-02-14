<template>
    <va-edit-layout>
        <active-events-form
            :id="id"
            :title="title"
            :item="item"
        ></active-events-form>
        <base-material-card
            icon="mdi-comment"
            :title="$admin.getResource('tickets').pluralName"
        >
            <va-list
                resource="tickets"
                disable-query-string
                disable-export
                :items-per-page="10"
                :filter="{
                    event_id: id,
                }"
                disable-create
                :include="['event', 'user']"
            >
                <va-data-table
                    :fields="fields"
                    disable-select
                    disable-show
                    disable-clone
                    disable-delete
                    row-create
                    row-edit
                    :create-data="{
                        event_id: id,
                        user_id: user.id,
                    }"
                >
                </va-data-table>
            </va-list>
        </base-material-card>
    </va-edit-layout>
</template>

<script>
import { mapState } from 'vuex';

export default {
    props: ['id', 'title', 'item'],
    data() {
        return {
            fields: [
                {
                    source: 'status',
                    type: 'select',
                    attributes: {
                        chip: true,
                        color: (v) => this.$statusColor(v),
                    },
                },
                {
                    source: 'rating',
                    type: 'rating',
                    attributes: {
                        halfIncrements: true,
                    },
                },
                {
                    source: 'body',
                    type: 'text',
                    attributes: { truncate: 100, multiline: true },
                },
                {
                    source: 'user',
                    type: 'reference',
                    attributes: { reference: 'users' },
                },
            ],
        };
    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
};
</script>

