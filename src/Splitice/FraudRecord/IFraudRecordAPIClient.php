<?php
/**
 * Created by PhpStorm.
 * User: splitice
 * Date: 18-06-2015
 * Time: 11:41 AM
 */

namespace Splitice\FraudRecord;


interface IFraudRecordAPIClient {
    function execute($action, $fields);
}