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

namespace Humbug\PhpScoper\PhpParser;

use Humbug\PhpScoper\Configuration\SymbolsConfiguration;
use Humbug\PhpScoper\Scoper\FakeScoper;
use Humbug\PhpScoper\Scoper\PhpScoper;
use Humbug\PhpScoper\Symbol\EnrichedReflector;
use Humbug\PhpScoper\Symbol\Reflector;
use Humbug\PhpScoper\Symbol\SymbolsRegistry;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * @covers \Humbug\PhpScoper\PhpParser\TraverserFactory
 */
class TraverserFactoryTest extends TestCase
{
    public function test_creates_a_new_traverser_at_each_call(): void
    {
        $prefix = 'Humbug';
        $phpScoper = new PhpScoper(
            new FakeParser(),
            new FakeScoper(),
            (new ReflectionClass(TraverserFactory::class))->newInstanceWithoutConstructor(),
            $prefix,
            new SymbolsRegistry(),
        );
        $symbolsRegistry = new SymbolsRegistry();

        $traverserFactory = new TraverserFactory(
            new EnrichedReflector(
                Reflector::createEmpty(),
                SymbolsConfiguration::create(),
            ),
        );

        $firstTraverser = $traverserFactory->create(
            $phpScoper,
            $prefix,
            $symbolsRegistry,
        );
        $secondTraverser = $traverserFactory->create(
            $phpScoper,
            $prefix,
            $symbolsRegistry,
        );

        self::assertNotSame($firstTraverser, $secondTraverser);
    }
}
