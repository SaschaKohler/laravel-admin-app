<template>
    <va-edit-layout>
        <vehicles-form :id="id" :title="title" :item="item"></vehicles-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
};
</script>
