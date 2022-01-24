<template>
    <va-create-layout>
        <tools-form :title="title" :item="item"></tools-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
}
</script>
