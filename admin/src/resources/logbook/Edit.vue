<template>
  <va-edit-layout>
    <logbook-form :id="id" :title="title" :item="item"></logbook-form>
  </va-edit-layout>
</template>

<script>
export default {
  props: ['id', 'title', 'item'],
}
</script>
