<template>
    <va-create-layout>
        <events-form :title="title" :item="item" :create="true"></events-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
