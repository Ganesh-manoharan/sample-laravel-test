<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDocument extends Model
{
    protected $fillable = [
        'document_id', 'document_specific_page','text','text_quads','task_id','document_added_as','selected_type','thumbnail'
    ];

    public static function save_task_docuemnts($data, $id)
    {
        foreach($data as $item){
            if($item['selection_type'] == 'All'){
                TaskDocument::create([
                    'document_id' => $item['document_id'],
                    'document_added_as' => $item['selection_type'],
                    'thumbnail' => $item['thumbnail'],
                    'task_id' => $id,
                    'document_specific_page' => 1
                ]);
            }else{
                foreach($item['selected'] as $i){
                    $d = TaskDocument::create([
                        'document_id' => $item['document_id'],
                        'document_added_as' => $item['selection_type'],
                        'thumbnail' => $item['thumbnail'],
                        'task_id' => $id,
                        'document_specific_page' => $i['page'],
                        'selected_type' => $i['type']
                    ]);
                    if($i['type'] == 'text'){
                        $d->update([
                            'text' => $i['text'],
                            'text_quads' => $i['quads']
                        ]);
                    }
                }
            }
        }
    }

    public function document()
    {
        return $this->belongsTo('App\Documents');
    }
}
