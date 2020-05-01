<?php
namespace App\Util;


use MicrosoftAzure\Storage\Blob\Models\CreateBlockBlobOptions;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;

class AzureBlobClient{

    private $azure_blob_client;
    private $blob_option;

    public function __construct(){
        $this->azure_blob_client = BlobRestProxy::createBlobService('DefaultEndpointsProtocol=https;AccountName=travelsl;AccountKey=xF0VCFJk6X3Nc+vUAz1sfraRzhj5gcg36BSurzHDOuu18YR/iEYnId/qxwyIpTksr0znuAV/F8Y4ExeGYBQtKw==;EndpointSuffix=core.windows.net');
        $this->blob_option = new CreateBlockBlobOptions();
        $this->blob_option->setContentType('image/png');
    }

    public function upload_image($image , $name){
        $this->azure_blob_client->createBlockBlob('hms',$name,\base64_decode($image),$this->blob_option);
    }

    public function delete_image($image_name){
        $this->azure_blob_client->deleteBlob('hms', $image_name);
    }
}