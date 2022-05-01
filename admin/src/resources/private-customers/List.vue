<template>
    <base-material-card
        :icon="resource.icon"
        :title="$i18n.t('menu.private-customers')"
    >
        <va-list :filters="filters" :filter="{ type: 1 }">
            <template v-slot:[`actions`]>
            <import-csv-button></import-csv-button>
            </template>

            <va-data-table :fields="fields">
                <template v-slot:[`item.actions`]="{ resource, item }">
                    <router-link :to="{ path: '/offers/create#tab-offer-attributes' , query: { customer: item.id } }"


                    >Angebot erstellen
                    </router-link>
                </template>
            </va-data-table>
        </va-list>
    </base-material-card>
</template>

<script>
import ImportCsvButton from "@/components/buttons/ImportCsvButton";

export default {
    components: {ImportCsvButton},
    props: ['resource', 'title'],
    data() {
        return {
            filters: [
                'id',
                'city',
                'name',
                {source: 'offer', type: 'boolean'},
            ],

            fields: [
                {source: 'name', sortable: true},
                {source: 'email', sortable: true},
                {source: 'email2', sortable: true},
                {source: 'phone', sortable: false},
                {source: 'phone2', sortable: false},
                {source: 'phone3', sortable: false},
                {source: 'street', sortable: true},
                {source: 'city', sortable: true},
                {source: 'offerType', sortable: true},
                {source: 'offer', type: 'boolean', sortable: true},
            ],
        };
    },
    methods: {


    },
};
</script>
