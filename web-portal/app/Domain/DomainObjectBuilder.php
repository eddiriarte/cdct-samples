<?php


namespace App\Domain;


use Illuminate\Support\Str;

trait DomainObjectBuilder
{
    public static function make(array $parameters = []): self
    {
        $class = new \ReflectionClass(static::class);
        $instance = $class->newInstance();

        foreach ($class->getProperties() as $reflectionProperty) {
            $property = $reflectionProperty->getName();
            if (!array_key_exists(Str::snake($property), $parameters)) {
                continue;
            }

            if ($reflectionProperty->isPrivate()) {
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($instance, $parameters[Str::snake($property)]);
            } else {
                $instance->{$property} = $parameters[Str::snake($property)];
            }
        }

        return $instance;
    }

    abstract public function toArray(): array;

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
