<?php
function prGenerateSrcImageData($fileImage) {
    if (!file_exists($fileImage)){
        return false;
    }
    
    $bytesImage = file_get_contents($fileImage);
            
    return 'data:' . mime_content_type($fileImage) . ';base64,' . base64_encode($bytesImage);
}

function prResponseJson($message, $st=0) {
    return response()->json([
        'status' => $st,
        'message' => $message
    ]);
}