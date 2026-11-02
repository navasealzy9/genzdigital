<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class OpenGen5MatchException extends ConflictHttpException
{
    public function __construct(public readonly int $matchId)
    {
        parent::__construct('ថ្នាក់នេះមាន GEN5 នៅក្នុង Lobby ឬកំពុងលេងរួចហើយ។ សូមចូលហ្គេមដែលមានស្រាប់ ដើម្បីបន្តលេង ឬបញ្ចប់/បោះបង់វាមុនបង្កើតថ្មី។');
    }
}
