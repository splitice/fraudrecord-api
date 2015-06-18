<?php
/**
 * Created by PhpStorm.
 * User: splitice
 * Date: 18-06-2015
 * Time: 11:42 AM
 */

namespace Splitice\FraudRecord;

/**
 * Class FraudRecordApi
 * @package Splitice\FraudRecord
 */
class FraudRecordApi {
    /**
     * @var IFraudRecordAPIClient
     */
    private $client;

    /**
     * Create the API
     *
     * @param IFraudRecordAPIClient $client
     */
    public function __construct(IFraudRecordAPIClient $client){
        $this->client = $client;
    }

    /**
     * Perform a query in the FraudRecord Database
     *
     * @param $fields
     * @return mixed
     * @throws ApiResponseException
     */
    function query($fields){
        $result = $this->client->execute("query", $fields);
        if(!preg_match('`<([a-z]+)>([^\]]+)</([a-z]+)>`', $result, $m)){
            throw new ApiResponseException("Unable to parse response XML");
        }
        if($m[1] != "report" && $m[3] != "report"){
            throw new ApiResponseException("Invalid return type, expected report got: ".$m[1]);
        }

        $ret = array();
        list($ret['value'],$ret['count'],$ret['reliability']) = explode('-', $m[2], 3);
        return $ret;
    }

    /**
     * Hash a value according to FraudRecord specifications
     *
     * @param $value
     * @return string
     */
    function hash($value)
    {
        for($i = 0; $i < 32000; $i++)
            $value = sha1("fraudrecord-".$value);
        return $value;
    }

}