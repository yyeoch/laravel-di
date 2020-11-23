<?php
return [
    "fixer"=>[
        'api_key'=>env("FIXER_API_KEY", "972610eeebf89e49b96e420a208a70f5"),
        'base_url'=>env("FIXER_BASE_URL", 'http://data.fixer.io/api/'),
    ],
];
