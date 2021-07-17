<?php

namespace App\Http\Controllers;

use App\AppConst;
use App\Documents;
use App\Http\Requests\StoreDocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Tasks;
use App\TaskFieldValue;
use App\DocumentsHistory;


class DocumentController extends Controller
{

    public function document_index(Request $request)
    {
        $data = Documents::where('company_id', $request->get('cmpId'))->join('users', 'users.id', 'documents.created_by')->join('document_type', 'document_type.id', 'documents.document_type_id')->select('documents.*', 'document_type.name as document_type_name', 'users.name as user_name')->orderBy('updated_at',"DESC");
        
        if($request->document_filter){
            $data = $data->where('documents.document_type_id',$request->document_filter);
            $info = ['document'=>$request->document,'document_filter'=>$request->document_filter];
        }else{
            $info = ['document'=>'All Documents'];
        }
        if($request->search || $request->page){
            $data = $data->where('documents.document_name', 'LIKE', "%".$request->search ."%")->paginate(config(AppConst::COMMON_PAGINATE)); 
            $content = view('manager.document.document_list', compact('data'))->render();
            $pagination = view('includes.pagination', compact('data'))->render();
            return ['data'=>$content,'pagination'=>$pagination];
        }
        $data = $data->orderBy('documents.id','DESC')->paginate(config(AppConst::COMMON_PAGINATE));
        return view('manager.document.document_index', compact('data','info'))->with(['page' => __('documents.header.Document Database')]);
    }

    public function document_create(Request $request)
    {
        return view('manager.document.create_document');
    }

    public function document_save(StoreDocumentRequest $request)
    {
        try {
            if ($request->document_id) {
                return $this->document_update($request);
            }
            $filePath = $this->upload_s3($request);
            Documents::save_document($request->document_title, null, $request->document_type, $request->get('cmpId'), $filePath);
            return ['hasErrors' => false];
        } catch (\Exception $e) {
            Log::info('Document inserting Error');
            Log::info($e->getMessage());
            return ['hasErrors' => true];
        }
    }

    public function document_update($request)
    {
        try {
            $data = [];
            if ($request->document_rename) {
                $data = ['document_name' => $request->document_rename];
            }
            if ($request->has('document_file')) {
                $filePath = $this->upload_s3($request);
                Storage::disk('s3')->delete($request->delete_path);
                $data['document_path'] = $filePath;
                $data['created_by']=Auth()->user()->id;
                $update_documentstatus=Tasks::join('task_documents','task_documents.task_id','tasks.id')->where('task_documents.document_id',$request->document_id)->update(['tasks.document_status'=>1]);
            }
           
            $getdocumentlist=Documents::where('id', $request->document_id)->first();
           
            DocumentsHistory::create([
                'document_id'=>$getdocumentlist->id,
                'document_name'=>$getdocumentlist->document_name,
                'description'=>$getdocumentlist->description,
                'document_path'=>$getdocumentlist->document_path,
                'document_thumbnail'=>isset($getdocumentlist->document_thumbnail)?$getdocumentlist->document_thumbnail:'',
                'document_type_id'=>$getdocumentlist->document_type_id,
                'company_id'=>$getdocumentlist->company_id,
                'created_at'=>$getdocumentlist->created_at,
                'updated_at'=>$getdocumentlist->updated_at,
                'created_by' => $getdocumentlist->created_by
            ]);
            Documents::where('id', $request->document_id)->update($data);
            $d = Documents::where('id', $request->document_id)->first();
            Documents::indexing_docs($d, $request->get('cmpId'));
            return ['hasErrors' => false];
        } catch (\Exception $e) {
            Log::info('Document Updating Error');
            Log::info($e->getMessage());
            return ['hasErrors' => true];
        }
    }
    public function upload_s3($request)
    {
        $file = $request->file('document_file');
        $name = time() . $file->getClientOriginalName();
        $filePath = 'documents/' . date('m') . '/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');
        return $filePath;
    }
    public function document_tile(Request $request)
    {
        $title = $request->title;
        $name = $request->name;
        $id = $request->id;
        $width = $request->width;
        return view('includes.document_tile', compact('title', 'name', 'id', 'width'))->render();
    }
    public function doc_viewer(Request $request)
    {
        $doc_path = $request->doc_path;

        if($request->document_view){
            return view('includes.scripts.docviewer',compact('doc_path'));
        }
        
        return view('includes.scripts.webviewer', compact('doc_path'));
    }
    public function list_task_dependent(Request $request)
    {
        return TaskFieldValue::join('task_documents','task_documents.task_id','task_field_values.task_id')->where('task_documents.document_id',$request->doc_id)->select('task_field_values.text','task_field_values.task_id')->distinct()->get();
    }
    public function getdocumentby_type(Request $request)
    {
        return Documents::getDocumentList($request->doc_id);
    }
    public function deletedocuments(Request $request)
    {
     
        Documents::findOrFail($request->id)->delete();
        return redirect()->route('document_index');
    }
}
