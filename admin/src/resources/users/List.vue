<template>
    <div>
        <va-aside-layout :title="asideTitle">
            <users-form :id="id" :item="item" @saved="onSaved"></users-form>
        </va-aside-layout>
        <base-material-card :icon="resource.icon" :title="title">
            <va-list
                ref="list"
                disable-create-redirect
                :include="['events']"
                @action="onAction"
            >
                <va-data-table
                    :fields="fields"
                    disable-create-redirect
                    disable-edit-redirect
                    @item-action="onAction"
                >
                    <template v-slot:[`item.actions`]="{ resource, item }">
                        <impersonate-button
                            :resource="resource"
                            :item="item"
                            icon
                        ></impersonate-button>
                    </template>
                </va-data-table>
            </va-list>
        </base-material-card>
    </div>
</template>

<script>
import ImpersonateButton from '@/components/buttons/ImpersonateButton';

export default {
    components: {
        ImpersonateButton,
    },
    props: ['resource', 'title', 'permissions'],
    data() {
        return {
            fields: [
                { source: 'name', sortable: true },
                { source: 'email', type: 'email' },
                { source: 'address', type: 'text' },
                { source: 'phone1', type: 'text' },
                { source: 'roles', type: 'array', sortable: false, },
                { source: 'active', type: 'boolean' },
            ],
            asideTitle: null,
            id: null,
            item: null,
            show: false,
        };
    },
    methods: {
        async onAction({ title, id, item }) {
            this.asideTitle = title;
            this.id = id;
            this.item = item;
        },
        onSaved() {
            this.asideTitle = null;
            this.$refs.list.fetchData();
        },
    },
};
</script>
