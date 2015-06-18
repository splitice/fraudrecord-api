<?php
use Splitice\FraudRecord\FraudRecordApi;
use Splitice\FraudRecord\FraudRecordApiClient;

class ApiMethodsTest extends PHPUnit_Framework_TestCase {
    function testQueryName(){
        //Setup
        $name = "7b30981dd586b87ea42ea864c03abd2ce9086520";

        //Assert
        $client = $this->getMock(FraudRecordApiClient::class, array(), array("test"));
        $client->expects($this->once())->method('execute')->with($this->equalTo('query'),$this->equalTo(array('name'=>$name)))->will($this->returnValue("<report>a-b-c</report>"));

        //Do
        $api = new FraudRecordApi($client);
        $ret = $api->query(array('name'=>$name));
        $this->assertEquals(array('value'=>"a",'count'=>"b",'reliability'=>"c"), $ret);
    }

} 