<?php

namespace Jorpo\Tree\Node;

use StdClass;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testShouldCreateInstance()
    {
        $node = new Node;
        $this->assertInstanceOf(Node::class, $node);
    }

    public function testShouldCreateInstanceWithValue()
    {
        $node = new Node('badger');
        $this->assertSame('badger', $node->getValue());

        $node = new Node($value = new StdClass);
        $this->assertSame($value, $node->getValue());
    }

    public function testshouldSetValueAfterConstruction()
    {
        $node = new Node('badger');

        $node->setValue('mushroom');
        $this->assertSame('mushroom', $node->getValue());

        $node->setValue($value = new StdClass);
        $this->assertSame($value, $node->getValue());
    }

    public function testShouldAcceptAndReturnChildNodes()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));
        $node->addChild($child2 = new Node('child2'));
        $node->addChild($child3 = new Node('child3'));

        $this->assertSame([$child1, $child2, $child3], $node->getChildren());
    }

    public function testShouldReplaceChildNodes()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));

        $node->setChildren([$child2 = new Node('child2')]);

        $this->assertFalse(in_array($child1, $node->getChildren()));
        $this->assertTrue(in_array($child2, $node->getChildren()));
    }

    public function testShouldRemoveChildNodes()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));
        $node->addChild($child2 = new Node('child2'));

        $this->assertTrue(in_array($child1, $node->getChildren()));
        $this->assertTrue(in_array($child2, $node->getChildren()));

        $node->removeChild($child1);
        $this->assertFalse(in_array($child1, $node->getChildren()));
        $this->assertTrue(in_array($child2, $node->getChildren()));

        $node->removeChildren();
        $this->assertTrue(empty($node->getChildren()));
    }

    public function testShouldBeLeafNodeWhenHasNoChildren()
    {
        $node = new Node;
        $this->assertTrue($node->isLeaf());
    }

    public function testShouldBeBranchNodeWhenHasChildren()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));

        $this->assertFalse($node->isLeaf());
        $this->assertTrue($node->isBranch());
    }

    public function testShouldBeChildNodeWhenHasParent()
    {
        $node = new Node;
        $parent = new Node;

        $this->assertFalse($node->isChild());

        $node->setParent($parent);
        $this->assertTrue($node->isChild());
    }

    public function testShouldBeRootNodeWhenHasNoParent()
    {
        $node = new Node;
        $this->assertTrue($node->isRoot());
    }

    public function testShouldBecomeParentWhenChildrenAreAdded()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));

        $this->assertSame($node, $child1->getParent());
    }

    public function testShouldReturnRootNode()
    {
        $root = new Node;
        $root->addChild($child1 = new Node('child1'));
        $child1->addChild($child2 = new Node('child2'));

        $this->assertSame($root, $child2->getRoot());
    }

    public function testShouldReturnAncestorNodes()
    {
        $root = new Node;
        $root->addChild($child1 = new Node('child1'));
        $child1->addChild($child2 = new Node('child2'));
        $child2->addChild($child3 = new Node('child3'));

        $this->assertSame([$child2, $child1, $root], $child3->getAncestors());
    }

    public function testShouldReturnAncestorNodesWithSelf()
    {
        $root = new Node;
        $root->addChild($child1 = new Node('child1'));
        $child1->addChild($child2 = new Node('child2'));
        $child2->addChild($child3 = new Node('child3'));

        $this->assertSame([$child3, $child2, $child1, $root], $child3->getAncestorsAndSelf());
    }

    public function testShouldReturnSiblingNodes()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));
        $node->addChild($child2 = new Node('child2'));
        $node->addChild($child3 = new Node('child3'));

        $this->assertSame([$child1, $child3], $child2->getSiblings());
    }

    public function testShouldReturnSiblingNodesWithSelf()
    {
        $node = new Node;
        $node->addChild($child1 = new Node('child1'));
        $node->addChild($child2 = new Node('child2'));
        $node->addChild($child3 = new Node('child3'));

        $this->assertSame([$child1, $child2, $child3], $child2->getSiblingsAndSelf());
    }

    public function testShouldReturnSizeOfTree()
    {
        $root = new Node;
        $root->addChild($child1 = new Node('child1'));
        $root->addChild($child2 = new Node('child2'));
        $root->addChild($child3 = new Node('child3'));

        $child3->addChild(new Node("a"));
        $child3->addChild($child4 = new Node("b"));

        $child4->addChild($child5 = new Node("c"));
        $child5->addChild(new Node("d"));
        $child5->addChild(new Node("f"));

        $this->assertSame(9, $root->getSize());
        $this->assertSame(3, $child5->getSize());
        $this->assertSame(4, $child4->getSize());
        $this->assertSame(6, $child3->getSize());
        $this->assertSame(1, $child2->getSize());
    }

    public function testShouldReturnDepthOfNode()
    {
        $root = new Node;
        $root->addChild($child1 = new Node('child1'));
        $root->addChild($child2 = new Node('child2'));
        $child2->addChild($child3 = new Node("child3"));

        $this->assertSame(0, $root->getDepth());
        $this->assertSame(1, $child1->getDepth());
        $this->assertSame(2, $child3->getDepth());
    }

    public function testShouldReturnHeightOfNode()
    {
        $root = new Node;
        $root->addChild($child1 = new Node('child1'));
        $root->addChild($child2 = new Node('child2'));
        $root->addChild($child3 = new Node('child3'));

        $child3->addChild(new Node("a"));
        $child3->addChild(new Node("b"));

        $this->assertSame(2, $root->getHeight());
        $this->assertSame(0, $child1->getHeight());
        $this->assertSame(1, $child3->getHeight());
    }
}
