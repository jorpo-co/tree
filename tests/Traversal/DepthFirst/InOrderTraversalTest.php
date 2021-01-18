<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal\DepthFirst;

use Jorpo\Tree\Traversal\AlgorithmTestCase;

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
class InOrderTraversalTest extends AlgorithmTestCase
{
    public function testThatAlgorithmSortsNodeTree()
    {
        $traversal = new InOrderTraversal;

        list($a, $b, $c, $d, $e, $f, $g, $h) = $this->buildNodeTree();

        $this->assertSame([$d, $b, $h, $f, $e, $g, $a, $c], ($traversal->sort($a))->toArray());
    }

    public function testThatAlgorithmTraversesNodeTree()
    {
        $traversal = new InOrderTraversal;

        list($a) = $this->buildNodeTree();
        $traversed = "";

        $traversal->traverse($a, function ($node) use (&$traversed) {
            $traversed .= $node->getValue();
        });

        $this->assertSame('DBHFEGAC', $traversed);
    }
}
