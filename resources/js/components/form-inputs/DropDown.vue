<template>
  <div class="form-group">
   <label v-bind:for="id" v-html="label"></label>
    <select class="form-control" :class="[(this.errorMessage) ? 'is-invalid' : '']" :aria-label="id" v-model="inputValue" v-bind:id="id">
      <option v-for="(option, index) in options" :key="index" :value="option.value" :selected="getSelectedOption(option.value)">{{ option.title }}</option>
    </select>
    <div class="invalid-feedback" v-if="this.errorMessage">
      {{errorMessage}}
    </div>
  </div>
</template>
<script>
module.exports = {
  props: {
    label: String, 
    value: [String, Number],
    id: String,
    options: {
      type: Array,
      required: true
    },
    errorMessage: {
      type: String
    }
  },
  data () {
    return {
      inputValue: this.value || this.options[0].value
    }
  },
  methods: {
    getSelectedOption(optionValue) {
      if(optionValue === this.inputValue) {
        return "selected";
      }
      else {
        return "";
      }
    }
  },
  watch: {
    inputValue(value) {
      this.$emit('input', value);
    }
  }
}
</script>
