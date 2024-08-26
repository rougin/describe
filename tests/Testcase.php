<?php

namespace Rougin\Describe;

use LegacyPHPUnit\TestCase as Legacy;

/**
 * @codeCoverageIgnore
 *
 * @package Describe
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Testcase extends Legacy
{
    const TEST_USER = 'desc';

    const TEST_PASS = 'desc';

    /** @phpstan-ignore-next-line */
    public function setExpectedException($exception)
    {
        if (method_exists($this, 'expectException'))
        {
            $this->expectException($exception);

            return;
        }

        /** @phpstan-ignore-next-line */
        parent::setExpectedException($exception);
    }
}
