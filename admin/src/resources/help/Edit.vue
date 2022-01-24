<template>
    <va-edit-layout>
        <help-form :id="id" :title="title" :item="item"></help-form>
    </va-edit-layout>
</template>

<script>
export default {
    props: ['id', 'title', 'item'],
}
</script>
