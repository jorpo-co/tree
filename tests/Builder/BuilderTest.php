<?php

namespace Jorpo\Tree\Builder;

use PHPUnit\Framework\TestCase;
use Jorpo\Tree\Node\Node;

class BuilderTest extends TestCase
{
    protected $builder;

    public function setUp()
    {
        $this->builder = new Builder;
    }

    public function testShouldCreateEmptyNodeIfNotSpecifiedInConstructor()
    {
        $builder = new Builder;
        $this->assertNull($builder->getCurrentNode()->getValue());
    }

    public function testShouldAllowNodeInConstructor()
    {
        $builder = new Builder($node = new Node('node'));
        $this->assertSame($node, $builder->getCurrentNode());
    }

    public function testShouldSetRootNodeAndGetRootNode()
    {
        $builder = new Builder;

        $builder->setRootNode($node1 = new Node('node1'));
        $this->assertSame($node1, $builder->getCurrentNode());

        $builder->setRootNode($node2 = new Node('node2'));
        $this->assertSame($node2, $builder->getCurrentNode());
    }

    public function testShouldAddLeafNode()
    {
        $builder = new Builder;

        $builder->leaf('a')->leaf('b');
        $children = $builder->getCurrentNode()->getChildren();

        $this->assertSame('a', $children[0]->getValue());
        $this->assertSame('b', $children[1]->getValue());
    }

    public function testShouldAddMultipleLeaves()
    {
        $builder = new Builder;

        $builder->leaves('a', 'b');
        $children = $builder->getCurrentNode()->getChildren();

        $this->assertSame('a', $children[0]->getValue());
        $this->assertSame('b', $children[1]->getValue());
    }

    public function testShouldAddBranchNodes()
    {
        $builder = new Builder;

        $builder->branch('a')->branch('b');
        $this->assertSame('b', $builder->getCurrentNode()->getValue());
    }

    public function testShouldEndCurrentBranch()
    {
        $builder = new Builder;

        $builder
            ->value('root')
            ->branch('a')
                ->branch('b')
                    ->branch('c')
                    ->end();

        $this->assertSame('b', $builder->getCurrentNode()->getValue());
        $builder->end();
        $this->assertSame('a', $builder->getCurrentNode()->getValue());
        $builder->end();
        $this->assertSame('root', $builder->getCurrentNode()->getValue());
    }

    public function testShouldGetValue()
    {
        $builder = new Builder;

        $builder->value('foo')->value('bar');
        $this->assertSame('bar', $builder->getCurrentNode()->getValue());
    }

    public function testShouldAddNewNodeAsChildOfTheParentNode()
    {
        $builder = new Builder;
        $builder
            ->value('root')
            ->branch('a')
                ->branch('b')->end()
                ->leaf('c')
            ->end();
        $node = $builder->getCurrentNode();

        $this->assertSame(['a'], $this->childrenValues($node->getChildren()));

        $subtree = $node->getChildren()[0];
        $this->assertSame(['b', 'c'], $this->childrenValues($subtree->getChildren()));
    }

    public function testShouldCreateNodeInstanceByValue()
    {
        $builder = new Builder;

        $node = $builder->nodeInstanceByValue('baz');
        $this->assertSame('baz', $node->getValue());
        $this->assertInstanceOf(Node::class, $node);
    }

    /**
     * @param array[Node] $children
     * @return array
     */
    private function childrenValues(array $children)
    {
        return array_map(function (Node $node) {
            return $node->getValue();
        }, $children);
    }
}
