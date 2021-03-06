<?php

declare(strict_types=1);

/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'meta' => [
        'title' => 'New statement call of a namespaced class in a namespace',
        // Default values. If not specified will be the one used
        'prefix' => 'Humbug',
        'whitelist' => [],
    ],

    [
        'spec' => <<<'SPEC'
New statement call of a class:
- prefix the namespace
- prefix the call
- transform the call into a FQ call
SPEC
        ,
        'payload' => <<<'PHP'
<?php

namespace X\Foo {
    class Bar {}
}

namespace X {
    new Foo\Bar();
}
----
<?php

namespace Humbug\X\Foo;

class Bar
{
}
namespace Humbug\X;

new \Humbug\X\Foo\Bar();

PHP
    ],

    [
        'spec' => <<<'SPEC'
FQ new statement call of a class:
- prefix the namespace
- prefix the call
- transform the call into a FQ call
SPEC
        ,
        'payload' => <<<'PHP'
<?php

namespace Foo {
    class Bar {}
}

namespace X\Foo {
    class Bar {}
}

namespace X {
    new \Foo\Bar();
}
----
<?php

namespace Humbug\Foo;

class Bar
{
}
namespace Humbug\X\Foo;

class Bar
{
}
namespace Humbug\X;

new \Humbug\Foo\Bar();

PHP
    ],
];
