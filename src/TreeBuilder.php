<?php declare(strict_types=1);

namespace Jorpo\Tree;

use Ds\Stack;
use Jorpo\Tree\Node;
use UnderflowException;

class TreeBuilder
{
    /**
     * @var Stack
     */
    private $stack;

    public function __construct(Node $node = null)
    {
        $this->stack = new Stack;

        $this->setRootNode($node ?? $this->nodeFromValue());
    }

    public function setRootNode(Node $node): TreeBuilder
    {
        $this->emptyStack()->pushNode($node);

        return $this;
    }

    public function getCurrentNode(): Node
    {
        return $this->stack->peek();
    }

    /**
     * @param mixed|null $value
     * @throws UnderflowException
     */
    public function leaf($value = null): TreeBuilder
    {
        $this->getCurrentNode()->addChild(
            $this->nodeFromValue($value)
        );

        return $this;
    }

    /**
     * @param mixed $values
     * @throws UnderflowException
     */
    public function leaves(...$values): TreeBuilder
    {
        foreach ($values as $value) {
            $this->leaf($value);
        }

        return $this;
    }

    /**
     * @param mixed|null $value
     * @throws UnderflowException
     */
    public function branch($value = null): TreeBuilder
    {
        $this->getCurrentNode()->addChild($node = $this->nodeFromValue($value));
        $this->pushNode($node);

        return $this;
    }

    /**
     * @throws UnderflowException
     */
    public function end(): TreeBuilder
    {
        $this->popNode();

        return $this;
    }

    /**
     * @param mixed|null $value
     */
    public function nodeFromValue($value = null): Node
    {
        return new Node($value);
    }

    /**
     * @param mixed $value
     * @throws UnderflowException
     */
    public function value($value): TreeBuilder
    {
        $this->getCurrentNode()->setValue($value);

        return $this;
    }

    private function emptyStack(): TreeBuilder
    {
        $this->stack->clear();

        return $this;
    }

    private function pushNode(Node $node): TreeBuilder
    {
        $this->stack->push($node);

        return $this;
    }

    /**
     * @throws UnderflowException
     */
    private function popNode(): Node
    {
        return $this->stack->pop();
    }
}
