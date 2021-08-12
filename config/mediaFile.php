<?php

use App\Services\Media\ImageFileService;

return [
    "MediaTypeServices" => [
        "image" => [
            "extensions" => [
                "png", "jpg", "jpeg", "svg", "jfif"
            ],
            "handler" => ImageFileService::class
        ]
    ]
];
