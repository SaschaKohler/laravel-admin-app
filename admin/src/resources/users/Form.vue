<template>
    <va-form :id="id" :item="item" disable-redirect @saved="$emit('saved')">
        <va-text-input source="name"></va-text-input>
        <va-text-input source="email" type="email" required></va-text-input>
        <va-text-input source="phone1" required></va-text-input>
        <va-text-input source="address"></va-text-input>
        <va-boolean-input source="active"></va-boolean-input>
        <va-select-input
            source="roles"
            multiple
            :choices="choices"
        ></va-select-input>

        <va-save-button></va-save-button>
    </va-form>
</template>

<script>
export default {
    props: ['id', 'item'],
    data() {
        return {
            choices: [
                { value: 'admin', text: 'Admin' },
                { value: 'employee', text: 'Mitarbeiter' },
                { value: 'guest', text: 'Gast' },
            ],
        };
    },
};
</script>
