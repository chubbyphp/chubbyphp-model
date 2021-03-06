<?php

namespace Chubbyphp\Tests\Model\Reference;

use Chubbyphp\Model\ModelInterface;
use Chubbyphp\Model\Reference\ModelReference;
use MyProject\Model\MyEmbeddedModel;
use MyProject\Model\MyEmbeddedModelNoJsonSerialize;

final class ModelReferenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::setModel
     */
    public function testSetModel()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelReference = new ModelReference();

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertInstanceOf(ModelInterface::class, $modelReference->getModel());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::getInitialModel
     */
    public function testGetInitialModel()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelReference = new ModelReference();

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertInstanceOf(ModelInterface::class, $modelReference->getModel());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::getModel
     */
    public function testGetModel()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelReference = new ModelReference();

        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertInstanceOf(ModelInterface::class, $modelReference->getModel());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::getId
     */
    public function testGetId()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelReference = new ModelReference();
        $modelReference->setModel($model);

        self::assertNull($modelReference->getInitialModel());
        self::assertSame('id1', $modelReference->getId());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::getId
     */
    public function testGetIdNullReference()
    {
        $modelReference = new ModelReference();

        self::assertNull($modelReference->getInitialModel());
        self::assertNull($modelReference->getId());
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::jsonSerialize
     */
    public function testJsonSerializeNullReference()
    {
        $modelReference = new ModelReference();

        self::assertNull(json_decode(json_encode($modelReference), true));
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::jsonSerialize
     * @covers \Chubbyphp\Model\Reference\ModelReference::jsonSerializableOrException
     */
    public function testJsonSerialize()
    {
        $model = MyEmbeddedModel::create('id1');
        $model->setName('name1');

        $modelReference = new ModelReference();
        $modelReference->setModel($model);

        $modelAsArray = json_decode(json_encode($modelReference), true);

        self::assertSame('name1', $modelAsArray['name']);
    }

    /**
     * @covers \Chubbyphp\Model\Reference\ModelReference::jsonSerialize
     * @covers \Chubbyphp\Model\Reference\ModelReference::jsonSerializableOrException
     */
    public function testJsonSerializeWithModelNotimplementingJsonSerialize()
    {
        self::expectException(\LogicException::class);
        self::expectExceptionMessage(
            sprintf('Model %s does not implement %s', MyEmbeddedModelNoJsonSerialize::class, \JsonSerializable::class)
        );

        $model = MyEmbeddedModelNoJsonSerialize::create('id1');
        $model->setName('name1');

        $modelReference = new ModelReference();
        $modelReference->setModel($model);

        json_encode($modelReference);
    }
}
