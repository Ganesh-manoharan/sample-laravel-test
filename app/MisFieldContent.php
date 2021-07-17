<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MisFieldContent extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'task_mis_field_id', 'options', 'min_value', 'max_value', 'is_required',
    ];

    public static function mis_fields($mis, $id)
    {
        $da = [];
        $tmpI = 0;
        foreach ($mis as $item) {
            $tmf = TaskMisField::save_mis_fields($id, $item);
            if ($item['field_id'] == 2) {
                if (array_key_exists("mis_content", $item)) {
                    MisFieldContent::where('id', $item['mis_content'])->update([
                        'min_value' => $item['min_value']
                    ]);
                } else {
                    MisFieldContent::create([
                        'task_mis_field_id' => $tmf->id,
                        'min_value' => $item['min_value'],
                    ]);
                }
            }
            if ($item['field_id'] == 3) {
                $mda = [];
                $mI = 0;
                foreach ($item['options'] as $i) {
                    if (array_key_exists("mis_content", $i)) {
                        MisFieldContent::where('id', $i['mis_content'])->update([
                            'options' => $i['name'],
                            'is_required' => $i['required'] == 'on' ? 1 : 0
                        ]);
                        $mda[$mI] = $i['mis_content'];
                        $mI++;
                    } else {
                        MisFieldContent::create([
                            'task_mis_field_id' => $tmf->id,
                            'options' => $i['name'],
                            'is_required' => $i['required'] == 'on' ? 1 : 0
                        ]);
                    }
                }
                MisFieldContent::whereNotIn('id', $mda)->where('task_mis_field_id', $tmf->id)->delete();
            }
            $da[$tmpI] = $tmf->id;
            $tmpI++;
        }
        TaskMisField::whereNotIn('id', $da)->where('task_id', $id)->delete();
    }
}
