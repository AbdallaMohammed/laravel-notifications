<?php

namespace Elnooronline\Notifications\Tests\Unit;

use Elnooronline\Notifications\Support\Notifications;
use Elnooronline\Notifications\Tests\TestCase;

class FirebaseProviderUnitTest extends TestCase
{
    public function testSetTitle()
    {
        $title = 'Notification Title';

        $result = Notifications::make()
            ->provider('firebase')
            ->title($title);

        $this->assertEquals($result->get('title'), $title);
    }

    public function testSetBody()
    {
        $body = 'Notification Body';

        $result = Notifications::make()
            ->provider('firebase')
            ->body($body);

        $this->assertEquals($result->get('body'), $body);
    }

    public function testSetImage()
    {
        $image = 'https://image-url.com/';

        $result = Notifications::make()
            ->provider('firebase')
            ->image($image);

        $this->assertEquals($result->get('image'), $image);
    }
}
