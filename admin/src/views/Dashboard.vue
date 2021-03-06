<template>
    <div>
        <v-sheet tile height="54" class="d-flex">
            <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
                <v-icon>mdi-chevron-left</v-icon>
            </v-btn>
            <v-select
                v-model="type"
                :items="types"
                item-text="name"
                item-value="value"
                dense
                outlined
                color="brown"
                hide-details
                class="ma-2"
                label="Typ"
            ></v-select>
            <v-select
                v-model="weekday"
                :items="weekdays"
                dense
                outlined
                hide-details
                color="brown"
                label="Wochentage"
                class="ma-2"
            ></v-select>
            <v-toolbar-title class="pt-3 pl-3" v-if="$refs.calendar">
                {{ $refs.calendar.title }}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon class="ma-2" @click="$refs.calendar.next()">
                <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
        </v-sheet>
        <v-sheet height="600">
            <v-calendar
                ref="calendar"
                v-model="value"
                color="green"
                locale="de"
                class="black--text"
                :type="type"
                :weekdays="weekday"
                :events="events"
                @click:event="showEvent"
                @click:date="viewDay"
            >
                <template v-slot:event="{ event }">
                    <span v-if="event.allDay"
                        ><span class="text-bold">ganztägig</span> -
                        {{ event.customer.name }}</span
                    >
                    <span v-else
                        ><span class="text-bold">{{ event.startTime }}</span> -
                        {{ event.customer.name }}</span
                    >
                </template>
            </v-calendar>
            <v-menu
                v-model="selectedOpen"
                :close-on-content-click="false"
                :activator="selectedElement"
                bottom
                left
                offset-y
                origin="top right"
                transition="scale-transition"
            >
                <v-card color="grey lighten-4" min-width="350px" flat>
                    <v-toolbar :color="selectedEvent.color">
                        <v-toolbar-title
                            class="white--text"
                            v-html="selectedEvent.name"
                        >
                        </v-toolbar-title>

                        <div class="flex-grow-1"></div>
                    </v-toolbar>
                    <v-card-text>
                        <v-row>
                            <v-col cols="8">
                                {{ selectedEvent.start | formatDate }}
                                <span
                                    v-if="selectedEvent.fixed === true"
                                    class="red--text"
                                >
                                    - Termin fixiert -</span
                                >
                            </v-col>
                            <v-col cols="2" class="pt-0">
                                <send-mail-button
                                    :item="selectedEvent"
                                ></send-mail-button>
                            </v-col>
                        </v-row>
                        <v-row>
                            <p v-if="selectedEvent.customer.type === 2" class="text-h5">
                                {{ selectedEvent.customer.brand }} /
                                {{ selectedEvent.customer.street }} /
                                {{ selectedEvent.customer.city }}
                            </p>
                            <p v-else class="text-h5">
                                {{ selectedEvent.customer.name }} /
                                {{ selectedEvent.customer.street }} /
                                {{ selectedEvent.customer.city }}
                            </p>

                        </v-row>
                        <div class="d-flex justify-space-around">
                            <ul class="pa-0 ma-0">
                                <span
                                    class="text-subtitle-1 text-decoration-underline"
                                    >Team:</span
                                >
                                <li
                                    v-for="employee in selectedEvent.employees"
                                    :key="employee.id"
                                    class="pa-0"
                                    style="list-style: none"
                                >
                                    {{ employee.name }}
                                </li>
                            </ul>
                            <ul class="pa-0 ma-0">
                                <span
                                    class="text-subtitle-1 text-decoration-underline"
                                    >Fahrzeuge:</span
                                >
                                <li
                                    v-for="vehicle in selectedEvent.vehicles"
                                    :key="vehicle.id"
                                    class="pa-0"
                                    style="list-style: none"
                                >
                                    {{ vehicle.branding }}
                                </li>
                            </ul>
                        </div>
                    </v-card-text>
                </v-card>
            </v-menu>
        </v-sheet>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
import SendMailButton from '@/components/buttons/SendMailButton';

