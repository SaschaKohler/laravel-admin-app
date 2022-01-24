<template>
    <va-create-layout>
        <vehicles-form :title="title" :item="item"></vehicles-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
}
</script>
