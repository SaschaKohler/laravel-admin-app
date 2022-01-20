<template>
    <va-create-layout>
        <tickets-form :title="title" :item="item"></tickets-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
};
</script>
