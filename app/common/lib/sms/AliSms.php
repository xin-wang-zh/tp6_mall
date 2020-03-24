<?php
/**
 *Descript:
 *User: jack wang
 *Date: 2020-03-20
 *Time: 22:38
 */
declare(strict_types=1);
namespace app\common\lib\sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

use think\facade\Log;


class AliSms implements SmsBase
{
    public static function sendCode(string $phone, int $code):bool {

        if(empty($phone) || empty($code)){
            return false;
        }

        AlibabaCloud::accessKeyClient(config("aliyun.accessKeyId"), config("aliyun.accessSecret"))
            ->regionId(config("aliyun.regionId"))
            ->asDefaultClient();

        $templateParam =[
            'code' =>$code,
        ];

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                    // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host(config("aliyun.host"))
                ->options([
                'query' => [
                'RegionId' => config("aliyun.regionId"),
                'PhoneNumbers' => $phone,
                'SignName' => config("aliyun.SignName"),
                'TemplateCode' => config("aliyun.TemplateCode"),
                'TemplateParam' => json_encode($templateParam),
            ],
            ])
            ->request();
            Log::info("aliSms-sendCode-{$phone}-result".json_encode($result->toArray()));
            //print_r($result->toArray());
            return true;
        } catch (ClientException $e) {
            Log::error("aliSms-sendCode-{$phone}-ClientException".$e->getErrorMessage());
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            Log::ERROR("aliSms-sendCode-{$phone}-ServerException".$e->getErrorMessage());
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}