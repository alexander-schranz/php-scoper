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
        'title' => 'Class declaration',
        // Default values. If not specified will be the one used
        'prefix' => 'Humbug',
        'whitelist' => [],
    ],

    'Declaration in the global namespace: do not do anything.' => <<<'PHP'
<?php

class A {
    public function a() {}
}
----
<?php

class A
{
    public function a()
    {
    }
}

PHP
    ,

    'Declaration in a namespace: prefix the namespace.' => <<<'PHP'
<?php

namespace Foo;

class A {
    public function a() {}
}
----
<?php

namespace Humbug\Foo;

class A
{
    public function a()
    {
    }
}

PHP
    ,

    'Declaration of a namespaced whitelisted class: do not prefix the namespace.' => [
        'whitelist' => ['Foo\A'],
        'payload' => <<<'PHP'
<?php

namespace Foo;

class A {
    public function a() {}
}
----
<?php

namespace Foo;

class A
{
    public function a()
    {
    }
}

PHP
        ],

    'Multiple declarations in different namespaces: prefix each namespace.' => <<<'PHP'
<?php

namespace Foo {

    class A {
        public function a() {}
    }
}

namespace Bar {

    class B {
        public function b() {}
    }
}

namespace {

    class C {
        public function c() {}
    }
}
----
<?php

namespace Humbug\Foo {
    class A
    {
        public function a()
        {
        }
    }
}
namespace Humbug\Bar {
    class B
    {
        public function b()
        {
        }
    }
}
namespace {
    class C
    {
        public function c()
        {
        }
    }
}

PHP
    ,
];
