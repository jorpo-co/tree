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
 *    D, H, F, G, E, B, C, A
 */
class DepthFirstPostOrderTraversalTest extends TestCase
{
    public function testShouldCreateInstance()
    {
        $traversal = new DepthFirstPostOrderTraversal;
        $this->assertInstanceOf(TraversalAlgorithm::class, $traversal);
    }

    public function testShouldSortNodeTree()
    {
        $traversal = new DepthFirstPostOrderTraversal;

        $a = new Node('A');
        $a->addChild($b = new Node('B'));
        $a->addChild($c = new Node('C'));
        $b->addChild($d = new Node('D'));
        $b->addChild($e = new Node('E'));
        $e->addChild($f = new Node('F'));
        $e->addChild($g = new Node('G'));
        $f->addChild($h = new Node('H'));

        $this->assertSame([$d, $h, $f, $g, $e, $b, $c, $a], $traversal->sort($a)->toArray());
    }

    public function testShouldTraverseNodeTree()
    {
        $traversal = new DepthFirstPostOrderTraversal;

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

        $this->assertSame(['D', 'H', 'F', 'G', 'E', 'B', 'C', 'A'], $traversed);
    }
}
