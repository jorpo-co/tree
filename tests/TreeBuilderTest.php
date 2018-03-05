<?php

namespace Jorpo\Tree;

use PHPUnit\Framework\TestCase;
use Jorpo\Tree\Node;

class BuilderTest extends TestCase
{
    protected $builder;

    public function setUp()
    {
        $this->builder = new TreeBuilder;
    }

    public function testShouldCreateEmptyNodeIfNotSpecifiedInConstructor()
    {
        $builder = new TreeBuilder;
        $this->assertNull($builder->getCurrentNode()->getValue());
    }

    public function testShouldAllowNodeInConstructor()
    {
        $builder = new TreeBuilder($node = new Node('node'));
        $this->assertSame($node, $builder->getCurrentNode());
    }

    public function testShouldSetRootNodeAndGetRootNode()
    {
        $builder = new TreeBuilder;

        $builder->setRootNode($node1 = new Node('node1'));
        $this->assertSame($node1, $builder->getCurrentNode());

        $builder->setRootNode($node2 = new Node('node2'));
        $this->assertSame($node2, $builder->getCurrentNode());
    }

    public function testShouldAddLeafNode()
    {
        $builder = new TreeBuilder;

        $builder->leaf('a')->leaf('b');
        $children = $builder->getCurrentNode()->getChildren();

        $this->assertSame('a', $children[0]->getValue());
        $this->assertSame('b', $children[1]->getValue());
    }

    public function testShouldAddMultipleLeaves()
    {
        $builder = new TreeBuilder;

        $builder->leaves('a', 'b');
        $children = $builder->getCurrentNode()->getChildren();

        $this->assertSame('a', $children[0]->getValue());
        $this->assertSame('b', $children[1]->getValue());
    }

    public function testShouldAddBranchNodes()
    {
        $builder = new TreeBuilder;

        $builder->branch('a')->branch('b');
        $this->assertSame('b', $builder->getCurrentNode()->getValue());
    }

    public function testShouldEndCurrentBranch()
    {
        $builder = new TreeBuilder;

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
        $builder = new TreeBuilder;

        $builder->value('foo')->value('bar');
        $this->assertSame('bar', $builder->getCurrentNode()->getValue());
    }

    public function testShouldAddNewNodeAsChildOfTheParentNode()
    {
        $builder = new TreeBuilder;
        $builder
            ->value('root')
            ->branch('a')
                ->branch('b')->end()
                ->leaf('c')
            ->end();
        $node = $builder->getCurrentNode();

        $this->assertSame(['a'], $this->childrenValues($node->getChildren()->toArray()));

        $subtree = $node->getChildren()->toArray()[0];
        $this->assertSame(['b', 'c'], $this->childrenValues($subtree->getChildren()->toArray()));
    }

    public function testShouldCreatenodeFromValue()
    {
        $builder = new TreeBuilder;

        $node = $builder->nodeFromValue('baz');
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
