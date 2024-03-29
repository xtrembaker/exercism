<?php

declare(strict_types=1);

class LargestSeriesProductTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        require_once 'LargestSeriesProduct.php';
    }

    /**
     * Since PHP can only support Integers between +/- 9223372036854775807
     * We will deal with the series of digits as strings to avoid having them cast to floats.
     */
    public function testCanFindTheLargestProductOf2WithNumbersInOrder(): void
    {
        // The number starts with a 0, qualifying it to be an octal
        // So it needs to be a string so PHP doesn't complain
        $series = new LargestSeriesProduct("0123456789");
        $this->assertEquals(72, $series->largestProduct(2));
    }

    public function testCanFindTheLargestProductOf2(): void
    {
        $series = new LargestSeriesProduct("576802143");
        $this->assertEquals(48, $series->largestProduct(2));
    }

    public function testFindsTheLargestProductIfSpanEqualsLength(): void
    {
        $series = new LargestSeriesProduct("29");
        $this->assertEquals(18, $series->largestProduct(2));
    }

    public function testCanFindTheLargestProductOf3WithNumbersInOrder(): void
    {
        $series = new LargestSeriesProduct("123456789");
        $this->assertEquals(504, $series->largestProduct(3));
    }

    public function testCanFindTheLargestProductOf3(): void
    {
        $series = new LargestSeriesProduct("1027839564");
        $this->assertEquals(270, $series->largestProduct(3));
    }

    public function testCanFindTheLargestProductOf5WithNumbersInOrder(): void
    {
        $series = new LargestSeriesProduct("0123456789");
        $this->assertEquals(15120, $series->largestProduct(5));
    }

    public function testCanGetTheLargestProductOfABigNumber(): void
    {
        $series = new LargestSeriesProduct("73167176531330624919225119674426574742355349194934");
        $this->assertEquals(23520, $series->largestProduct(6));
    }

    public function testCanGetTheLargestProductOfABigNumberProjectEuler(): void
    {
        $digits = "731671765313306249192251196744265747423553491949349698352031277450632623957831801698480186947"
            . "8851843858615607891129494954595017379583319528532088055111254069874715852386305071569329096"
            . "3295227443043557668966489504452445231617318564030987111217223831136222989342338030813533627"
            . "6614282806444486645238749303589072962904915604407723907138105158593079608667017242712188399"
            . "8797908792274921901699720888093776657273330010533678812202354218097512545405947522435258490"
            . "7711670556013604839586446706324415722155397536978179778461740649551492908625693219784686224"
            . "8283972241375657056057490261407972968652414535100474821663704844031998900088952434506585412"
            . "2758866688116427171479924442928230863465674813919123162824586178664583591245665294765456828"
            . "4891288314260769004224219022671055626321111109370544217506941658960408071984038509624554443"
            . "6298123098787992724428490918884580156166097919133875499200524063689912560717606058861164671"
            . "0940507754100225698315520005593572972571636269561882670428252483600823257530420752963450";
        $series = new LargestSeriesProduct($digits);
        $this->assertEquals(23514624000, $series->largestProduct(13));
    }

    public function testReportsZeroIfTheOnlyDigitsAreZero(): void
    {
        $series = new LargestSeriesProduct("0000");
        $this->assertEquals(0, $series->largestProduct(2));
    }

    public function testReportsZeroIfAllSpansIncludeZero(): void
    {
        $series = new LargestSeriesProduct("99099");
        $this->assertEquals(0, $series->largestProduct(3));
    }

    public function testRejectsSpanLongerThanStringLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $series = new LargestSeriesProduct("123");
        $series->largestProduct(4);
    }

    /**
     * There may be some confusion about whether this should be 1 or error.
     * The reasoning for it being 1 is this:
     * There is one 0-character string contained in the empty string.
     * That's the empty string itself.
     * The empty product is 1 (the identity for multiplication).
     * Therefore LSP('', 0) is 1.
     * It's NOT the case that LSP('', 0) takes max of an empty list.
     * So there is no error.
     * Compare against LSP('123', 4):
     * There are zero 4-character strings in '123'.
     * So LSP('123', 4) really DOES take the max of an empty list.
     * So LSP('123', 4) errors and LSP('', 0) does NOT
     *
     */
    public function testReports1ForEmptyStringAndEmptyProduct0Span(): void
    {
        $series = new LargestSeriesProduct("");
        $this->assertEquals(1, $series->largestProduct(0));
    }

    /**
     * As above, there is one 0-character string in '123'.
     * So again no error. It's the empty product, 1.
     */
    public function testReports1ForNonemptyStringAndEmptyProduct0Span(): void
    {
        $series = new LargestSeriesProduct("123");
        $this->assertEquals(1, $series->largestProduct(0));
    }
    public function testRejectsEmptyStringAndNonzeroSpan(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $series = new LargestSeriesProduct("");
        $series->largestProduct(1);
    }

    public function testRejectsInvalidCharacterInDigits(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $series = new LargestSeriesProduct("1234a5");
        $series->largestProduct(2);
    }

    public function testRejectsNegativeSpan(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $series = new LargestSeriesProduct("12345");
        $series->largestProduct(-1);
    }
}