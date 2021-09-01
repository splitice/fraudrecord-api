<?php
/**
 * Created by PhpStorm.
 * User: splitice
 * Date: 18-06-2015
 * Time: 11:41 AM
 */

namespace Splitice\FraudRecord;

/**
 * Class FraudRecordApiClient
 *
 * The specific API protocol implemented currently
 *
 * @package Splitice\FraudRecord
 */
class FraudRecordApiClient implements IFraudRecordAPIClient {
    private $api_key;
    private $ch;
    const ENDPOINT = "https://www.fraudrecord.com/api/";

    public function __construct($api_key){
        $this->api_key = $api_key;

        //Curl init
        $this->ch = curl_init(self::ENDPOINT);
        curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER,0);
    }
    function __destruct(){
        curl_close($this->ch);
    }

    /**
     * Do the HTTP request
     *
     * @param $fields
     * @return mixed
     * @throws ApiCurlException
     */
    private function perform_request($fields){
        curl_setopt($this->ch,CURLOPT_POST,count($fields));
        curl_setopt($this->ch,CURLOPT_POSTFIELDS,$fields);

        //execute post
        $result = curl_exec($this->ch);
        if($result === false){
            throw new ApiCurlException(curl_error($this->ch));
        }
        return $result;
    }

    /**
     * Build the query
     *
     * @param $action
     * @param $fields
     * @return mixed
     */
    private function build_fields($action, $fields){
        $fields['_api'] = $this->api_key;
        $fields['_action'] = $action;
        return $fields;
    }

    /**
     * Execute an API action
     *
     * @param $action
     * @param $fields
     * @return mixed
     * @throws ApiCurlException
     */
    function execute($action, $fields){
        return $this->perform_request($this->build_fields($action,$fields));
    }
}