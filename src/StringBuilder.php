<?php


namespace Greg0\StringBuilder;


class StringBuilder implements StringBuilderInterface
{
    private $chars;

    public function __construct(string $initial = null)
    {
        $this->chars = $initial ?? '';
    }

    public function toString(): string
    {
        return $this->chars;
    }

    public function clone(): StringBuilderInterface
    {
        return clone $this;
    }

    public function length(): int
    {
        return \strlen($this->chars);
    }


    public function __toString(): string
    {
        return $this->toString();
    }

    public function append(string $value): StringBuilderInterface
    {
        $this->chars .= $value;

        return $this;
    }

    public function appendFormat(string $format, ...$values): StringBuilderInterface
    {
        $this->chars .= vsprintf($format, $values);

        return $this;
    }

    public function clear(): StringBuilderInterface
    {
        $this->chars = '';

        return $this;
    }

    public function appendLine(string $value = null): StringBuilderInterface
    {
        $this->chars .= $value . PHP_EOL;

        return $this;
    }

    public function equals(StringBuilder $sb2): bool
    {
        return $this->toString() === $sb2->toString();
    }

    public function hash(string $algorithm): string
    {
        return hash($algorithm, $this->toString());
    }

    public function insert(int $position, string $value, int $repeats = 1): StringBuilderInterface
    {
        if ($position < 0 || $position > $this->length())
        {
            throw new Exception\OutOfRangeException('Index was out of range. Must be non-negative and less than the string length.');
        }

        $this->chars = substr_replace($this->chars, str_repeat($value, $repeats), $position, 0);

        return $this;
    }

    public function remove(int $startIndex, int $length): StringBuilderInterface
    {
        if ($startIndex < 0 || $startIndex >= $this->length())
        {
            throw new Exception\OutOfRangeException('Index was out of range. Must be non-negative and less than the string length.');
        }

        $this->chars = substr_replace($this->chars, '', $startIndex, $length);

        return $this;
    }

    public function replace(string $string, string $replacement): StringBuilderInterface
    {
        $this->chars = \str_replace($string, $replacement, $this->chars);

        return $this;
    }
}