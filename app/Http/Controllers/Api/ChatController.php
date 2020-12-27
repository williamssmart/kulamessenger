<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Traits\UploadMedia;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use UploadMedia;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chat = Chat::simplePaginate(20);
        $chat_data = $chat->items();
        $next_chat_url = $chat->nextPageUrl();

        $chat_message = ['chat' => $chat_data, 'next_chat_url' => $next_chat_url];
        return response($chat_message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'fullname' => 'required|String',
            'message_type' => 'required',
            'chat_text' => 'required',
        ]);
        $chat = new Chat();
        $chat->user_id = Auth::user()->id;
        $chat->user_fullname = $request->fullname;
        $chat->message_type = $request->message_type;
        $media = $request->file('media');
        $chat->chat_text = $request->chat_text;

        $chat->media_link = $chat->media?$this->UploadMedia($media):'';

        $chat->save();

        return response(['message' => 'saved successfully']);
    }

    public function getLastChat(){
        $last_chat = Chat::latest()->first();

        return response(['last_chat' => $last_chat]);
    }


    public function getChatBasedOnLastSeen($chat_id){
        $chat = Chat::where('id' , '>' , $chat_id)->get();

        return response(['chats' => $chat]);
    }

    public function saveBlogChat(Request $request){
        $request->validate([
            'post_link' => 'required|url'
        ]);
        if(!Auth::user()->isBanned){
            $user_id = Auth::user()->id;
            $chat = new Chat();
            $chat->user_id = $user_id;
            $chat->message_type = 'blog';
            $chat->chat_text = $request->post_link;
            $chat->user_fullname = ' ';

            $chat->save();
            return response(['message' => 'saved successfully']);
        }else{
            return response(['message' => 'Unauthorized']);
        }

    
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chat_message = Chat::find($id);
        if(Auth::user()->isAdmin){
            $chat_message->delete();
            return response(['message' => 'deleted successfully']);
        }else{
            if (Auth::user()->$id === $chat_message->user_id) {
                $chat_message->delete();
                return response(['message' => 'deleted successfully']);
            }else{
                return response(['message' => 'Unauthorized']);
            }
        }
    }
}
