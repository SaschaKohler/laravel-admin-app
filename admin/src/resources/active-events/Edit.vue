<template>
    <va-edit-layout>
        <active-events-form
            :id="id"
            :title="title"
            :item="item"
        ></active-events-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
    data() {
        return {};
    },
};
</script>
