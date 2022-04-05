<template>
  <div>
    <i class="fa-solid fa-spinner fa-spin" v-show="loading"></i>
  </div>
</template>

<script>
export default {
  props: {
    loading: {
      type: Boolean,
      required: true,
    },
  },
};
</script>
