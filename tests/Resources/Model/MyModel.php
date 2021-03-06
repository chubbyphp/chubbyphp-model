<?php

declare(strict_types=1);

namespace MyProject\Model;

use Chubbyphp\Model\Collection\ModelCollection;
use Chubbyphp\Model\ModelInterface;
use Chubbyphp\Model\Reference\ModelReference;

final class MyModel implements ModelInterface, \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $category;

    /**
     * @var ModelReference
     */
    private $oneToOne;

    /**
     * @var ModelCollection
     */
    private $oneToMany;

    /**
     * @param string|null $id
     *
     * @return self
     */
    public static function create(string $id = null): self
    {
        $myModel = new self();
        $myModel->id = $id ?? uniqid('id');
        $myModel->oneToOne = new ModelReference();
        $myModel->oneToMany = new ModelCollection(MyEmbeddedModel::class, 'modelId', $myModel->id, ['name' => 'ASC']);

        return $myModel;
    }

    private function __construct()
    {
    }

    /**
     * @param array $data
     *
     * @return self|ModelInterface
     */
    public static function fromPersistence(array $data): ModelInterface
    {
        $model = new self();
        $model->id = $data['id'];
        $model->name = $data['name'];
        $model->category = $data['category'];
        $model->oneToOne = $data['oneToOne'];
        $model->oneToMany = $data['oneToMany'];

        return $model;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $category
     *
     * @return self
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param MyEmbeddedModel|null $oneToOne
     *
     * @return self
     */
    public function setOneToOne(MyEmbeddedModel $oneToOne = null): self
    {
        $this->oneToOne->setModel($oneToOne);

        return $this;
    }

    /**
     * @return MyEmbeddedModel|ModelInterface|null
     */
    public function getOneToOne()
    {
        return $this->oneToOne->getModel();
    }

    /**
     * @param MyEmbeddedModel[]|array $oneToMany
     *
     * @return self
     */
    public function setOneToMany(array $oneToMany): self
    {
        $this->oneToMany->setModels($oneToMany);

        return $this;
    }

    /**
     * @return MyEmbeddedModel[]|ModelInterface[]|array
     */
    public function getOneToMany()
    {
        return $this->oneToMany->getModels();
    }

    /**
     * @return array
     */
    public function toPersistence(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'oneToOne' => $this->oneToOne,
            'oneToMany' => $this->oneToMany,
        ];
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'oneToOne' => $this->oneToOne->jsonSerialize(),
            'oneToMany' => $this->oneToMany->jsonSerialize(),
        ];
    }
}
