<?php


namespace App\Services;


use Aws\S3\S3Client;

class S3Service
{
    public function __construct()
    {
        $this->s3 = new S3Client([
            'credentials' => [
                'key'      => env('AWS_ACCESS_KEY_ID'),
                'secret'   => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'region'   => env('AWS_DEFAULT_REGION'),
            'endpoint' => env('AWS_ENDPOINT'),
            'version'  => 'latest',
        ]);
    }
    public function uploadImage($key, $filepath)
    {
        try {
            $result = $this->s3->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $key,
                'Body'   => fopen($filepath, 'r'),
            ]);
            return $result;
        } catch (\Aws\S3\Exception\S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }
    }
}
