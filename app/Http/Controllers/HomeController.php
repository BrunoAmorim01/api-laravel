<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::where('id', auth()->id())->select([
            'id',
            'name',
            'email',
        ])->first();

        return view('home', [
            'user' => $user,
        ]);
    }

    public function messages(): JsonResponse
    {
        $messages = Message::with('user')->get()->append('time');

        return response()->json($messages);
    }

    public function message(Request $request): JsonResponse
    {
        $messageCreated = Message::create([
            'user_id' => auth()->id(),
            'text' => $request->get('text'),
        ]);

        $messageTosend = [
            'id' => $messageCreated->id,
            'user_id' => $messageCreated->user_id,
            'text' => $messageCreated->text,
            'time' => $messageCreated->time,
        ];

        SendMessage::dispatch(json_encode($messageTosend))->onConnection('sqs')->onQueue('chat');

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
