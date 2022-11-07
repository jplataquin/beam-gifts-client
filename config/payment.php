<?php

return [

    'service_fee' => 100,
    
    'payment_processor_fee' => [
        
        'cc' => function($amount) {
            return ($amount * 0.05) + 15;
        },

        'gc' => function($amount){
            return 0;
        }
    ],
];
