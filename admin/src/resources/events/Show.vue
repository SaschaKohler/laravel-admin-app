<template>
    <va-show-layout>
        <va-show :item="item">
            <v-row justify="center">
                <v-col sm="6" lg="10">
                    <base-material-card>
                        <template v-slot:heading>
                            <div class="display-2">
                                {{ title }} / {{ item.type }} /
                                {{ item.customer.last }}
                            </div>
                        </template>
                        <v-card-text>
                            <v-row justify="center">
                                <v-col>
                                    <va-field source="type"></va-field>
                                    <va-field v-if="type === 'Sonstiges'" source="special"></va-field>
                                </v-col>
                                <v-col>
                                    <va-field
                                        source="start"
                                        type="date"
                                    ></va-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <va-field
                                        source="customer_id"
                                        reference="customers"
                                        :label="$t('va.customer')"
                                        class="text-lg-h2"
                                    >{{ item.customer.last }} /
                                        {{ item.customer.street }} /
                                        {{ item.customer.phone }}
                                    </va-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <va-field
                                        source="vehicles"
                                        :label="$t('va.vehicles')"
                                        v-slot="{ value }"
                                    >
                                        <v-list>
                                            <v-list-item
                                                v-for="(item, i) in value"
                                                :key="i"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title
                                                        class="text-lg-h3"
                                                    >{{ item.branding }}
                                                    </v-list-item-title>
                                                    Strecke :{{
                                                        item.pivot.kmSum
                                                    }}
                                                    km Betr. :
                                                    {{ item.pivot.hours }}
                                                    h
                                                </v-list-item-content>
                                            </v-list-item>
                                        </v-list>
                                    </va-field>
                                </v-col>
                                <v-col>
                                    <va-field
                                        source="tools"
                                        :label="$t('va.tools')"
                                        v-slot="{ value }"
                                    >
                                        <v-list>
                                            <v-list-item
                                                v-for="(item, i) in value"
                                                :key="i"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title
                                                        class="text-lg-h3"
                                                    >
                                                        {{ item.title }}
                                                    </v-list-item-title>
                                                    Betr. :
                                                    {{ item.pivot.hours }} h
                                                </v-list-item-content>
                                            </v-list-item>
                                        </v-list>
                                    </va-field>


                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <va-field
                                        source="users"
                                        :label="$t('va.users')"
                                        v-slot="{ value }"
                                    >
                                        <v-list class="d-flex wrap">
                                            <v-list-item
                                                v-for="(item, i) in value"
                                                :key="i"
                                            >
                                                <v-list-item-content>
                                                    <v-list-item-title
                                                        class="text-lg-h3"
                                                    >{{ item.name }}
                                                    </v-list-item-title>
                                                    geleistet :
                                                    {{ item.pivot.hours }} h
                                                </v-list-item-content>
                                            </v-list-item>
                                        </v-list>
                                    </va-field>
                                </v-col>
                            </v-row>
                            <v-row >
                                <va-image-field
                                    source="images"
                                    type="image"
                                    src="thumbnails.small"
                                ></va-image-field>
                            </v-row>
                        </v-card-text>
                    </base-material-card>
                </v-col>
            </v-row>
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
                >
                    <va-data-table
                        :fields="fields"
                        disable-clone
                        disable-show
                        row-create
                        row-edit
                        :create-data="{
                            event_id: id,
                            user_id: user.id,
                        }"
                    ></va-data-table>
                </va-list>
            </base-material-card>
        </va-show>
    </va-show-layout>
</template>

<script>
import {mapState} from 'vuex';

export default {
    props: ['title', 'item', 'id'],
    data() {
        return {
            type: this.$props.item.type,
            fields: [
                {
                    source: 'status',
                    type: 'select',
                    attributes: {
                        chip: true,
                        color: (v) => this.$statusColor(v),
                    },
                },
                {source: 'rating', type: 'rating'},
                {
                    source: 'body',
                    type: 'text',
                    attributes: {truncate: 100, multiline: true},
                },
                {
                    source: 'user',
                    type: 'reference',
                    attributes: {reference: 'users'},
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
