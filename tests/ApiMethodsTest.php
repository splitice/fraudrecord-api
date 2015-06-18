<?php
use Splitice\FraudRecord\FraudRecordApi;

class ApiMethodsTest extends PHPUnit_Framework_TestCase {
    const API_CLIENT = '\\Splitice\\FraudRecord\\FraudRecordApi';

    function testQueryName(){
        //Setup
        $name = "7b30981dd586b87ea42ea864c03abd2ce9086520";

        //Assert
        $client = $this->getMock(self::API_CLIENT);
        $client->expects($this->once())->method('execute')->with($this->equalTo('query'),$this->equalTo(array('name'=>$name)));

        //Do
        $api = new FraudRecordApi($client);
        $api->query(array('name'=>$name));
    }

} 