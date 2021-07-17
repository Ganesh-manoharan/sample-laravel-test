<?php

namespace App\Http\Traits;

use Aws\Kms\KmsClient;
use App\DataKey;

//class to get the encrypted and decrypted values based on AWS KMS
trait EnvelopeEncryption
{

    public static function EnvelopeDecrypt($data)
    {

        $KmsClient = new KmsClient([
            'version' => env('AWS_VERSION_KMS'),
            'region' => env('AWS_KMS_REGION')
        ]);

        $dataKey = $KmsClient->decrypt([
            'CiphertextBlob' => base64_decode(utf8_decode($data)),
            'KeyId' => env('AWS_KMS_ENCRYPTIONKEY')
        ]);

        return $dataKey['Plaintext'];
    }

    public static function EncryptedData($data,$key)
    {
        if(!is_null($data)){
            $cipher = env('ENCRYPTION_ALGORITHM');
            $iv = random_bytes(16);
            $chiperText = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            return base64_encode(utf8_encode($iv.$chiperText));
        }else {
            return null;
        }
    }

    public static function DecryptedData($data, $key = NULL)
    {
        try {
            if ($key == NULL) {
                $key = self::decryptDataKey();
            }

            if (!is_null($data)) {
                $ciphertext = utf8_decode(base64_decode($data));
                $cipher = env('ENCRYPTION_ALGORITHM');
                $iv = mb_substr($ciphertext, 0, 16, '8bit');
                $ciphertext = mb_substr($ciphertext, 16, null, '8bit');
                return openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return $data;
        }
    }

    public static function decryptDataKey()
    {
        $data_key = DataKey::where('id', 1)->first();
        return self::EnvelopeDecrypt($data_key->key);
    }
     

}