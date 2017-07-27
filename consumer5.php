<?php

$conf = new RdKafka\Conf();
$conf->set('group.id', 'myConoupd121');
$conf->set('metadata.broker.list', '192.168.1.127');

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.offset.reset', 'smallest');
$conf->setDefaultTopicConf($topicConf);
$consumer = new RdKafka\KafkaConsumer($conf);
$consumer->subscribe(['test']);


 
while (true) {
    $msg = $consumer->consume(1000); 
    echo $msg->payload."\n";
      
}