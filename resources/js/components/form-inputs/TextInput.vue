<template>
  <div>
    <label :for="id" v-html="label"></label>
    <input :id="id" :min="0" :type="inputType" class="form-control" :class="[(this.errorMessage) ? 'is-invalid' : '']" v-model="inputValue" :aria-describedby="helpId" :placeholder="placeholder" :maxlength="maxLengthTitle?maxLengthTitle:maxLength">
    <small v-if="helpText.length" :id="helpId" class="form-text text-muted" v-html="helpText"></small>
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
    maxLengthTitle: [String, Number], 
    id: String,
    maxLength: {
      type: Number,
      default: 30
    },
    minLength: {
      type: Number,
      default: 1
    },
    placeholder: {
      default: ""
    }, 
    helpId: {
      default: ""
    }, 
    inputType: {
      validator(value) {
        return ['text', 'email', 'tel', 'number','date'].indexOf(value) !== -1
      }
    },
    helpText: {
      default: ""
    },
    errorMessage: {
      type: String
    }
  },
  data() {
    return {
      inputValue: this.getInitialValue()
    }
  },
  methods: {
    getInitialValue() {
      let propValue = this.value; 
      if(typeof propValue === 'string') {
        // Replace any backslashes passed from the server
        propValue = propValue.replace(/\\/g, '');
      }
      return propValue;
    }
  },
  watch: {
    inputValue(value) {
      this.$emit('input', value);
    }
  }
}
</script>
