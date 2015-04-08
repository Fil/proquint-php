# proquint-php
pro(nounceable) quint(uplets) in PHP

A PHP implementation of proquint was missing… not that I needed it

link: http://arxiv.org/html/0901.4016


## Usage

```PHP
require_once 'proquint.php';
$proquint = new Proquint;
echo $proquint->Encode(chr(127).chr(0).chr(0).chr(1)); # 'lusab-babad'
echo $proquint->Decode('lusab-babad'); # string of bytes 127,0,0,1
```
