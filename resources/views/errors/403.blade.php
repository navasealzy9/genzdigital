@include('errors.learning', ['status' => 403, 'heading' => 'សិទ្ធិចូលប្រើត្រូវបានកំណត់', 'message' => $exception->getMessage() ?: 'You do not have permission to access this content.'])
