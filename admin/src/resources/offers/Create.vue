<template>
    <va-create-layout>
        <offers-form :title="title" :item="item"></offers-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
