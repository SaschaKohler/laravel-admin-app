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
              <va-field source="type"></va-field>
              <va-field source="start" type="date"></va-field>
              <va-field
                source="vehicles"
                type="reference-array"
                reference="vehicles"
              ></va-field>
              <va-field
                source="event_id"
                type="reference"
                reference="events"
              ></va-field>
              <va-reference-field
                source="customer"
                model="customer"
                reference="customers"
                chip
              ></va-reference-field>
                <va-array-field
                source="users"
                model="user"
                reference="users"
                color="orange"
              ></va-array-field>
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
}
</script>
