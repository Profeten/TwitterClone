<?php

namespace Tests\Unit;

use App\Http\Controllers\TweetController;
use ReflectionClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TweetTest extends TestCase
{

    /**
     * Hack to access protected/private methods in test :)
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return \ReflectionMethod
     * @internal param $name
     */
    protected static function invokeMethod(&$object, $methodName, array $parameters = array()) {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_mentions_return_correct_string()
    {
        $controller = new TweetController();
        $msg = 'This fake tweet mentioned @Johan';
        $this->assertContains('Johan', $this->invokeMethod($controller, 'getMentions', array($msg)));
    }

    public function test_that_mention_return_correct_string()
    {
        $controller = new TweetController();
        $msg = 'This fake tweet mentioned #channel';
        $this->assertContains('channel', $this->invokeMethod($controller, 'getChannels', array($msg)));
    }

    public function test_that_channel_return_correct_string()
    {
        $controller = new TweetController();
        $msg = 'Fake tweet to #channel';
        $this->assertContains('channel', $this->invokeMethod($controller, 'getChannels', array($msg)));
    }

    public function test_that_parsing_tweets_return_correct_string()
    {
        $controller = new TweetController();
        $msg = 'Fake tweet to #channel with mention @Johan';
        $wantedResult = 'Fake tweet to <a href="#/channel/channel">#channel</a> with mention <a href="#/user/Johan">@Johan</a>';
        $this->assertContains($wantedResult, $this->invokeMethod($controller, 'parseMessage', array($msg)));
    }
}
