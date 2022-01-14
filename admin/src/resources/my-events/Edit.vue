<template>
    <va-edit-layout>
        <my-events-form :id="id" :title="title" :item="item"></my-events-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
};
</script>
