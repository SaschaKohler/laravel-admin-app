<template>
    <v-row>
        <v-col v-for="item in data.data" :key="item.id">
            <p> {{ item['chartData'] }}</p>
        </v-col>
    </v-row>
</template>

<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            data: [],
        }
    },
    async mounted() {
        /**
         * Use the global vuex store instance.
         * You need to provide the name of the resource followed by the provider method you want to call.
         * Each provider methods needs a `params` argument which is the same object described above.
         */
        // this.data = await this.$store.dispatch("vehicles/getList", {
        //     pagination: {
        //         page: 1,
        //         perPage: 5,
        //     },
        // });

        /**
         * Use the registered global method which use global `api` store module.
         * Then you need to provide a object argument of this format : `{ resource, params }`
         */
        this.data = await this.getList({
            resource: "vehicles",
            params: {
                pagination: {
                    page: 1,
                    perPage: 1,
                },
            },
        });
    },
    methods: {
        ...mapActions({
            getList: "api/getList",
        }),
    },
};
</script>
