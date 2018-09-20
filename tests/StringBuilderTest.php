<?php


namespace Greg0\StringBuilder;


use PHPUnit\Framework\TestCase;

class StringBuilderTest extends TestCase
{
    public function testInitEmpty(): void
    {
        $sb = new StringBuilder();
        $this->assertEmpty($sb->toString());
    }

    public function testInitWithString(): void
    {
        $sb = new StringBuilder('Initial string');
        $this->assertEquals('Initial string', $sb->toString());
    }

    public function testCastToString(): void
    {
        $sb = new StringBuilder('Initial string');
        $this->assertEquals('Initial string', (string)$sb);
    }

    public function testInitEmptyLength(): void
    {
        $sb = new StringBuilder();

        $this->assertEquals(0, $sb->length());
    }

    public function lengthProvider(): array
    {
        return [
            ['string' => '', 'length' => 0],
            ['string' => 'Lorem', 'length' => 5],
            ['string' => 'Śßłóą     ', 'length' => 15],
            ['string' => '---Śu$%łóą12345', 'length' => 19],
        ];
    }

    /**
     * @dataProvider lengthProvider
     */
    public function testInitialLength(string $string, int $length): void
    {
        $sb = new StringBuilder($string);

        $this->assertEquals($length, $sb->length());
    }

    public function testClear(): void
    {
        $sb = new StringBuilder('Lorem ipsum dolor');
        $sb->clear();
        $this->assertEquals(0, $sb->length());
        $this->assertEmpty($sb->toString());
    }

    public function testAppend(): void
    {
        $sb = new StringBuilder('Lorem ipsum.');

        $sb->append(' Dolor ')->append('sit amet.');

        $this->assertEquals('Lorem ipsum. Dolor sit amet.', $sb->toString());
    }

    public function testAppendFormat(): void
    {
        $sb = new StringBuilder();

        $sb
            ->appendFormat('%s %s %d.', 'Lorem', 'ipsum', 2)
            ->appendFormat('%s %.2f %d', 'Lorem', 12.12567, 2);

        $this->assertEquals(
            'Lorem ipsum 2.Lorem 12.13 2',
            $sb->toString()
        );
    }

    public function testAppendLine(): void
    {
        $sb = new StringBuilder();
        $sb
            ->appendLine('Lorem')
            ->appendLine('ipsum')
            ->appendLine('dolor');

        $this->assertEquals("Lorem\nipsum\ndolor\n", $sb->toString());
    }

    public function testAppendEmptyLine(): void
    {
        $sb = new StringBuilder();
        $sb
            ->appendLine('Lorem')
            ->appendLine()
            ->appendLine('dolor');

        $this->assertEquals("Lorem\n\ndolor\n", $sb->toString());
    }

    public function testAppendLineWithInitialValue(): void
    {
        $sb = new StringBuilder('Initial');
        $sb
            ->appendLine('Lorem')
            ->appendLine('ipsum')
            ->appendLine('dolor');

        $this->assertEquals("InitialLorem\nipsum\ndolor\n", $sb->toString());
    }

    public function testEquals(): void
    {
        $sb1 = new StringBuilder('First version');
        $sb2 = new StringBuilder('First version');

        $this->assertTrue($sb1->equals($sb2));
    }

    public function testNotEquals(): void
    {
        $sb1 = new StringBuilder('First version');
        $sb2 = new StringBuilder("First version\n");

        $this->assertFalse($sb1->equals($sb2));
    }

    public function testHash(): void
    {
        $string = 'Lorem ipsum dolor';
        $md5Hash = md5($string);
        $sb = new StringBuilder($string);

        $this->assertEquals($md5Hash, $sb->hash('md5'));
    }

    public function testInsertOnce(): void
    {
        $sb = new StringBuilder('--[]--');
        $sb->insert(3, 'xyz');

        $this->assertEquals('--[xyz]--', $sb->toString());
    }

    public function testInsertMany(): void
    {
        $sb = new StringBuilder('--[]--');
        $sb->insert(3, 'xyz', 2);

        $this->assertEquals('--[xyzxyz]--', $sb->toString());
    }

    public function testInsertOnNegativePosition(): void
    {
        $this->expectException(Exception\OutOfRangeException::class);
        $this->expectExceptionMessage('Index was out of range. Must be non-negative and less than the string length.');

        $sb = new StringBuilder('--[]--');
        $sb->insert(-5, 'xyz');
    }

    public function testInsertOutOfStringLength(): void
    {
        $this->expectException(Exception\OutOfRangeException::class);
        $this->expectExceptionMessage('Index was out of range. Must be non-negative and less than the string length.');

        $sb = new StringBuilder('--[]--');
        $sb->insert(20, 'xyz');
    }

    public function testClone(): void
    {
        $sb1 = new StringBuilder('Lorem');
        $sb2 = $sb1->clone();
        $sb2->clear()->append('Ipsum');

        $this->assertEquals('Lorem', $sb1->toString());
        $this->assertEquals('Ipsum', $sb2->toString());
    }

    public function testRemove(): void
    {
        $sb = new StringBuilder('Lorem ipsum dolor sit amet.');

        $sb->remove(6, 5); // remove "ipsum"

        $this->assertEquals('Lorem  dolor sit amet.', $sb->toString());
    }

    public function testRemoveOnNegativePosition(): void
    {
        $this->expectException(Exception\OutOfRangeException::class);
        $this->expectExceptionMessage('Index was out of range. Must be non-negative and less than the string length.');

        $sb = new StringBuilder('Lorem ipsum dolor sit amet.');
        $sb->remove(-1, 5);
    }

    public function testRemoveOutOfStringLength(): void
    {
        $this->expectException(Exception\OutOfRangeException::class);
        $this->expectExceptionMessage('Index was out of range. Must be non-negative and less than the string length.');

        $sb = new StringBuilder('Lorem ipsum dolor sit amet.');
        $sb->remove(123, 5);
    }

    public function testReplace(): void
    {
        $sb = new StringBuilder('Lorem ipsum dolor. Sit amet.');

        $sb->replace('.', 'sit amet.');

        $this->assertEquals('Lorem ipsum dolorsit amet. Sit ametsit amet.', $sb->toString());
    }
}