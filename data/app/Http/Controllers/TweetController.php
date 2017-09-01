<?php

namespace App\Http\Controllers;

use App\Tweets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Transform message by adding html tags so that we're able to mention other users as well as
     * talking to specific channels and these end up as href.
     *
     * @param string $msg
     * @return string
     */
    private function parseMessage(string $msg) : string
    {
        $parsed_message = [];

        $words = explode(' ', $msg);
        foreach ($words as $word)
        {
            if (preg_match('/^@/', $word))
            {
                $metion = preg_replace('/@/', '', $word);
                $parsed_message[] = '<a href="#/user/'.$metion.'">'.$word.'</a>';
            }
            elseif (preg_match('/^#/', $word))
            {
                $channel = preg_replace('/#/', '', $word);
                $parsed_message[] = '<a href="#/channel/'.$channel.'">'.$word.'</a>';
            }
            else
            {
                $parsed_message[] = $word;
            }
        }

        return implode(' ', $parsed_message);
    }

    /**
     * Return all the mention tags
     *
     * @param string $msg
     * @return array
     */
    private function getMentions(string $msg) : array
    {
        $metions = [];
        $words = explode(' ', $msg);
        foreach ($words as $word)
        {
            if (preg_match('/^@/', $word))
            {
                $metion = preg_replace('/@/', '', $word);
                $metions[] = $metion;
            }
        }
        return $metions;
    }

    /**
     * Return all the channel tags
     *
     * @param string $msg
     * @return array
     */
    private function getChannels(string $msg) : array
    {
        $channels = [];
        $words = explode(' ', $msg);
        foreach ($words as $word)
        {
            if (preg_match('/^#/', $word))
            {
                $channel = preg_replace('/#/', '', $word);
                $channels[] = $channel;
            }
        }
        return $channels;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function newTweet(Request $request)
    {
        if (isset($request->data))
        {
            $validator = Validator::make($request->all(), [
                'data' => 'required|string|max:160',
            ]);

            if ($validator->fails()) {
                return response('Bad Request', 400)->header('Content-Type', 'text/plain');
            }

            $msg = strip_tags($request->data);

            $tweet = Tweets::create([
                'messaged_by' => Auth::user()->name,
                'message' => $this->parseMessage($msg),
                'mentions' => $this->getMentions($msg),
                'channels' => $this->getChannels($msg),
            ]);

            event(new \App\Events\newTweet($tweet));

            return response('OK', 200)->header('Content-Type', 'text/plain');
        }
        else
        {
            return response('Not Found', 404)->header('Content-Type', 'text/plain');
        }
    }

    public function getTweets()
    {
        return response()->json(Tweets::orderBy('created_at', 'desc')->get());
    }

    public function getChannel($channel)
    {
        return response()->json(Tweets::whereIn('channels', [$channel])->orderBy('created_at', 'desc')->get());
    }

    public function getMention($user)
    {
        return response()->json(Tweets::whereIn('mentions', [$user])->orderBy('created_at', 'desc')->get());
    }
}
