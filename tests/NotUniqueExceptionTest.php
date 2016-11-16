<?php

namespace Chubbyphp\Tests\Model;

use Chubbyphp\Model\NotUniqueException;
use Chubbyphp\Tests\Model\Resources\User;

/**
 * @covers Chubbyphp\Model\NotUniqueException
 */
final class NotUniqueExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $exception = NotUniqueException::create(User::class, ['username' => 'user1d'], 3);

        self::assertSame(
            'There are 3 models of class '.User::class.' for criteria username: user1d',
            $exception->getMessage()
        );
    }
}