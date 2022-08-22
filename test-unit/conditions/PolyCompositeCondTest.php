<?php

namespace Mnemesong\MatchTestUnit\conditions;

use Mnemesong\Match\conditions\abstracts\OperatorContainsConditionInterface;
use Mnemesong\Match\conditions\FieldWithFieldCond;
use Mnemesong\Match\conditions\PolyCompositeCond;
use Mnemesong\Match\conditions\UnaryFieldCond;
use Mnemesong\MatchTestHelpers\abstractConditions\OperatorContainsConditionTestTrait;
use PHPUnit\Framework\TestCase;

class PolyCompositeCondTest extends TestCase
{
    use OperatorContainsConditionTestTrait;

    /**
     * @return TestCase
     */
    protected function useTestCase(): TestCase
    {
        return $this;
    }

    /**
     * @param string $operator
     * @return OperatorContainsConditionInterface
     */
    protected function getInitOperatorContainsCondition(string $operator): OperatorContainsConditionInterface
    {
        return new PolyCompositeCond($operator, [
            new UnaryFieldCond('!null', 'birthday'),
            new FieldWithFieldCond('>=', 'age', 'mentalAge'),
        ]);
    }

    /**
     * @return string[]
     */
    protected function getAllowedOperators(): array
    {
        return ['and', 'or'];
    }

    /**
     * @return string
     */
    protected function getProhibitedOperator1(): string
    {
        return '=';
    }

    /**
     * @return string
     */
    protected function getProhibitedOperator2(): string
    {
        return '!';
    }

    /**
     * @return void
     */
    public function testBasic(): void
    {
        $obj = new PolyCompositeCond('and', [
            new UnaryFieldCond('!null', 'birthday'),
            new FieldWithFieldCond('>=', 'age', 'mentalAge'),
        ]);
        $this->assertEquals('and', $obj->getOperator());
        $this->assertEquals([
            new UnaryFieldCond('!null', 'birthday'),
            new FieldWithFieldCond('>=', 'age', 'mentalAge'),
        ], $obj->getConds());
    }

    /**
     * @return void
     */
    public function testCondSetException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        /* @phpstan-ignore-next-line */
        $obj = new PolyCompositeCond('!', [
            (object) ['null' => 'name']
        ]);
    }
}