<?php

/*
Copyright (c) 2015  Fil <fil@rezo.net>

Inspired from the GO implementation by Brendan McMillion

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

class proquint {

    private $conse = 'bdfghjklmnprstvz';
    private $vowse = 'aiou';
    private $consd = null;
    private $vowsd = null;
    
    private $exp = "^([abdfghijklmnoprstuvz]{5}-)*[abdfghijklmnoprstuvz]{5}$";


    /**
    * Tests if a given string is a Proquint identifier
    *
    * @param {string} str The candidate string.
    * @return {bool} Whether or not it qualifies.
    */
    public function IsProquint($string) {
        return is_string($string) AND preg_match("/". ($this->exp) ."/S", $string);
    }
    
    /**
    * Encodes an arbitrary byte string into an identifier.
    *
    * @param {string} byte string to encode.
    *
    * @return {string} proquint identifier.
    */
    public function Encode($b) {
        if (!is_string($b)) {
           return false;
        }
        $out = [];
        for ($i = 0; $i < strlen($b); $i += 2) {
            $n = ord($b[$i]) * 256 + ord($b[$i + 1]);

            $c1 = ($n >> 12) & 0x0f;
            $v1 = ($n >> 10) & 0x03;
            $c2 = ($n >>  6) & 0x0f;
            $v2 = ($n >>  4) & 0x03;
            $c3 = ($n >>  0) & 0x0f;

            $out[] = $this->conse[$c1]
            . $this->vowse[$v1]
            . $this->conse[$c2]
            . $this->vowse[$v2]
            . $this->conse[$c3];
        }
        return join('-' , $out);
    }
    
    /**
    * Decodes an identifier into its corresponding byte slice.
    *
    * @param {string} str Identifier to convert.
    *
    * @return {string} The identifier as byte string.
    * @return {boolean} False if not an identifier.
    */
    public function Decode($string) {
        if (!$this->isProquint($string)) {
            return false;
        }
        if (is_null($this->consd)) {
            $this->consd = array_flip(str_split($this->conse));
            $this->vowsd = array_flip(str_split($this->vowse));
        }


        $ret = '';
        foreach( preg_split("/-/", $string) as $b ) {
            $x = ($this->consd[$b[0]] << 12) +
                 ($this->vowsd[$b[1]] << 10) +
                 ($this->consd[$b[2]] <<  6) +
                 ($this->vowsd[$b[3]] <<  4) +
                 ($this->consd[$b[4]] <<  0) ;
            $ret .= chr($x >> 8) . chr($x & 0xff);
        }
        
        return $ret;
    }

}

