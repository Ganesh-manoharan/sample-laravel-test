<template>
  <div class="questionnary-fields-container">
    
    <div class="row questionnary-title">
      <div class="col-md-12">
        <text-input :id="'questionnary-title'"  :maxLengthTitle="100" :value="questionnaryFields.title" label="Title" @input="questionnaryFields.title = $event" class="form-group" v-bind:error-message="errors['questionnaryFields.title']" />
      </div>
    </div>
    <div class="row questionnary-setting">
        <div class="col-md-12">
                <h6>Setting</h6>
                
                <switch-input :id="'questionnaryFields-is-public'" :value="questionnaryFields.settings.is_public" @input="questionnaryFields.settings.is_public = $event" label="Is Public?" class="form-group"/>

                <switch-input :id="'questionnaryFields-is-show_progress_bar'" :value="questionnaryFields.settings.show_progress_bar" @input="questionnaryFields.settings.show_progress_bar = $event" label="Show Progress Bar?" class="form-group"/>

                 <drop-down v-if="questionnaryFields.settings.show_progress_bar"  :value="questionnaryFields.settings.progress_bar" :label="progress_bar.label" :options="progress_bar.options" 
                    @input="questionnaryFields.settings.progress_bar = $event" />
                <switch-input :id="'questionnaryFields-is-show_time_to_complete'" :value="questionnaryFields.settings.show_time_to_complete" @input="questionnaryFields.settings.show_time_to_complete = $event" label="Show Time to Complete?" class="form-group"/>

                <text-input :id="'questionnarysetting-redirectURL'" :maxLengthTitle="200" :value="questionnaryFields.settings.redirect_after_submit_url" label="Redirect After Submit" @input="questionnaryFields.settings.redirect_after_submit_url = $event" class="form-group" />

        </div>
        
    </div>
    <div class="row questionnary-screen-setting">
        <div class="col-md-6">
            <h6>Welcome Screen Setting</h6>
            <text-input :id="'questionnary-welcome-title'" :maxLengthTitle="100" :value="questionnaryFields.welcome_screens[0].title" label="Title" @input="questionnaryFields.welcome_screens[0].title = $event" class="form-group" />

            <text-area :id="'questionnary-welcome-desc'" :maxLengthTitle="250" :value="questionnaryFields.welcome_screens[0].properties.description" label="Description" @input="questionnaryFields.welcome_screens[0].properties.description = $event" class="form-group" />
            
            <switch-input :id="'questionnaryFields-welcome-show-button'" :value="questionnaryFields.welcome_screens[0].properties.show_button" @input="questionnaryFields.welcome_screens[0].properties.show_button = $event" label="Show Start Button?" class="form-group"/>

            <text-input v-if="questionnaryFields.welcome_screens[0].properties.show_button" :id="'questionnary-welcome-show-button-text'" :maxLengthTitle="100" :value="questionnaryFields.welcome_screens[0].properties.button_text" label="Start Button Text" @input="questionnaryFields.welcome_screens[0].properties.button_text = $event" class="form-group" />

        </div>
        <div class="col-md-6">
            <h6>Thank You Screen Setting</h6>
            <text-input :id="'questionnary-thankyou_screens-title'" :maxLengthTitle="100" :value="questionnaryFields.thankyou_screens[0].title" label="Title" @input="questionnaryFields.thankyou_screens[0].title = $event" class="form-group" />

             <text-input :id="'questionnary-thankyou_screens-reditectURL'" :maxLengthTitle="150" :value="questionnaryFields.thankyou_screens[0].properties.redirect_url" label="Redirect URL" @input="questionnaryFields.thankyou_screens[0].properties.redirect_url = $event" class="form-group" />
            
            <switch-input :id="'questionnaryFields-thankyou_screens-show-button'" :value="questionnaryFields.thankyou_screens[0].properties.show_button" @input="questionnaryFields.thankyou_screens[0].properties.show_button = $event" label="Show Thank you Button?" class="form-group"/>

            <text-input v-if="questionnaryFields.thankyou_screens[0].properties.show_button" :id="'questionnary-thankyou_screens-show-button-text'" :maxLengthTitle="100" :value="questionnaryFields.thankyou_screens[0].properties.button_text" label="Thank You Button Text" @input="questionnaryFields.thankyou_screens[0].properties.button_text = $event" class="form-group" />

        </div>
    </div>
    <h6 v-if="questionnaryFields.fields.length">Form Field Setting</h6>
    <div class="questionnary-form-fields" v-for="(field, fieldIndex) in questionnaryFields.fields" :key="fieldIndex" >
    <div v-if="!field.deleted" class="custom-field-form">
    
        <button type="button" class="btn btn-close-card delete" @click="removeField(fieldIndex,field.id)"><i class="far fa-times-circle"></i></button>
        <div class="row" >
        <div class="col-md-6">
          <h4>{{field.title}} field settings</h4>
          <text-input :id="'form-field-title' + fieldIndex + ''" :value="field.title" label="Field Title" @input="field.title = $event" class="form-group" />

          <switch-input v-if="field.validations" :id="'form-field-requried'+ fieldIndex " :value="field.validations.required" @input="field.validations.required = $event" label="Field Is Requried?" class="form-group"/>

           <text-area :id="'form-field-desc'" :maxLengthTitle="250" :value="field.properties.description" label="Description" @input="field.properties.description = $event" class="form-group" />
        </div>
        <div class="col-md-6">
           <drop-down v-if="field.ref=='nice_readable_date_reference'"  :value="field.properties.structure" :label="date_format.label" :options="date_format.options" @input="field.properties.structure = $event" />

           <drop-down v-if="field.ref=='nice_readable_date_reference'"  :value="field.properties.separator" :label="date_seperator.label" :options="date_seperator.options" @input="field.properties.separator = $event" />

           <div class="custom-field-options" v-if="field.properties.choices">
            <h4>Option values</h4>
            <div class="forn-group" v-for="(option, optionIndex) in field.properties.choices" :key="optionIndex">
			<!--BugID:1675 Desc: added aria-label in input tag -->
              <label :for="'custom-field-options-' + fieldIndex + '-' + optionIndex + ''">Enter option {{ optionIndex + 1 }}</label>
              <div class="input-group mb-3">
              <!-- Updated the custom option title error message key -->
			   <!--BugID:1509 Desc: set the max length property for custom option field -->
                
                <input type="text" :id="'custom-field-options-' + fieldIndex + '-' + optionIndex + ''" :aria-label="'custom-field-options-' + fieldIndex + '-' + optionIndex + ''" class="form-control" :maxlength="50" v-model="option.label" />
                  <!-- Added the condition to show the delete option only the index is not equal to 0  -->
                <div class="input-group-append" v-if="optionIndex!=0">
                  <button class="btn btn-outline-secondary" type="button" v-on:click="removeOptionValue(fieldIndex, optionIndex)"><i class="far fa-trash-alt"></i></button>
                </div>
              </div>
            </div>
            <div class="add-component">
              <button type="button" class="btn btn-outline-secondary" @click="addOptionValue(fieldIndex)" v-show="field.properties.choices.length < 10">Add an option</button>
            </div>
          </div>
        </div>
        </div>
    </div>
    </div>
    <div v-if="showAddFields" class="form-group">
        <select name="LeaveType" @change="onFieldTypeChange($event)" v-model="selectedFieldType" class="form-control">
            <option v-for="item in form_field_type.options" :value="item.value">{{item.title}}</option>
        </select>
    </div>  

    <div class="add-component">
      <button  class="btn btn-outline-primary" type="button" @click="addField" v-show="customfieldLength < 30">Add a Form field</button>
    </div>

    
    

    <div class="form-control formAction">
      <button class="btn btn-outline-primary storeQuestionarie" type="button" @click="storeFormFields" >Save Form</button>
      <button class="closeQuestionary btn btn-outline-danger" v-if="this.formstatus" type="button" id="close-modal" data-dismiss="modal" style="display: none">Close</button>
    </div>
    <div v-if="alert.isVisible" class="fixed-alert-wrapper alert-transition" :class="alert.style">
      <div class="alert" role="alert" v-html="alert.text"></div>
    </div>
  </div>
