<?php declare(strict_types=1);

namespace Jorpo\Tree\Traversal\DepthFirst;

use Jorpo\Tree\Node;
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
 *    D, H, F, G, E, B, C, A
 */
class PostOrderTraversalTest extends AlgorithmTestCase
{
    public function testThatAlgorithmSortsNodeTree()
    {
        $traversal = new PostOrderTraversal;

        list($a, $b, $c, $d, $e, $f, $g, $h) = $this->buildNodeTree();

        $this->assertSame([$d, $h, $f, $g, $e, $b, $c, $a], ($traversal->sort($a))->toArray());
    }

    public function testThatAlgorithmTraversesNodeTree()
    {
        $traversal = new PostOrderTraversal;

        list($a) = $this->buildNodeTree();
        $traversed = "";

        $traversal->traverse($a, function (Node $node) use (&$traversed) {
            $traversed .= $node->getValue();
        });

        $this->assertSame('DHFGEBCA', $traversed);
    }
}
