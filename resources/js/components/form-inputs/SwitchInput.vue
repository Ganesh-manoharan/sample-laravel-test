<template>
  <div class="custom-control custom-switch">
    <input type="checkbox" :class="[(this.errorMessage) ? 'is-invalid' : '','custom-control-input']" 
    :aria-label="id" v-bind:id="id" v-model="inputValue" :disabled="disabled">
    <label class="custom-control-label" v-bind:for="id" v-html="label"></label>
    <div class="invalid-feedback" v-if="this.errorMessage">
      {{errorMessage}}
    </div>
  </div>
</template>
<script>
module.exports = {
  props: ['label', 'value', 'id', 'errorMessage' ,'disabled', 'formData'],
  data() {
    return {
      inputValue: this.getSwitchValue(),
      isDisabled: this.disabled
    }
  },
  watch: {
    inputValue(value) {
      this.$emit('input', value);
    },
    value(triggeredValue) {
      this.inputValue = triggeredValue;
    }
  },
  methods: { 
    getSwitchValue() {
        let switchInput = this.value;
        return switchInput;
    }
  }
}
</script>
