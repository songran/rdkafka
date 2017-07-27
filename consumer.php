<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);

$rk = new \RdKafka\Consumer();
$rk->setLogLevel(LOG_DEBUG);
//$rk->addBrokers("192.168.1.85:9092");

$rk->addBrokers("192.168.1.85:9092");


$topic = $rk->newTopic("test");
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

 
$count =0; 
$arr   = array();

while (true)
{
    
    $msg = $topic->consume(0,1000);

    if ($msg->err == RD_KAFKA_RESP_ERR_NO_ERROR && $msg->payload != null) {         
    	$arr[] = $msg->payload;   
    }
    echo $msg->payload, "\n";
    
    $count ++  ;

    if($count %10 == 0)
    {
    	echo count($arr);

    	if(count($arr) < 5 && count($arr) >=0){
    		//错误少的时候 循环发送
    		echo "一般错误\n";

    	}elseif(count($arr) > 5){
    		//消息抖动发一条消息  等三分钟后再发
    		echo "重大错误 \n";
    	}

    	$arr = array();
    }
       
    // echo "asdf\n";
     
}