<?php namespace App\Http\Controllers\API;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ContactComment
{
    public function saveComment(ContactFormRequest $request)
    {
        try
        {
            $status = 500;

            $response = [
                'date_time' => now()->format('Y-m-d H:i:s')
            ];

            $comment = $request->get('comment');
            $name = $request->get('name');
            $email = $request->get('email');

            \App\Models\ContactComment::create([
                'name' => $name,
                'email' => $email,
                'comment' => $comment,
            ]);

            $status = 201;
        }
        catch (\Exception $exception) {
            $response['message'] = 'Error processing request';
        }

        return new JsonResponse($response, $status);
    }


}
