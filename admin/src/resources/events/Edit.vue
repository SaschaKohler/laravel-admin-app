<template>
    <va-edit-layout>
        <events-form :id="id" :title="title" :item="item"></events-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
};
</script>
