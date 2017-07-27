<?php

$conf = new RdKafka\Conf();

// Set a rebalance callback to log partition assignments (optional)
$conf->setRebalanceCb(function (RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
    switch ($err) {
        case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
            echo "Assign: ";
            var_dump($partitions);
            $kafka->assign($partitions);
            break;

         case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
             echo "Revoke: ";
             var_dump($partitions);
             $kafka->assign(NULL);
             break;

         default:
            throw new \Exception($err);
    }
});

$conf->set('group.id', 'myConsumerGroup111');

// Initial list of Kafka brokers
$conf->set('metadata.broker.list', '127.0.0.1');

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.offset.reset', 'smallest');
$conf->setDefaultTopicConf($topicConf);
$consumer = new RdKafka\KafkaConsumer($conf);
$consumer->subscribe(['test']);

 
while (true) {
    $message = $consumer->consume(120);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            var_dump($message);
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
    
     
}

?>