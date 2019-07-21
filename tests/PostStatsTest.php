<?php

use PHPUnit\Framework\TestCase;

class PostStatsTest extends TestCase {
    function test_trailingslashit_should_add_slash_when_none_is_present() {
        $this->assertSame( 'foo/', trailingslashit( 'foo' ) );
    }
}
