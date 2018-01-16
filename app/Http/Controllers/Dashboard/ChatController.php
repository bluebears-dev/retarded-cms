<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App;
use Validator;

class ChatController extends Controller
{
    private $rules = null;
    private $pusher = null;

    public function __construct(Guard $auth)
    {
        $this->rules = [
            'author' => 'required|exists:users,login|string',
            'content' => 'required',
        ];
        $this->pusher = $pusher = App::make('pusher');
    }

    public function index(int $offset, int $amount)
    {
        if ($amount > 0 && $amount < 100) {
            $messages = Message::fetch($offset, $amount);
            return $this->createResponse([
                'messages' => $messages
            ], Response::HTTP_OK);
        } else {
            return $this->createResponse([
                'error' => 'Bad value passed as argument.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $message = new Message;
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails())
            return $this->createResponse($validator->messages(), Response::HTTP_BAD_REQUEST);

        $message->fill($request->only('author', 'content'));
        $message->save();
        $this->pusher->trigger('chat-channel', 'message-sent-event', [
            'message' => $message
        ]);
        return $this->createResponse([], Response::HTTP_OK);
    }
}
