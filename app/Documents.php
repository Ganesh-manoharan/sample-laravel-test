<?php

namespace App;

use App\AppConst;
use App\Http\Traits\Base64ToImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\DocumentsHistory;
use App\Http\Traits\EnvelopeEncryption;
use League\CommonMark\Block\Element\Document;

class Documents extends Model
{
    use Base64ToImage,SoftDeletes,EnvelopeEncryption;
    protected $table = "documents";
    protected $fillable = [
        'document_name', 'document_path', 'document_thumbnail', 'document_type_id', 'description','company_id','created_by'
    ];

    public static function getDocumentList($id)
    {
        $client = new \GuzzleHttp\Client();
        $result = $client->get(env('APACHE_SOLR_URL') . '/select?q=id:' . $id);
        $data = json_decode($result->getBody(), true);
        $doc_type = DocumentType::where('id', $data['response']['docs'][0]['doc_type_id'])->first();
         
        $key = self::decryptDataKey();
        $doc_list=DocumentsHistory::join('users','users.id','documents_history.created_by')->where('documents_history.document_id',$id)->select('documents_history.created_at','documents_history.document_path','users.name')->get();

         $updateddoc_details=Documents::where('id',$id)->first();
         $created_by_user=User::where('id',$updateddoc_details->created_by)->first();
         $createddocumentuser=self::DecryptedData($created_by_user->name, $key);

        $listversion=[];
        foreach($doc_list as $list)
        {
            $listversion['created_at'][]=date('F j, Y, g:i a', strtotime($list->created_at));
            $listversion['nameofuser'][]=self::DecryptedData($list->name, $key);
            $listversion['docpath'][]=$list->document_path;
        }
        
        return [
            'id' => $data['response']['docs'][0]['id'],
            'doc_title' => $data['response']['docs'][0]['title'][0],
            'doc_path' => $data['response']['docs'][0]['path'][0],
            'doc_update_date'=>date('F j, Y, g:i a', strtotime($updateddoc_details->updated_at)),
            'nameofuser'=>$createddocumentuser,
            'doc_type' => $doc_type->name,
            'version_history'=>$listversion,
            'document_details'=>$doc_list
        ];
    }

    public static function indexing_docs($data, $cmpId)
    {
        $uploded_date = date('Y-m-d');
        $file =  file_get_contents(env('AWS_URL').'/' . $data->document_path);
        $client = new \GuzzleHttp\Client();
        $result = $client->request('POST', env('APACHE_SOLR_URL') . '/update/extract?literal.id=' . $data->id . '&literal.title=' . $data->document_name . '&literal.path=' . $data->document_path . '&literal.updated_date=' . $uploded_date . '&literal.doc_type_id=' . $data->document_type_id .'&literal.company_id=' .$cmpId . '&literal.payload_field=' . $data->id . AppConst::DOC_SPLIT_STRING . $data->document_name . AppConst::DOC_SPLIT_STRING . $uploded_date . AppConst::DOC_SPLIT_STRING . $cmpId.AppConst::DOC_SPLIT_STRING . $data->document_type_id . '&captureAttr=true&defaultField=_text_&fmap.div=foo_t&capture=div&commit=true', ['body' => $file]);
        return $result->getBody();
    }

    public static function save_document($title, $description, $type, $cmpId, $path)
    {
        $doc = Documents::create([
            'document_name' => $title,
            'document_path' => $path,
            'document_thumbnail' => null,
            'document_type_id' => $type,
            'description' => $description,
            'company_id' => $cmpId,
            'created_by' => auth()->user()->id
        ]);
        if ($doc) {
           return self::indexing_docs($doc, $cmpId);
        }
    }
    public static function decryptDataKey()
    {
        $data_key = DataKey::where('id', 1)->first();
        return self::EnvelopeDecrypt($data_key->key);
    }
}
