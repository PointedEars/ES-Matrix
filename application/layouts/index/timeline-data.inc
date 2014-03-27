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
        'title' => 'Website for ECMAScript Ed. 4 proposal goes offline'
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
    ),

    array(
      'date' => array(2011, 7, 12),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'First ES.next working draft',
        'text' => array(
          'y' => 20,
          'content' => 'ES.next (6)',
          'anchor' => 'start'
        )
      )
    ),
    array(
      'date' => array(2011, 9),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 3',
      )
    ),
    array(
      'date' => array(2011, 11, 7),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 4',
      )
    ),
    array(
      'date' => array(2012, 1, 16),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 5',
      )
    ),
    array(
      'date' => array(2012, 2, 27),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 6',
      )
    ),
    array(
      'date' => array(2012, 5, 4),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 7',
      )
    ),
    array(
      'date' => array(2012, 6, 15),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 8',
      )
    ),
    array(
      'date' => array(2012, 7, 18),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 9',
      )
    ),
    array(
      'date' => array(2012, 9, 27),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 10',
      )
    ),
    array(
      'date' => array(2012, 10, 26),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 11',
      )
    ),
    array(
      'date' => array(2012, 11, 22),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 3,
        'title' => 'ES.next Rev 12',
        'text' => array(
          'y' => 20,
          'content' => 'Rev 12',
          'anchor' => 'start'
        )
      )
    ),
    array(
      'date' => array(2012, 12, 21),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 13',
      )
    ),
    array(
      'date' => array(2013, 3, 8),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 14',
      )
    ),
    array(
      'date' => array(2013, 5, 14),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 15',
      )
    ),
    array(
      'date' => array(2013, 7, 15),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 16',
      )
    ),
    array(
      'date' => array(2013, 8, 23),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 17',
      )
    ),
    array(
      'date' => array(2013, 9, 5),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 18',
      )
    ),
    array(
      'date' => array(2013, 10, 28),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 20',
      )
    ),
    array(
      'date' => array(2013, 11, 8),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 21',
      )
    ),
    array(
      'date' => array(2014, 1, 20),
      'marker' => array(
        'href' => 'http://wiki.ecmascript.org/doku.php?id=harmony:specification_drafts',
        'shape' => 'circle',
        'radius' => 2,
        'title' => 'ES.next Rev 22',
      )
    ),
  ),

//   'javascript' => array(
//     array(
//       'date' => array(2013, 6, 25),
//       'marker' => array(
//         'href'  => 'http://www.mozilla.org/en-US/firefox/22.0/releasenotes/',
//         'shape' => 'circle',
//         'radius' => 5,
//         'title' => 'Firefox 22',
//         'text' => array(
//           'y' => -10,
//           'content' => '22'
//         )
//       ),
//     )
//   )
);
