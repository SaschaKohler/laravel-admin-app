<template>
    <va-create-layout>
        <events-form :title="title" :item="item"></events-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