export default {
    components: { SendMailButton },
    data() {
        return {
            data: [],
            events: [],
            selectedEvent: {
                id: null,
                start: null,
                end: null,
                customer: {
                    name: null,
                    PLZ: null,
                    street: null,
                    city: null,
                },
            },
            selectedElement: null,
            selectedOpen: false,
            type: 'month',
            types: [
                { name: 'Monat', value: 'month' },
                { name: 'Woche', value: 'week' },
                { name: 'Tag', value: 'day' },
                { name: '4 Tage', value: '4day' },
            ],
            mode: 'stack',
            modes: ['stack', 'column'],
            weekday: [1, 2, 3, 4, 5, 6, 0],
            weekdays: [
                { text: 'Mo - So', value: [1, 2, 3, 4, 5, 6, 0] },
                { text: 'Mo - Fr', value: [1, 2, 3, 4, 5] },
            ],
            value: '',
        };
    },
    async mounted() {
        if (this.$admin.can(['admin'])) {
            this.data = await this.getList({
                resource: 'events',
                params: {
                    pagination: {
                        page: 1,
                        perPage: 1000,
                    },
                },
            });
        } else {
            this.data = await this.getList({
                resource: 'events',
                params: {
                    pagination: {
                        page: 1,
                        perPage: 1000,
                    },
                    filter: { users_id: this.user.id },
                    include: ['customer', 'users', 'vehicles'],
                },
            });
        }
        this.getEvents();
    },
    methods: {
        ...mapActions({
            getList: 'api/getList',
            getMany: 'api/getMany',
        }),
        getEvents() {
            this.events = this.data.data.map((n) => {
                return {
                    id: n.id,
                    name: n.type,
                    fixed: n.fixed,
                    start: n.start,
                    startTime: n.startTime.substring(0, 5),
                    end: n.end,
                    endTime: n.endTime.substring(0, 5),
                    allDay: n.allDay,
                    color: n.color,
                    customer: n.customer,
                    users: n.users,
                    vehicles: n.vehicles,
                };
            });
        },
        viewDay({ date }) {
            this.focus = date;
            this.type = 'day';
        },
        showEvent({ nativeEvent, event }) {
            const open = () => {
                this.selectedEvent.id = event.id;
                this.selectedEvent.color = event.color;
                this.selectedEvent.employees = event.users;
                this.selectedEvent.vehicles = event.vehicles;

                this.selectedEvent.start = event.start;
                this.selectedEvent.startTime = event.startTime;
                this.selectedEvent.end = event.end;
                this.selectedEvent.endTime = event.endTime;
                this.selectedEvent.allDay = event.allDay;
                this.selectedEvent.fixed = event.fixed;
                this.selectedEvent.name = event.name;

                this.selectedEvent.customer.name = event.customer.name;
                this.selectedEvent.customer.street = event.customer.street;
                 this.selectedEvent.customer.brand = event.customer.brand;
                 this.selectedEvent.customer.type = event.customer.type;
                this.selectedEvent.customer.city = event.customer.city;

                this.selectedElement = nativeEvent.target;
                setTimeout(() => (this.selectedOpen = true), 10);
            };
            if (this.selectedOpen) {
                this.selectedOpen = false;
                setTimeout(open, 10);
            } else {
                open();
            }
            nativeEvent.stopPropagation();
        },
    },
    computed: {
        ...mapState({
            user: (state) => state.auth.user,
        }),
    },
};
</script>

<style>
div
    .v-calendar-weekly__day
    .v-calendar-weekly__day-label
    .v-btn
    .v-btn__content {
    color: #1a202c;
    font-size: 1.2em;
}

div .v-calendar-weekly__week .v-calendar-weekly__day .v-event {
    padding-left: 10px;
    font-size: 1.1em;
    height: 20px;
}

div .v-calendar-daily .v-calendar-daily__head .v-calendar-daily_head-weekday {
    color: #1a202c;
    font-size: 2em;
}

div
    .v-calendar-daily
    .v-calendar-daily__head
    .v-calendar-daily_head-day
    .v-event {
    color: #1a202c;
    font-size: 1.5em;
    color: white;
}

div
    .v-calendar-daily
    .v-calendar-daily__head
    .v-calendar-daily_head-day-label
    .v-btn
    .v-btn__content {
    color: #1a202c;
    font-size: 1.7em;
    font-weight: bolder;
}
</style>
