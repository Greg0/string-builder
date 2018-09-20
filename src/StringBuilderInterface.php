<?php


namespace Greg0\StringBuilder;


interface StringBuilderInterface
{
    public function toString(): string;

    public function __toString(): string;

    public function length(): int;

    public function append(string $value): self;

    /**
     * @param string $format Basing on sprintf formats
     * @param mixed  ...$values
     * @return StringBuilderInterface
     * @see sprintf()
     */
    public function appendFormat(string $format, ...$values): self;

    public function appendLine(string $value = null): self;

    /**
     * Inserting value on specified position
     * @param int    $position
     * @param string $value
     * @param int    $repeats
     * @return StringBuilder
     * @throws Exception\OutOfRangeException Index was out of range. Must be non-negative and less than the string length.
     */
    public function insert(int $position, string $value, int $repeats = 1): self;

    /**
     * @param int $startIndex
     * @param int $length
     * @return StringBuilder
     * @throws Exception\OutOfRangeException Index was out of range. Must be non-negative and less than the string length.
     */
    public function remove(int $startIndex, int $length): self;

    public function clear(): self;

    public function replace(string $string, string $replacement): self;

    public function equals(StringBuilder $sb2): bool;

    public function hash(string $algorithm): string;

    public function clone(): self;
}