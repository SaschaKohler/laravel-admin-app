<template>
  <va-edit-layout>
    <active-logbook-form :id="id" :title="title" :item="item"></active-logbook-form>
  </va-edit-layout>
</template>

<script>
export default {
  props: ['id', 'title', 'item'],
}
</script>
