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


    function testHash(){
        $tests = array(
                'johnsmith'=>'ac2c739924bf5d4d9bf5875dc70274fef0fe54cf',
                'iLoveLinux!'=>'93491c2dff7b35528c319f304b0222fc55ebcfcb',
                '+10001112233'=>'3f09086d8d4e4019eb534ce28e6b64c8ef563ec9',
            );


        $api = new FraudRecordApi(new FraudRecordApiClient('test'));

        foreach($tests as $key=>$value){
            $this->assertEquals($key, $api->hash($value));
        }
    }
} 