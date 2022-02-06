<template>
    <va-show-layout>
        <va-show :item="item">
            <v-row justify="center">
                <v-col sm="6" lg="8">
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
                        </v-card-text>
                    </base-material-card>
                </v-col>
            </v-row>
        </va-show>
    </va-show-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
