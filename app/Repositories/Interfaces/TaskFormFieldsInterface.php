<?php
namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface TaskFormFieldsInterface
{
   public function taskType(): Collection;
    /**
     * Get all Form fields from task_form_fiels, 
     * task_type_fields and task_types,field_types tables
     * 
     * @return FormFieldDetails 
     */
    public function getTaskFormFields(string $formType);

    public function gettaskdependiencies(object $request);

    public function getTaskFormFieldsValues(int $taskID);

    public function storeQuestionnaryFormDetails(array $data);
}