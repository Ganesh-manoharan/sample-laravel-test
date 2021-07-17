<?php

namespace App\Http\Controllers;

use App\AppConst;
use App\Client;
use App\ClientFtpDocument;
use App\ClientUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClientFTPController extends Controller
{
    public function ftp_documents_index(Request $request)
    {
        $c = ClientUser::where('company_user_id',$request->get('cmpUsrId'))->first();
        $data = ClientFtpDocument::where('client_id',$c->client_id)->paginate(config(AppConst::COMMON_PAGINATE)); 
        return view('client.ftp_document_index', compact('data'));
    }

    public function ftp_document_save(Request $request)
    {
        $c = ClientUser::where('company_user_id',$request->get('cmpUsrId'))->first();
        $cli = Client::where('id',$c->client_id)->first();
        try{
            $file = $request->file('document_file');
            $name = time() . $file->getClientOriginalName();
            $filePath = $cli->ftp_path.'/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file),'public');
            ClientFtpDocument::create([
                'document_name'=>$request->document_title,
                'client_id' => $c->client_id,
                'document_path' => $filePath
            ]);
            return ['hasErrors' => false];
        }
        catch(\Exception $e){
            Log::info('FTP Document Uploading Error');
            Log::info($e->getMessage());
            return ['hasErrors' => true];
        }
    }
}
