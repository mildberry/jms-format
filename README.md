# JSON markup structure format
Custom format for generation block structure on the different front-end system

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/674625da-4061-463c-9215-56debb5bceaf/mini.png)](https://insight.sensiolabs.com/projects/674625da-4061-463c-9215-56debb5bceaf)
[![Build Status](https://travis-ci.org/mildberry/jms-format.svg?branch=master)](https://travis-ci.org/mildberry/jms-format)
[![codecov](https://codecov.io/gh/mildberry/jms-format/branch/master/graph/badge.svg)](https://codecov.io/gh/mildberry/jms-format)

Require
=======

- php >= 5.4

Install
=======

Install via composer

``` bash
$ composer require mldberry/jms-format
```

Usage
=====

Loading JMS format from HTML

``` php
<?php

$jsmFormat = new Mildberry\JMSFormat\JMSFormat();
print $jmsFormat->convert('html', 'jms', '<h1>Header</h1><p>text</p>');

```

Output:

``` json
{"version":"v1","content":[{"block":"headline","modifiers":{"weight":"lg"},"content":[{"block":"text","modifiers":[],"content":"Header"}]},{"block":"paragraph","modifiers":[],"content":[{"block":"text","modifiers":[],"content":"text"}]}]}
```

License
=======
This library is under the MIT license. See the complete license in [here](https://github.com/mildberry/jms-format/blob/master/LICENSE)
