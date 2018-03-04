<?php

namespace Jorpo\Tree\Traversal;

use StdClass;
use PHPUnit\Framework\TestCase;
use Jorpo\Tree\Node\Node;

/**
 *               A
 *              / \
 *             B   C
 *            / \
 *           D   E
 *              / \
 *             F   G
 *            /
 *           H
 *
 *    A, B, C, D, E, F, G
 */
class BreadthFirstTraversalTest extends TestCase
{
    public function testShouldCreateInstance()
    {
        $traversal = new BreadthFirstTraversal;
        $this->assertInstanceOf(TraversalAlgorithm::class, $traversal);
    }

    public function testShouldSortNodeTree()
    {
        $traversal = new BreadthFirstTraversal;

        $a = new Node('A');
        $a->addChild($b = new Node('B'));
        $a->addChild($c = new Node('C'));
        $b->addChild($d = new Node('D'));
        $b->addChild($e = new Node('E'));
        $e->addChild($f = new Node('F'));
        $e->addChild($g = new Node('G'));
        $f->addChild($h = new Node('H'));

        $this->assertSame([$a, $b, $c, $d, $e, $f, $g, $h], $traversal->sort($a));
    }

    public function testShouldTraverseNodeTree()
    {
        $traversal = new BreadthFirstTraversal;

        $a = new Node('A');
        $a->addChild($b = new Node('B'));
        $a->addChild($c = new Node('C'));
        $b->addChild($d = new Node('D'));
        $b->addChild($e = new Node('E'));
        $e->addChild($f = new Node('F'));
        $e->addChild($g = new Node('G'));
        $f->addChild($h = new Node('H'));
        $traversed = [];

        $traversal->traverse($a, function ($node) use (&$traversed) {
            $traversed[] = $node->getValue();
        });

        $this->assertSame(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'], $traversed);
    }
}
