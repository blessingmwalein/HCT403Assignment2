<template>
  <v-snackbar v-model="snackBarValue" :timeout="2000">
    {{ text }}

    <template v-slot:action="{ attrs }">
      <v-btn color="pink" text v-bind="attrs"> Close </v-btn>
    </template>
  </v-snackbar>
</template>

<script>
export default {
  props: ["snackbar", "text"],
  data() {
    return {
      snackBarValue: this.snackbar,
    };
  },
  mounted() {
    this.snackBarValue = this.snackbar;
  },
};
</script>

<style>
</style>
