<?php

$implementations = array(
  'ecmascript' => array(
    array(
      'date' => array(1997, 6),
      'id'   => 'es1',
      'marker' => array(
        'href'  => 'http://www.ecma-international.org/publications/files/ECMA-ST-ARCH/ECMA-262,%201st%20edition,%20June%201997.pdf',
        'shape' => 'circle',
        'radius' => 5,
        'title' => 'ECMAScript Edition 1',
        'text' => array(
          'y' => -10,
          'anchor' => 'end',
          'content' => 'ECMAScript Edition 1'
        )
      ),
    ),
    array(
      'date' => array(1999, 5),
      'marker' => array(
        'href'  => 'http://www.ecma-international.org/publications/files/ECMA-ST-ARCH/ECMA-262,%202nd%20edition,%20August%201998.pdf',
        'shape' => 'circle',
        'radius' => 5,
        'title' => 'ECMAScript Edition 2',
        'text' => array(
          'y' => -10,
          'content' => '2'
        )
      ),
    ),

    array(
      'date' => array(1999, 12),
      'marker' => array(
        'href' => 'http://www.ecma-international.org/publications/files/ECMA-ST-ARCH/ECMA-262,%203rd%20edition,%20December%201999.pdf',
        'shape' => 'circle',
        'radius' => 5,
        'title' => 'ECMAScript Edition 3',
        'text' => array(
          'y' => -10,
          'content' => '3'
        )
      )
    ),

    array(
      'date' => array(2000, 6),
      'marker' => array(
        'href' => "http://wayback.archive.org/web/20060924061924/http://www.mozilla.org/js/language/index.html",
        'shape' => 'circle',
        'radius' => 4,
        'title' => 'ECMAScript Edition 3 Final',
        'text' => array(
          'y' => -10,
          'content' => '3 Final'
        )
      )
    ),

    array(
      'date' => array(2000, 12, 2),
      'id' => "es4",
      'marker' => array(
        'href' => "http://wayback.archive.org/web/20070711032912/http://www.mozilla.org/js/language/es4/index.html",
        'shape' => 'circle',
        'radius' => 5,
        'title' => 'ECMAScript Edition 4 Working Draft',
        'text' => array(
          'y' => -10,
          'content' => '4 (<tspan><title>Working Draft</title>WD</tspan>)'
        )
      )
    ),

    array(
      'date' => array(2007, 10, 13),
      'marker' => array(
        'text' => array(
          'y' => 5,
          'class' => "icon",
          'content' => 'X'
        ),
        'title' => 'Website for ECMAScript Ed. 4 proposal went offline'
      )
    ),

    array(
      'date' => array(2008, 8, 13),
      'marker' => array(
        'href' => "https://mail.mozilla.org/pipermail/es-discuss/2008-August/006837.html",
        'title' => '“ECMAScript Harmony” announced',
        'shape' => 'polygon',
        'points' => "-5,-5, 5,0 -5,5",
        'text' => array(
          'x' => 5,
          'y' => -10,
          'content' => '♫'
        )
      )
    ),

    array(
      'date' => array(2009, 12),
      'marker' => array(
        'href' => "http://www.ecma-international.org/publications/files/ECMA-ST-ARCH/ECMA-262%205th%20edition%20December%202009.pdf",
        'shape' => 'circle',
        'radius' => 5,
        'title' => 'ECMAScript Edition 5',
        'text' => array(
          'y' => -10,
          'content' => '5'
        )
      )
    ),

    array(
      'date' => array(2011, 6),
      'marker' => array(
        'href' => "http://www.ecma-international.org/publications/files/ECMA-ST/Ecma-262.pdf",
        'shape' => 'circle',
        'radius' => 4,
        'title' => 'ECMAScript 5.1 Edition',
        'text' => array(
          'y' => -10,
          'content' => '5.1'
        )
      )
    )
  )
);
