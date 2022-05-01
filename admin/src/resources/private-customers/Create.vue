<template>
    <va-create-layout>
        <customers-form :title="title" :item="item" :customer="1"></customers-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
