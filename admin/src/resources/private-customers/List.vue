<template>
    <base-material-card
        :icon="resource.icon"
        :title="$i18n.t('menu.private-customers')"
    >
        <va-list :filters="filters" :filter="{ type: 1 }">
            <va-data-table :fields="fields">
                <template v-slot:[`item.actions`]="{ resource, item }">
                <router-link :to="{ path: '/offers/create#tab-offer-attributes' , query: { customer: item.id } }"


                >Angebot erstellen</router-link>
            </template> </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: [
                'id',
                'city',
                'last',
                'first',
                { source: 'offer', type: 'boolean' },
            ],

            fields: [
                { source: 'first', sortable: true },
                { source: 'last', sortable: true },
                { source: 'email', sortable: true },
                { source: 'phone', sortable: false },
                { source: 'street', sortable: true },
                { source: 'city', sortable: true },
                { source: 'offerType', sortable: true },
                { source: 'offer', type: 'boolean', sortable: true },
            ],
        };
    },
    methods: {},
};
</script>
