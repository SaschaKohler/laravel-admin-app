<template>
    <va-input v-bind="$props" class="va-array-input" v-if="input">
        <div>
            <div v-for="(item, i) in input" :key="item.id" class="item">
                <!--
                          @slot Your repeatable group of inputs components.
                          @binding {string} resource Name of resource.
                          @binding {object} item Object item of array.
                          @binding {string} parentSource Original array source.
                          @binding {number} index Index of item inside array.
                        -->
                <slot
                    :resource="resource"
                    :item="item"
                    :parent-source="source"
                    :index="i"
                ></slot>
            </div>
        </div>
    </va-input>
</template>

<script>
import Input from 'vuetify-admin/src/mixins/input';

export default {
    mixins: [Input],

    props: {
        /**
         * Number to be edited.
         * @model
         */
        value: {
            type: Array,
            default: () => [],
        },
    },
    methods: {
        getItem(value) {
            /**
             * Generate fake id for drag tracking
             */
            return (value || []).map((v, i) => {
                return { ...v, id: i };
            });
        },
        add() {
            this.input.push({
                id: Math.max(...this.input.map((o) => o.id)) + 1,
            });
            this.update(this.input);
        },
        remove(index) {
            this.input.splice(index, 1);
            this.update(this.input);
        },
    },
};
</script>
<style>
.va-array-input > .v-input__control > .v-input__slot {
    display: block;
}

.va-array-input > .v-input__control > .v-input__slot > .v-label {
    display: inline-block;
    margin-bottom: 0.5rem;
}

.item {
    display: flex;
    flex-direction: column;
    padding-bottom: 2rem;
    border-bottom: solid 1px var(--v-primary-lighten5);
    margin-bottom: 2rem;
}
</style>
