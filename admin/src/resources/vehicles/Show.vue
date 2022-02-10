<template>
    <va-show-layout>
        <va-show :item="item">
            <v-row justify="center">
                <v-col sm="6">
                    <base-material-card>
                        <template v-slot:heading>
                            <div class="display-2">
                                {{ title }}
                            </div>
                        </template>
                        <v-card-text>
                            <va-field source="owner"></va-field>
                            <va-field source="type"></va-field>
                            <va-field source="branding"></va-field>
                            <va-date-field source="permit"></va-date-field>
                            <va-field source="insurance_type"></va-field>
                            <va-date-field
                                source="inspection"
                                name="Inspektion"
                            ></va-date-field>
                            <va-field source="kmAll"></va-field>
                            <va-field source="insurance_company"></va-field>
                            <va-field source="insurance_manager"></va-field>
                        </v-card-text>
                    </base-material-card>
                </v-col>
            </v-row>
        </va-show>
        <base-material-card icon="mdi-comment" :title="$i18n.t('carparameter')">
            <va-list
                resource="events"
                disable-query-string
                :items-per-page="10"
                disable-create
                :filter="{
                    vehicle_id: id,
                }"
                :include="['vehicles', 'users']"
            >
                <va-data-table
                    :fields="fields"
                    disable-select
                    disable-show
                    disable-clone
                    disable-delete
                >
                    <template v-slot:[`field.vehicles`]="{ value }">
                        <template v-for="vehicle in value">
                            <ul
                                v-if="
                                    vehicle['id'] === item.id &&
                                    (vehicle['type'] === 'Pritsche' ||
                                        vehicle['type'] === 'Pickup' ||
                                        vehicle['type'] === 'PKW')
                                "
                                v-bind="$props"
                                :key="vehicle.id"
                            >
                                <li class="text-caption">
                                    Antritt
                                    <span class="text-h3 pl-3">{{
                                        vehicle.pivot.kmBegin
                                    }}</span>
                                </li>
                                <li class="text-caption">
                                    Ende
                                    <span class="text-h3 pl-3">{{
                                        vehicle.pivot.kmEnd
                                    }}</span>
                                </li>
                                <li class="text-caption">
                                    Km Summe
                                    <span class="text-h3 pl-3">{{
                                        vehicle.pivot.kmSum
                                    }}</span>
                                </li>
                            </ul>
                            <ul
                                v-if="
                                    vehicle['id'] === item.id &&
                                    vehicle['type'] === 'Traktor'
                                "
                                v-bind="$props"
                                :key="vehicle.id"
                            >
                                <li class="text-caption">
                                    Laufzeit
                                    <span class="text-h3 pl-3"
                                        >{{ vehicle.pivot.hours }} h</span
                                    >
                                </li>
                            </ul>
                        </template>
                    </template>
                    <template v-slot:[`field.users`]="{ value }">
                        <v-chip-group column>
                            <va-reference-field
                                reference="users"
                                v-for="(item, i) in value"
                                :key="i"
                                color="green lighten-2"
                                chip
                                small
                                :item="item"
                                action="show"
                            >
                                {{ item.name }}
                            </va-reference-field>
                        </v-chip-group>
                    </template>
                </va-data-table>
            </va-list>
        </base-material-card>
    </va-show-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
    data() {
        return {
            vehicles: {},
            fields: [
                {
                    source: 'id',
                    type: 'reference',
                    attributes: {
                        reference: 'events',
                    },
                },

                {
                    source: 'type',
                    type: 'text',
                    attributes: {
                        reference: 'events',
                    },
                },
                {
                    source: 'start',
                    type: 'date',
                    attributes: { format: 'short' },
                },
                {
                    source: 'vehicles',
                    label: 'Laufzeit / km-Leistung',
                },
                {
                    source: 'users',
                },
            ],
        };
    },
};
</script>