</template>
<script>
const apiBaseUrl = document.getElementsByClassName('baseUrl')[0].value;
module.exports = {
  created() {
    this.getFormWorkspace();
    this.getFormdefault();
  },
  props: {
    taskId:[String, Number],
    questionnaryFields: { 
      type: Object,
     default() {
            return {
                "title": "Form Title",
                "type": "form",
                "settings": {
                    "language": "en",
                    "is_public": false,
                    "progress_bar": "percentage",
                    "show_progress_bar": true,
                    "show_typeform_branding": false,
                    "show_time_to_complete": true,
                    "hide_navigation": false,
                    "redirect_after_submit_url": "https://www.redirecttohere.com"
                },
                "welcome_screens": [
                    {
                    "ref": "nice-readable-welcome-ref",
                    "title": "Welcome Title",
                    "properties": {
                        "description": "Cool description for the welcome",
                        "show_button": true,
                        "button_text": "start"
                    },
                    }
                ],
                "thankyou_screens": [
                    {
                    "ref": "nice-readable-thank-you-ref",
                    "title": "Thank you Title",
                    "properties": {
                        "show_button": true,
                        "button_text": "Finish!",
                        "button_mode": "redirect",
                        "redirect_url": "https://www.typeform.com",
                        "share_icons": false
                    }
                    }
                ],
                "fields": [
                    
                ]
            }
        }
    },
    progress_bar:{
         type: Object,
     default() {
         return {
        "label": "Select Progress Bar Type",
        "options": []
        }
     }
    },
    form_field_type:{
         type: Object,
     default() {
         return {
        "options": []
        }
     }
    },
    date_seperator:{
         type: Object,
     default() {
         return {
                "label": "Select Date Seperator",
                "options": []
        }
     }
    },
    date_format:{
         type: Object,
     default() {
         return {
                "label": "Select Date Format",
                "options": []
        }
     }
    },
    workspace:{
         type: Object,
     default() {
         return {
                "label": "Select Date Format",
                "name" : "New workspace",
                "existing":true,
                "workspace_id":'',
                "workspaceCollection":[]
        }
     }
    }
  },
  data() {
    return {
	  customfieldLength: 0,
    showAddFields:false,
    selectedFieldType:null,
    questionnaryFormData: this.questionnaryFields,
    workspaceOptionValue:'',
    formstatus:false,
    alert: {
        isVisible: false,
        text: null,
        style: "alert-success"
    },
    errors:[]
	}
  },
  methods: {
    getFormdefault(){
      axios.get(apiBaseUrl + '/manager/task/questionary/fielddetails').then(function (response) {  
          console.log(response);
          this.form_field_type.options=response.data.fieldCollection.field_options;
          this.date_format.options=response.data.fieldCollection.date_format;
          this.date_seperator.options=response.data.fieldCollection.date_seperator;
          this.progress_bar.options=response.data.fieldCollection.progress_bar;
      }.bind(this)); 
    },
    getFormWorkspace(){
      axios.get(apiBaseUrl + '/manager/task/questionary/form/workspace').then(function (response) {  
          this.workspace.workspaceCollection.push(response.data);
      }.bind(this)); 
    },
    addField() {
           this.showAddFields=true;
    },
    storeFormFields() {
        var workspaceValue=''; 
        if(this.workspace.existing)
        {
          workspaceValue=this.workspaceOptionValue
        }
        else
        {
          workspaceValue=this.workspace.name;
        }
         axios.post(apiBaseUrl + '/manager/task/questionary/formdetails',{formdata: this.questionnaryFormData,existingworkspace:this.workspace.existing, workspace: workspaceValue,taskId:this.taskId}).then(function (response) {  
         console.log(response);
         this.handleApiResponse(response.data);
      }.bind(this));          
    },
    addOptionValue(fieldIndex) {
      this.questionnaryFormData.fields[fieldIndex].properties.choices.push({ label: "" });
    },
    removeOptionValue(fieldIndex, optionIndex) {
      this.questionnaryFormData.fields[fieldIndex].properties.choices.splice(optionIndex, 1);
    },
    onFieldTypeChange:function(event){
        this.showAddFields=false;
        axios.get(apiBaseUrl + '/manager/task/questionary/form_fields/'+event.target.value).then((response)=> { 
            this.questionnaryFormData.fields.push(response.data);
            this.selectedFieldType=null;
        });
    },
    handleApiResponse(response) {
      if(typeof response !== 'undefined') {
        if(response.issue === 'SESSION_TIMEOUT') {
          this.renderAlert('warning', response.message + ' Please <a href="/login">login again</a>.', true);
        } else if(response.status) {
          this.renderAlert('success', response.message,true);
        } else if(!response.status) {
          this.renderAlert('danger', response.message);
        } else {
            // Add the missing "else" clause for sonarcloud code smells
            this.renderAlert('danger', "There was a problem reaching the server. Please refresh the page and try again.");
        }
      } else {
        this.renderAlert('danger', "There was a problem reaching the server. Please refresh the page and try again.");
      }
    },
    renderAlert(style, text, disableTransition) {
      // Adds a css class that triggers a fade in animation to display an alert and fades away after 3 seconds
      this.alert.isVisible = true;
      this.alert.text = text;
      this.alert.style = "alert-" + style;
      if(!disableTransition) {
        this.formstatus=false;
        setTimeout(function () { 
          this.alert.isVisible = false
        }.bind(this), 3000);
      }
      this.formstatus=true;
    },
    removeField(index,id)
    {
      this.questionnaryFields.fields.splice(index, 1);
    }
  }
}
</script>
