<?php

namespace App\Http\Controllers\Task;

use App\Http\Traits\Base64ToImage;
use App\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{

  use Base64ToImage;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function search_docs(Request $request)
  {
    $client = new \GuzzleHttp\Client();
    $result = $client->get(env('APACHE_SOLR_URL') . '/select?q=description:' . $request->keywords[1] . 'OR _text_:' . $request->keywords[0] . 'OR _text_:' . $request->keywords[1] . '&rows=10&start=0');
    return $result->getBody();
  }

  public function suggest_autocomplete(Request $request)
  {
    $data = $this->suggest($request->keyword, $request->doc_type);
    $title_suggest = $data['suggest']['titleSuggester'];
    $content_suggest = $data['suggest']['contentSuggester'];
    $title_res = $title_suggest[$request->keyword]['suggestions'];
    $content_res = $content_suggest[$request->keyword]['suggestions'];
    $text = 'Text';
    $title = 'Title';
    $title_res = array_map(function($title_res) use ($title){
      $exp = explode('___split___',$title_res['payload']);
      return $title_res + ['cat' => $title, 'doc_type' => $exp[4],'company_id'=>$exp[3]];
    }, $title_res);
    $content_res = array_map(function($content_res) use ($text){
      $exp = explode('___split___',$content_res['payload']);
      return $content_res + ['cat' => $text, 'doc_type' => $exp[4],'company_id'=>$exp[3]];
    }, $content_res);
    $suggestions =  Arr::collapse([$title_res,$content_res]);
    
    $tmp = (new Collection($suggestions))->where('company_id',$request->get('cmpId'));
    if($request->doc_type){
      $tmp = $tmp->where('doc_type',$request->doc_type);
    }
    $suggestions = $tmp->values();
    return [
      'suggestions' => $suggestions,
      'numFound' => count($suggestions)
    ];
  }

  public function indexing_docs()
  {
    $uploded_date = date('Y-m-d');
    $file1 =  file_get_contents('documents/5-behavioral-biases-you-must-avoid-groww.pdf');
    $client = new \GuzzleHttp\Client();
    $result = $client->request('POST', env('APACHE_SOLR_URL') . '/update/extract?literal.id=1&literal.title=Behavioral Biases&literal.path=documents/5-behavioral-biases-you-must-avoid-groww.pdf&literal.updated_date='.$uploded_date.'&literal.doc_type_id=1&literal.payload_field=1___split___Behavioral Biases___split___'.$uploded_date.'&captureAttr=true&defaultField=_text_&fmap.div=foo_t&capture=div&commit=true', ['body' => $file1]);
    return $result->getBody();
  }

  public function suggest($keyword, $doc_type)
  {
    $client = new \GuzzleHttp\Client();
    $result = $client->get(env('APACHE_SOLR_URL') . '/suggest?&suggest=true&suggest.build=true&suggest.dictionary=titleSuggester&suggest.dictionary=contentSuggester&wt=json&suggest.q=' . $keyword);

    return json_decode($result->getBody(), true);
  }
}
