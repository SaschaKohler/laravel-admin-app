<template>
    <va-form :id="id" :item="item" disable-redirect @saved="$emit('saved')">
        <va-text-input source="name"></va-text-input>
        <va-text-input source="email" type="email" required></va-text-input>
        <va-text-input source="phone1" required></va-text-input>
        <va-text-input source="address" ></va-text-input>
        <va-boolean-input source="active"></va-boolean-input>
        <va-password-input source="password"></va-password-input>
        <va-password-input source="password_confirmation"></va-password-input>
        <va-save-button></va-save-button>
    </va-form>
</template>

<script>
export default {
    props: ["id", "item"],
};
</script>
