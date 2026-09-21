<?php

class Product
{
    public function __construct(
        public string $name,
        public string $category,
        public float $price,
        public int $quantity
    ) {}

    public function getTotalValue(): float
    {
        return $this->price * $this->quantity;
    }
}

class Inventory
{
    private array $products = [];

    public function addProduct(
        string $name,
        string $category,
        float $price,
        int $quantity
    ): void {
        $this->products[] = new Product(
            $name,
            $category,
            $price,
            $quantity
        );
    }

    public function sortByValue(): void
    {
        usort(
            $this->products,
            fn(Product $a, Product $b) =>
                $b->getTotalValue() <=> $a->getTotalValue()
        );
    }

    public function getTotalValue(): float
    {
        return array_sum(
            array_map(
                fn(Product $product) => $product->getTotalValue(),
                $this->products
            )
        );
    }

    public function printReport(): void
    {
        echo "Inventory Report\n";
        echo "================\n";

        foreach ($this->products as $product) {
            echo sprintf(
                "%-15s | %-12s | $%.2f | %d units | $%.2f\n",
                $product->name,
                $product->category,
                $product->price,
                $product->quantity,
                $product->getTotalValue()
            );
        }

        echo "================\n";
        echo "Products: " . count($this->products) . "\n";
        echo "Total Value: $" . number_format(
            $this->getTotalValue(),
            2
        ) . "\n";
    }
}

$inventory = new Inventory();

$inventory->addProduct("Laptop", "Electronics", 899.99, 6);
$inventory->addProduct("Keyboard", "Accessories", 79.50, 15);
$inventory->addProduct("Monitor", "Electronics", 249.99, 10);
$inventory->addProduct("Mouse", "Accessories", 39.99, 24);
$inventory->addProduct("Headphones", "Audio", 129.99, 12);

$inventory->sortByValue();
$inventory->printReport();