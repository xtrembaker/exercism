<?php

declare(strict_types=1);

class SimpleCipher
{
    private const NUMBER_OF_CHAR_IN_ALPHABET = 26;
    private array $alphabet;

    public function __construct(public ?string $key = null)
    {
        $this->key = $key ?? 'kkpescswtdvaxvohyoglcpwqnwkind';

        if(!preg_match('/\A[a-z]+\z/', $this->key)){
            throw new \InvalidArgumentException('Cipher should be alphabetical');
        }

        $this->alphabet = range('a', 'z');
    }

    public function encode(string $plainText): string
    {

        // prevent key to be longer than text, so it do not output the key verbatim
        $key = substr($this->key, 0, strlen($plainText));
        $cypherText = array_map(function($plainTextLetter, $cypherLetter){
            $pos = $this->getLetterPositionInAlphabet($plainTextLetter) + $this->getLetterPositionInAlphabet($cypherLetter);
            return $this->alphabet[$pos % self::NUMBER_OF_CHAR_IN_ALPHABET];
        }, str_split($plainText), str_split($key));
        return implode('', $cypherText);
    }

    public function decode(string $cipherText): string
    {
        // prevent key to be longer than text, so it do not output the key verbatim
        $key = substr($this->key, 0, strlen($cipherText));
        $plainTextLetter = array_map(function($cipherTextLetter, $cipherLetter){
            $pos = $this->getLetterPositionInAlphabet($cipherTextLetter) - $this->getLetterPositionInAlphabet($cipherLetter);
            $pos = ($pos < 0) ? (self::NUMBER_OF_CHAR_IN_ALPHABET + $pos) : $pos;
            return $this->alphabet[($pos % self::NUMBER_OF_CHAR_IN_ALPHABET)];
        }, str_split($cipherText), str_split($key));
        return implode('', $plainTextLetter);
    }

    private function getLetterPositionInAlphabet(string $letter): int
    {
        return array_search($letter, $this->alphabet);
    }
}
