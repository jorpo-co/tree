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
 *    D, B, H, F, E, G, A, C
 */
class DepthFirstInOrderTraversalTest extends TestCase
{
    public function testShouldCreateInstance()
    {
        $traversal = new DepthFirstInOrderTraversal;
        $this->assertInstanceOf(TraversalAlgorithm::class, $traversal);
    }

    public function testShouldSortNodeTree()
    {
        $traversal = new DepthFirstInOrderTraversal;

        $a = new Node('A');
        $a->addChild($b = new Node('B'));
        $a->addChild($c = new Node('C'));
        $b->addChild($d = new Node('D'));
        $b->addChild($e = new Node('E'));
        $e->addChild($f = new Node('F'));
        $e->addChild($g = new Node('G'));
        $f->addChild($h = new Node('H'));

        $this->assertSame([$d, $b, $h, $f, $e, $g, $a, $c], $traversal->sort($a));
    }

    public function testShouldTraverseNodeTree()
    {
        $traversal = new DepthFirstInOrderTraversal;

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

        $this->assertSame(['D', 'B', 'H', 'F', 'E', 'G', 'A', 'C'], $traversed);
    }
}
