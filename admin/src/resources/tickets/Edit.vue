<template>
  <va-edit-layout>
    <tickets-form :id="id" :title="title" :item="item"></tickets-form>
  </va-edit-layout>
</template>

<script>
export default {
  props: ["id", "title", "item"],
};
</script>
