<template>
  <div></div>
</template>
<script>
export default {
  methods: {
    makeToast(variant = null, msg) {
      this.$bvToast.toast(msg, {
        // // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
  },
  watch: {
    testProp: function makeToast(variant = 'success', msg) {
      this.$bvToast.toast(msg, {
        // // title: ` ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },
  },
};
</script>