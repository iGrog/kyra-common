<?php

    namespace kyra\common;

    use yii\base\Event;

    class PayloadEvent extends Event
    {
        public $payload = null;
    }