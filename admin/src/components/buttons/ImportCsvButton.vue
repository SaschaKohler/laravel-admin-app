<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">

            <v-btn
                v-bind="attrs"
                v-on="on"
                color="orange"
                text
            >
                <v-icon>mdi-plus</v-icon>
                Import Top-Kontor
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="text-h4 grey lighten-2">
                Top-Kontor Daten Import
            </v-card-title>
            <v-card-text>
                <v-form ref="form" @submit.prevent="validate">

                    <v-file-input type="file" v-model="file"
                    />
                    <v-btn
                        :loading="loading"
                        color="primary"
                        type="submit"
                        text
                        rounded
                    >import
                    </v-btn
                    >


                </v-form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="dialog = false" text>Abbrechen</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {mapState} from 'vuex';

export default {
    name: 'ImportCsvButton',
    props: {
        item: Object,
        icon: Boolean,
        confirm: Boolean,
        dialog: Boolean,
    },
    data() {
        return {
            text: null,
            file: null,
            loading: false,
        }
    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
    methods: {

        async validate() {

            if (this.$refs.form.validate()) {

                let formData = new FormData();
                formData.append('file', this.file);
                this.loading = true

                try {
                    const resp = await this.$admin.http.post(
                        "/api/customers/importCSV",
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    );
                    this.dialog = false;
                    this.$admin.toast.success(resp.data.message);
                } catch (response) {
                    this.$admin.toast.error(response.data.message);
                } finally {
                    this.loading = false;
                }
                this.$router.push("/private-customers");
            }

        },
    },
};
</script>
