<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientKeyContacts extends Model
{
    protected $table = 'client_keycontacts';
    protected $fillable = [
        'client_id', 'keycontact_id', 'name', 'email', 'phone_number'
    ];

    public static function contacts_save($r, $id, $type)
    {
        
            $n = 1;
            for ($z = 0; $z <= 1; $z++) {
                $clientKeyContact=ClientKeyContacts::where('client_id', $id)->where('keycontact_id', $n)->first();
                $clientKeyContactData=[
                    'name' => $r->keycontact_clientName[$z],
                    'email' => $r->keycontact_clientEmail[$z],
                    'phone_number' => $r->keycontact_clientphonenumber[$z]
                ];
                if($clientKeyContact)
                {
                    $clientKeyContact->update($clientKeyContactData);
                }
                else
                {
                    $clientKeyContactData['client_id']=$id;
                    $clientKeyContactData['keycontact_id']=$n;
                    $clientKeyContact=new ClientKeyContacts($clientKeyContactData);
                    $clientKeyContact->save();
                }
                $n++;
            }
        
        }

    public function getClient()
    {
        return $this->hasOne('App\Client','id','client_id');
    }
}
