<template>
    <va-edit-layout>
        <offers-form :id="id" :title="title" :item="item"></offers-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
};
</script>
