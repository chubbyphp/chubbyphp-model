<?php

namespace Chubbyphp\Tests\Model\Reference;

use Chubbyphp\Model\ModelInterface;
use Chubbyphp\Model\Reference\LazyModelReference;
use Chubbyphp\Model\ResolverInterface;
use MyProject\Model\MyEmbeddedModel;
use MyProject\Model\MyEmbeddedModelNoJsonSerialize;

final class LazyModelReferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::setModel
     */
    public function testSetModel()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelClass = MyEmbeddedModel::class;
        $id = null;
        $return = null;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertInstanceOf(ModelInterface::class, $modelReference->getModel());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::getInitialModel
     */
    public function testGetInitialModel()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelClass = MyEmbeddedModel::class;
        $id = null;
        $return = null;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertInstanceOf(ModelInterface::class, $modelReference->getModel());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::getModel
     */
    public function testGetModel()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelClass = MyEmbeddedModel::class;
        $id = null;
        $return = null;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertInstanceOf(ModelInterface::class, $modelReference->getModel());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::getId
     */
    public function testGetId()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelClass = MyEmbeddedModel::class;
        $id = null;
        $return = null;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertSame('id1', $modelReference->getId());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::getId
     */
    public function testGetIdNullReference()
    {
        $modelClass = MyEmbeddedModel::class;
        $id = null;
        $return = null;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        self::assertNull($modelReference->getInitialModel());
        self::assertNull($modelReference->getId());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::jsonSerialize
     */
    public function testJsonSerializeNullReference()
    {
        $modelClass = MyEmbeddedModel::class;
        $id = null;
        $return = null;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        self::assertNull(json_decode(json_encode($modelReference), true));
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::jsonSerialize
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::jsonSerializableOrException
     */
    public function testJsonSerialize()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelClass = MyEmbeddedModel::class;
        $id = $model->getId();
        $return = $model;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        $modelAsArray = json_decode(json_encode($modelReference), true);

        self::assertSame('name1', $modelAsArray['name']);
    }

    /**
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::__construct
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::resolveModel
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::jsonSerialize
     * @covers \Chubbyphp\Model\Reference\LazyModelReference::jsonSerializableOrException
     */
    public function testJsonSerializeWithModelNotimplementingJsonSerialize()
    {
        self::expectException(\LogicException::class);
        self::expectExceptionMessage(
            sprintf('Model %s does not implement %s', MyEmbeddedModelNoJsonSerialize::class, \JsonSerializable::class)
        );

        $model = MyEmbeddedModelNoJsonSerialize::create('id1');
        $model->setName('name1');

        $modelClass = MyEmbeddedModelNoJsonSerialize::class;
        $id = $model->getId();
        $return = $model;

        $modelReference = new LazyModelReference(
            $this->getResolver($modelClass, $id, $return),
            $modelClass,
            $id
        );

        json_encode($modelReference);
    }

    /**
     * @param string              $expectedModelClass
     * @param string|null         $expectedId
     * @param ModelInterface|null $return
     *
     * @return ResolverInterface
     */
    private function getResolver(
        string $expectedModelClass,
        string $expectedId = null,
        $return
    ): ResolverInterface {
        /** @var ResolverInterface|\PHPUnit_Framework_MockObject_MockObject $resolver */
        $resolver = $this->getMockBuilder(ResolverInterface::class)
            ->setMethods(['find'])
            ->getMockForAbstractClass();

        $resolver->expects(self::any())
            ->method('find')
            ->willReturnCallback(
                function (
                    string $modelClass,
                    string $id = null
                ) use (
                    $expectedModelClass,
                    $expectedId,
                    $return
                ) {
                    self::assertSame($expectedModelClass, $modelClass);
                    self::assertSame($expectedId, $id);

                    return $return;
                }
            );

        return $resolver;
    }
}
