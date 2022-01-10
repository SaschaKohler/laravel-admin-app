<template>
  <va-form :id="id" :item="item">
    <v-row justify="center">
      <v-col sm="6">
        <base-material-card>
          <template v-slot:heading>
            <div class="display-2">
              {{ title }}
            </div>
          </template>
          <v-card-text>
            <va-text-input source="type" required></va-text-input>
            <va-text-input source="color" required></va-text-input>
            <va-date-input source="start" format="short"></va-date-input>
            <va-select-input
              source="customer_id"
              model="customer"
              reference="customers"
              required
            ></va-select-input>
            <va-select-input
              source="users"
              model="users"
              reference="users"
              required
              multiple
              clearable
            ></va-select-input>
            <va-select-input
              source="tools"
              model="tools"
              reference="tools"
              required
              multiple
              clearable
            ></va-select-input>

            <CustomComponent source="vehicles" model="vehicles" v-slot="props">
              <v-row>
                <template v-if="!create">
                  <v-col sm="5">
                    <va-select-input
                      v-bind="props"
                      source="pivot.vehicle_id"
                      reference="vehicles"
                    ></va-select-input>
                  </v-col>
                  <v-col sm="3">
                    <va-number-input
                      v-bind="props"
                      source="pivot.kmBegin"
                    ></va-number-input>
                  </v-col>
                  <v-col sm="3">
                    <va-number-input
                      v-bind="props"
                      source="pivot.kmEnd"
                    ></va-number-input>
                  </v-col>
                </template>
                <template v-else>
                  <v-col sm="12">
                    <va-select-input
                      v-bind="props"
                      source="pivot.vehicle_id"
                      reference="vehicles"
                    ></va-select-input>
                  </v-col>
                </template>
              </v-row>
            </CustomComponent>
          </v-card-text>
          <va-save-button></va-save-button>
        </base-material-card>
      </v-col>
    </v-row>
  </va-form>
</template>

<script>
export default {
  props: ['id', 'title', 'item', 'create'],
  methods: {
    onChange(value) {
      console.log(value)
    },
  },
}
</script>
