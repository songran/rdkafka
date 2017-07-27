<?php
 
$rk = new \RdKafka\Producer();
$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("localhost:9092");
//$rk->addBrokers("192.168.1.127:9092");
// $rk->addBrokers("192.168.1.89:9092");
//$topic = $rk->newTopic("test");
$topic = $rk->newTopic("test");
//$topic->produce(RD_KAFKA_PARTITION_UA, 0, "hhhhhhhhxxxxx");

$arr = array(
	'id'     =>'111',
	'content'=> (string)$argv[1], 
);
$topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($arr));

echo "ok \n";
// print_r($rk);
// print_r($topic);