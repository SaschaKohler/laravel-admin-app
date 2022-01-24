<template>
    <va-create-layout>
        <help-form :title="title" :item="item"></help-form>
    </va-create-layout>
</template>

<script>
export default {
    props: ['title', 'item'],
}
</script>
