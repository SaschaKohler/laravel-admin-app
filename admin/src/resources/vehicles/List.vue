<template>
    <v-row>
        <v-col cols="12" lg="12">
            <base-material-card :icon="resource.icon" :title="title">
                <va-list :filters="filters" :include="['events']">
                    <va-data-table :fields="fields"> </va-data-table>
                </va-list>
            </base-material-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    props: ['resource', 'title'],
    data() {
        return {
            filters: ['type', 'branding', 'events'],
            fields: [
                'owner',
                { source: 'type', sortable: true },
                'branding',
                { source: 'kmAll', sortable: true },
                {
                    source: 'permit',
                    type: 'date',
                    attributes: {
                        format: 'x_short',
                    },
                    sortable: true,
                },
                'license_plate',
                {
                    source: 'inspection',
                    type: 'date',
                    attributes: {
                        format: 'x_short',
                    },
                    sortable: true,
                },
                'insurance_company',
                'insurance_manager',
            ],
        };
    },
};
</script>
