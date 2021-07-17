<?php namespace App\Clients;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Log;

use function GuzzleHttp\json_decode;

/**
 * Client designed for integration with Questionnaire 
 *
 * Class QuestionnaireClient
 * @package App\Clients
 */
class QuestionnaireClient
{

/**
     * Instantiate Http client.
     *
     * @param string $content - content header
     * @return Client
     */
    private static function client(string $mimeType) : Client
    {
        return new Client([
            'base_uri' => self::apiBaseUri(),
            'headers'  => [
                'Authorization' => 'Bearer DNssYqHzkpjJYomAJRR9XzUSzGS5crTnrvcC2XKqWpXc',
                'Content-Type'  => $mimeType,
                'Accept' => $mimeType
            ],
        ]);
    }

    /**
     * Define 3rd party API base uri.
     *
     * @return string
     */
    private static function apiBaseUri() : string
    {
        return 'https://api.typeform.com';
    }

    public static function getFormDetails()
    {
        // Endpoint url
        $url = '/forms';

        // Instantiate and configure client
        $client = self::client('application/json');

        $formDetails=self::getRequest($client, $url);
        $questionnaryform=[];
        if($formDetails)
        {
            foreach($formDetails->items as $forms)
            {
                if($forms->type=='form')
                {
                    $questionnaryform[]=[
                        'id'=>$forms->id,
                        'title'=>$forms->title
                    ];
                }
            }
        }
        // Return response
        return $questionnaryform;
    }

    public static function getWorkspace()
    {
        // Endpoint url
        $url = '/workspaces';

        // Instantiate and configure client
        $client = self::client('application/json');

        $formDetails=self::getRequest($client, $url);
      
        $questionnaryform=[];
        if($formDetails)
        {
            foreach($formDetails->items as $workspaces)
            {
                $questionnaryform[]=[
                    'value'=>$workspaces->self->href,
                    'title'=>$workspaces->name
                ];
            }
        }
        // Return response
        return $questionnaryform;
    }

    public static function createWorkspace($body=null)
    {
        // Endpoint url
        $url = '/workspaces';
        // Instantiate and configure client
        $client = self::client('application/json');
        $formdata['name']=$body;
        return self::postRequest($client, $url,$formdata);
    }

    public static function createForm($body=null)
    {
        // Endpoint url
        $url = '/forms';
        // Instantiate and configure client
        $client = self::client('application/json');
        return self::postRequest($client, $url,$body);
    }

    public static function getRequest($client,$url,$body=null)
    {
        try {
            // Create API request
            $request = $client->request('GET', $url, [
                'json' => $body,
            ]);

            // Return decoded response
            return json_decode($request->getBody()->getContents());

        } catch (\Exception $exception) {

            // Log error with exception message
            Log::error($exception->getMessage());

            // Failed response
            return [];
        }
    }

    public static function postRequest($client,$url,$body=null)
    {
        try {

            Log::info(json_encode($body));
            $request = $client->request('POST', $url, [
                'body'    => json_encode($body),
            ]);
            // Return decoded response
            return json_decode($request->getBody(), true);

        } catch (\Exception $exception) {
            Log::info('error');
            // Log error with exception message
            Log::error($exception->getMessage());

            // Failed response
            return ['status'=>false];
        }
    }

}