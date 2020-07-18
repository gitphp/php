<?php

namespace App\Services;
use App\Helpers\Tool;
use Qcloud\Cos\Client;

/**
 * 2020-7-17 19:27:38 腾讯云cos上传文件
 * Class QcloudServices
 * @package App\Services
 */
class QcloudServices
{

    protected $user;
    protected $cosClient;

    public function __construct()
    {

        $secretId = env('COSV5_SECRET_ID');
        $secretKey = env('COSV5_SECRET_KEY');
        $region = env('COSV5_REGION', 'ap-guangzhou');

        $this->cosClient = new Client(
            array(
                'region' => $region,
                'schema' => env('COSV5_SCHEME', 'https'),
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)
            ));
    }


    /**
     * 上传图片的到腾讯云 COS
     * @param $file
     * @return bool|string
     */
    public function upload_cos($file){

        if(empty($file)) return false;

        try {
            $originalName = $file->getClientOriginalName();     // 文件原名
            $ext = $file->getClientOriginalExtension();         // 扩展名
            $realPath = $file->getRealPath();                   // 临时文件的绝对路径
            $data['file_name'] = $originalName;
            $data['file_type'] = $ext;

            $bucket = env('COSV5_BUCKET');
            $filename = get_new_filename($ext);
            $ossKey = Tool::getOssDir($ext);

            $key = $ossKey . $filename;

            $result = $this->cosClient->putObject(array(
                'Bucket' => $bucket,
                'Key' => $key,
                'Body' => fopen($realPath, 'rb')));

            if($result){
                return 'https://' . $result['Location'];
            }

            //print_r($result);

        } catch (\Exception $e) {
            echo "文件上传失败： $e\n";
        }
    }




}
