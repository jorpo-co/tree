<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal;

use PHPUnit\Framework\TestCase;
use Jorpo\Tree\Node;

abstract class AlgorithmTestCase extends TestCase
{
    protected function buildNodeTree(): array
    {
        $a = new Node('A');
        $a->addChild($b = new Node('B'));
        $a->addChild($c = new Node('C'));
        $b->addChild($d = new Node('D'));
        $b->addChild($e = new Node('E'));
        $e->addChild($f = new Node('F'));
        $e->addChild($g = new Node('G'));
        $f->addChild($h = new Node('H'));

        return [$a, $b, $c, $d, $e, $f, $g, $h];
    }
}
